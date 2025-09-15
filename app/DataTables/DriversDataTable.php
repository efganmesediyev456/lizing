<?php

namespace App\DataTables;

use App\Models\City;
use App\Models\Driver;
use App\Models\DriverStatus;
use Yajra\DataTables\Services\DataTable;

class DriversDataTable extends DataTable
{
    protected $tableId;


    public function __construct($tableId = 'drivers-table')
    {
        $this->tableId = $tableId;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function ($item) {
                $view = view('drivers.action', [
                    'item' => $item
                ])->render();
                return $view;
            })
            ->editColumn('created_at', function ($driver) {
                return $driver->created_at->format('Y-m-d');
            })
            ->addColumn('city', function ($driver) {
                return $driver->city?->title;
            })
            ->editColumn('name', function ($driver) {
                return $driver->name . ' ' . $driver->surname;
            })
            ->editColumn('date', function ($driver) {
                return $driver->date?->format('Y-m-d');
            })
            ->addColumn('debt', function ($driver) {
                return $driver->debt > 0 ? '<span style="color:red;">' . $driver->debt . '</span>' : 0;
            })

            ->addColumn('deposit_payment', function ($driver) {
                return $driver->leasing?->deposit_payment > 0 ? '<span style="color:red;">' . $driver->leasing?->deposit_payment . '</span>' : 0;
            })

            ->addColumn('deposit_debt', function ($driver) {
                return $driver->leasing?->deposit_debt > 0 ? '<span style="color:red;">' . $driver->leasing?->deposit_debt . '</span>' : 0;
            })

            ->editColumn('gender', function ($driver) {
                return match ($driver->gender) {
                    0 => 'Kişi',
                    1 => 'Qadın',
                    default => 'Naməlum',
                };
            })

            ->editColumn('phone2', function ($driver) {
                if($driver->phone2){
                    return '<strong>' . ($driver->phone2_label ?? 'Əlaqə nömrəsi 2') . ':</strong> ' . $driver->phone2;
                }
                return null;
            })
            ->editColumn('phone3', function ($driver) {
                if($driver->phone3){
                    return '<strong>' . ($driver->phone3_label ?? 'Əlaqə nömrəsi 3') . ':</strong> ' . $driver->phone3;
                }
                return null;
            })
            ->editColumn('phone4', function ($driver) {
                if($driver->phone4){
                    return '<strong>' . ($driver->phone4_label ?? 'Əlaqə nömrəsi 4') . ':</strong> ' . $driver->phone4;
                }
                return null;
            })


            ->editColumn('phone', function ($driver) {
                $phones = [];

                if ($driver->phone) {
                    $phones[] = '<strong>Əsas nömrə:</strong> ' . $driver->phone;
                    // $phones[] = $driver->phone;
                }

                // if ($driver->phone2) {
                //     $phones[] = '<strong>' . ($driver->phone2_label ?? 'Əlaqə nömrəsi 2') . ':</strong> ' . $driver->phone2;
                // }
    
                // if ($driver->phone3) {
                //     $phones[] = '<strong>' . ($driver->phone3_label ?? 'Əlaqə nömrəsi 3') . ':</strong> ' . $driver->phone3;
                // }
    
                // if ($driver->phone4) {
                //     $phones[] = '<strong>' . ($driver->phone4_label ?? 'Əlaqə nömrəsi 4') . ':</strong> ' . $driver->phone4;
                // }
    
                return implode('<br>', $phones);
            })

            ->editColumn('status', function ($driver) {
                $status = $driver->status;
                $html = '';
                if ($status) {
                    $html = '<p class="activeUser">
                                <span></span>
                                Active
                            </p>';
                } else {
                    $html = '<p class="deactiveUser">
                                <span></span>
                                Deactive
                            </p>';
                }
                return $html;
            })
            ->rawColumns(['action', 'status', 'phone','phone2','phone3','phone4', 'debt', 'deposit_payment', 'deposit_debt']);
    }

    public function query(Driver $model)
    {

        $search = request('search') ? request('search')['value'] : '';

        $query = $model->newQuery()->when($search, function ($q) use ($search) {
            $q->where('tableId', 'like', '%' . $search . '%')->
                orWhere('name', 'like', "%$search%")
                ->orWhere('surname', 'like', "$search")
                ->orWhere('phone', 'like', "$search")
                ->orWhere('fin', 'like', "$search");
        });

        if (request()->has('gender')) {
            $gender = request('gender');
            $query = $query->where('gender', $gender);
        }


        if (request()->has('status_id') and request()->filled('status_id')) {
            if (request()->status_id == 'all') {

            } else {
                $query = $query->where('status_id', request()->status_id);
            }
        }

        $query->orderByRaw('CAST(tableId AS UNSIGNED) ASC');


        return $query;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('drivers-table')
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
            ['data' => 'tableId', 'title' => 'Table İD', 'visible' => false],
            ['data' => 'name', 'title' => 'Ad Soyad'],
            ['data' => 'father_name', 'title' => 'Ata adı'],
            ['data' => 'debt', 'title' => 'Leasing Borcu'],
            ['data' => 'deposit_payment', 'title' => 'Ilkin Deposit Borcu'],
            ['data' => 'deposit_debt', 'title' => 'Deposit Borcu'],
            ['data' => 'fin', 'title' => 'FİN', 'visible' => false],
            ['data' => 'email', 'title' => 'Email', 'visible' => false],
            ['data' => 'id_card_serial_code', 'title' => 'Şəxsiyyətin seriya nömrəsi', 'visible' => false],
            ['data' => 'current_address', 'title' => 'Faktiki yaşadığı ünvan', 'visible' => false],
            ['data' => 'registered_address', 'title' => 'Qeydiyyatda olduğu ünvan', 'visible' => false],
            ['data' => 'date', 'title' => 'Doğum Tarixi', 'visible' => false],
            ['data' => 'gender', 'title' => 'Cinsiyyət', 'visible' => false],
            ['data' => 'city', 'title' => 'Şəhər', 'visible' => false],
            ['data' => 'phone', 'title' => 'Əlaqə nömrəsi'],
            ['data' => 'phone2', 'title' => 'Əlaqə nömrəsi2', 'visible'=>false],
            ['data' => 'phone3', 'title' => 'Əlaqə nömrəsi3','visible'=>false],
            ['data' => 'phone4', 'title' => 'Əlaqə nömrəsi4','visible'=>false],

            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }


    public function getFilterOptions()
    {
        return [
            'statuses' => DriverStatus::all(),
            'cities' => City::all(),
        ];
    }
}
