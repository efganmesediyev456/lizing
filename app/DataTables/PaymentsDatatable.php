<?php

namespace App\DataTables;

use App\Models\Brand;
use App\Models\Driver;
use App\Models\Model;
use App\Models\OilType;
use App\Models\Payment;
use App\Models\TechnicalReview;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;

class PaymentsDatatable extends DataTable
{
    protected $tableId;

    public function __construct($tableId = 'payments')
    {
        $this->tableId = $tableId;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()

            ->addColumn('action', function ($item) {
                $view = view('payments.action', [
                    'item' => $item
                ])->render();
                return $view;
            })
            ->editColumn('created_at', function ($driver) {
                return $driver->created_at->format('Y-m-d');
            })
            ->addColumn('driver', function ($item) {
                return $item->driver?->fullName;
            })
            ->addColumn('brand', function ($item) {
                return $item->leasing?->vehicle?->brand?->title;
            })
            ->addColumn('model', function ($item) {
                return $item->leasing?->vehicle?->model?->title;
            })
            ->addColumn('model', function ($item) {
                return $item->leasing?->vehicle?->model?->title;
            })
            ->addColumn('state_registration_number', function ($item) {
                return $item->leasing?->vehicle?->state_registration_number;
            })
            ->editColumn('price', function ($item) {
                return $item->price . ' AZN';
            })
             ->editColumn('payment_type', function ($item) {
                return $item->payment_back_or_app==0 ? 'Onlayn' : ($item->payment_back_or_app==1 ? 'Nağd' : '');
            })
            ->addColumn('paymentTypeView', function ($item) {
                return match ($item->payment_type) {
                    'deposit_debt' => 'depozit',
                    'deposit_payment' => 'ilkin depozit',
                    'monthly' => 'aylıq',
                    'daily' => 'günlük',
                    "deposit_admin" => "Admin",
                    default => "Bilinməyən status"
                };
            })
            ->with(['total_price' => $this->totalPrice])

            ->rawColumns(['action', 'status']);
    }

    public function query(Payment $model)
    {
        $query = $model->newQuery()
            ->with(['driver', 'leasing.vehicle.brand', 'leasing.vehicle.model']);

        $search = request('search') ? request('search')['value'] : '';

        if (request()->has('start_date') && request()->has('end_date')) {
            $startDate = request('start_date');
            $endDate = request('end_date');

            $endDate = Carbon::parse($endDate)->endOfDay();

            $query = $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if (request()->has('payment_type')) {
            $paymentType = request('payment_type');
            if ($paymentType == 'deposit_admin') {
                $query = $query->where('payment_back_or_app', 1);

            } else {
                $query = $query->where('payment_type', $paymentType);

            }
        }

        if (request()->has('payment_online_or_back')) {
            $paymentType = request('payment_online_or_back');
            if ($paymentType == 'deposit_admin') {
                $query = $query->where('payment_back_or_app', 1);

            } else if ($paymentType == 'deposit_driver') {
                $query = $query->where('payment_back_or_app', 0);

            }
        }

        // Marka filtrası
        if (request()->has('brand_id')) {
            $brandId = request('brand_id');
            $query = $query->whereHas('leasing.vehicle', function ($q) use ($brandId) {
                $q->where('brand_id', $brandId);
            });
        }

        if (request()->has('model_id')) {
            $modelId = request('model_id');
            $query = $query->whereHas('leasing.vehicle', function ($q) use ($modelId) {
                $q->where('model_id', $modelId);
            });
        }

        if (request()->has('driver_id')) {
            $driverId = request('driver_id');
            $query = $query->where('driver_id', $driverId);
        }

        if (request()->has('state_registration_number')) {
            $stateRegNumber = request('state_registration_number');
            $query = $query->whereHas('leasing.vehicle', function ($q) use ($stateRegNumber) {
                $q->where('state_registration_number', 'like', "%{$stateRegNumber}%");
            });
        }



        $query = $query->
            when($search, function ($q) use ($search) {
                $searchMap = [
                    'depozit' => 'deposit_debt',
                    'ilkin depozit' => 'deposit_payment',
                    'aylıq' => 'monthly',
                    'günlük' => 'daily',
                    'admin' => 'deposit_admin'
                ];

                $matchedTypes = collect($searchMap)
                    ->filter(function ($originalType, $displayType) use ($search) {
                        return stripos($displayType, $search) !== false;
                    })
                    ->values()
                    ->toArray();



                $q->whereHas('driver', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('surname', 'like', "%$search%");
                })->orWhereHas('leasing.vehicle', function ($q) use ($search) {
                    $q->where('state_registration_number', 'like', "%$search%")
                        ->orWhereHas('brand', function ($q) use ($search) {
                            $q->where('title', 'like', "%$search%");
                        })->orWhereHas('model', function ($q) use ($search) {
                            $q->where('title', 'like', "%$search%");
                        });
                })->orWhere('price', 'like', "%{$search}%")
                    //   ->orWhere('payment_type', 'like', "%{$search}%")
                    ->orWhere('created_at', 'like', "%{$search}%")->
                    orWhereIn('payment_type', $matchedTypes);

            })->
            orderBy('id', 'desc');




        $total = $query->get()->reduce(function ($carry, $item) {
            $numeric = (int) str_replace(['+', '-', 'azn', ' '], '', $item->price);
            $sign = str_starts_with($item->price, '-') ? -1 : 1;
            return $carry + ($numeric * $sign);
        }, 0);
        $this->totalPrice = $total;

        return $query;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('payments')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'paging' => true,
                'info' => false,
                'searching' => true,
                'ordering' => false,
                'responsive' => true,
                'autoWidth' => false,
                'scrollX' => true,
                'scrollY' => '',
                'pageLength' => 100,
                'buttons' => [
                    ['extend' => 'colvis', 'text' => 'Sütunları Göstər/Gizlə']
                ]
            ])
            ->dom('Bfrtip')

            ->orderBy(0);
    }

    protected function getColumns()
    {
        return [
            ['data' => 'DT_RowIndex', 'title' => 'No:', 'orderable' => false, 'searchable' => false],
            ['data' => 'driver', 'title' => 'Ad soyad'],
            ['data' => 'brand', 'title' => 'Marka'],
            ['data' => 'model', 'title' => 'Model'],
            ['data' => 'state_registration_number', 'title' => 'DQN'],
            ['data' => 'price', 'title' => 'Ödəniş'],
            ['data' => 'paymentTypeView', 'title' => 'Ödəniş növü'],
            ['data' => 'created_at', 'title' => 'Tarix','visible'=>false],
            ['data' => 'payment_type', 'title' => 'Ödəniş tipi'],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'OilTypes_' . date('YmdHis');
    }



    public function getFilterOptions()
    {
        return [
            'payment_types' => [
                'deposit_debt' => 'Depozit',
                'deposit_payment' => 'İlkin Depozit',
                'monthly' => 'Aylıq',
                'daily' => 'Günlük',
            ],
            'payment_online_or_back' => [
                'deposit_admin' => 'Nağd',
                'deposit_driver' => 'Onlayn',
            ],
            'brands' => Brand::all(),
            'models' => Model::all(),
            'drivers' => Driver::all()
        ];
    }
}
