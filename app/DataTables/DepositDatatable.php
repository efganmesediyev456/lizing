<?php

namespace App\DataTables;

use App\Models\Brand;
use App\Models\City;
use App\Models\Driver;
use App\Models\LeasingStatus;
use App\Models\Model;
use App\Models\OilType;
use App\Models\Payment;
use App\Models\TechnicalReview;
use App\Models\Vehicle;
use Yajra\DataTables\Services\DataTable;

class DepositDatatable extends DataTable
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
            ->addColumn('action', function ($item) {
                $view = view('deposits.action', [
                    'item' => $item
                ])->render();
                return $view;
            })
            ->editColumn('created_at', function ($driver) {
                return $driver->created_at->format('Y-m-d');
            })
            ->addIndexColumn() 
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
                return $item->price.' AZN';
            })
             ->editColumn('creationType', function ($item) {
                return match($item->payment_type){
                    "deposit_admin"=>"Admin",
                    "deposit_debt"=>"Depozit borcu",
                    "deposit_payment"=>"Ilkin Depozit",
                    default=>"Bilinməyən status"
                };
            })
            ->editColumn('fin', function ($item) {
                return $item->driver?->fin;
            })

             ->editColumn('id_card', function ($item) {
                return $item->driver?->id_card_serial_code ;
            })
             ->editColumn('statusView', function ($item) {
                return $item->statusView ;
            })
            ->rawColumns(['action', 'status']);
    }

    public function query(Payment $model)
    {
        $search = request('search') ? request('search')['value'] : '';

        $query = $model->newQuery()->whereIn('payment_type',['deposit_payment','deposit_debt','deposit_admin'])->orderBy('id', 'desc');
        
        if (request()->filled('brand_id')) {
            $brandId = request('brand_id');
            $query = $query->whereHas('leasing.vehicle', function ($q) use ($brandId) {
                $q->where('brand_id', $brandId);
            });
        }
        if (request()->filled('model_id')) {
            $modelId = request('model_id');
            $query = $query->whereHas('leasing.vehicle', function ($q) use ($modelId) {
                $q->where('model_id', $modelId);
            });
        }

        if (request()->filled('status_id')) {
            $query = $query->where('payment_type', request()->status_id);
        }


        if (request()->has('driver_id')) {
            $driverId = request('driver_id');
            $query = $query->where('driver_id', $driverId);
        }

        if (request()->filled('state_registration_number')) {
            $stateRegNumber = request('state_registration_number');
            $query = $query->whereHas('leasing.vehicle', function ($q) use ($stateRegNumber) {
                $q->where('id', "$stateRegNumber");
            });
        }
        

        if (request()->filled('start_created_at')) {
            $query->where('created_at', '>=', request()->start_created_at);
        }

        if (request()->filled('end_created_at')) {
            $query->where('created_at', '<=', request()->end_created_at);
        }

        
       

        return $query;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('deposits_table')
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
            ['data' => 'price', 'title' => 'Depozit'],
            ['data' => 'creationType', 'title' => 'Yaradılma tipi'],
            ['data' => 'fin', 'title' => 'Şəxsiyyət FİN', 'visible'=>false],
            ['data' => 'id_card', 'title' => 'Şəxsiyyətin seriya nömrəsi','visible'=>false],
            ['data' => 'statusView', 'title' => 'Ödəniş statusu','visible'=>false],
            ['data' => 'created_at', 'title' => 'Tarix'],
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
            'statuses' => LeasingStatus::all(),
            'cities' => City::all(),
            'brands'=>Brand::all(),
            'models' => Model::get(),
            'tableIds' => Vehicle::get(),
            'drivers'=>Driver::get(),
            'driverFins'=>Driver::get(),
            'vehicles'=>Vehicle::get()
        ];
    }
}
