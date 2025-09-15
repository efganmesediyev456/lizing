<?php

namespace App\DataTables;

use App\Models\Brand;
use App\Models\City;
use App\Models\Driver;
use App\Models\Insurance;
use App\Models\Leasing;
use App\Models\LeasingStatus;
use App\Models\Model;
use App\Models\TechnicalReview;
use App\Models\Vehicle;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Column;

class LeasingPassivDatatable extends DataTable
{
    protected $tableId;

    public function __construct($tableId = 'leasings')
    {
        $this->tableId = $tableId;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($item) {
                $view = view('passiv_leasing.actions', [
                    'item' => $item
                ])->render();
                return $view;
            })
            ->addIndexColumn() 
            ->editColumn('driver_id', function ($item) {
                return $item->passiveReason->first()?->driver?->fullName;
            })
            ->editColumn('model_id', function ($item) {
                return $item->model?->title;
            })
            ->editColumn('brand_id', function ($item) {
                return $item->brand?->title;
            })
            ->addColumn('dqn', function ($item) {
                return $item->vehicle?->state_registration_number;
            })
            ->addColumn('fin', function ($item) {
                return $item->driver?->fin;
            })
            ->editColumn('tableId', function ($item) {
                return $item->vehicle?->table_id_number;
            })
             ->addColumn('leasingStatus', function ($item) {
                return $item->leasingStatus?->title ?? 'Status yoxdur';
            })
             ->editColumn('start_date', function ($item) {
                return $item->start_date?->format('Y-m-d');
            })
            ->editColumn('end_date', function ($item) {
                return $item->end_date?->format('Y-m-d');
            })
             ->editColumn('has_advertisement', function ($item) {
                return match($item->has_advertisement){
                    0 =>'Xeyr',
                    1=>'Bəli',
                    default=>'N/A'
                };
            })
            ->editColumn('payment_type', function ($item) {
                return match($item->payment_type){
                    "daily" =>'Gündəlik',
                    "monthly"=>'Aylıq',
                    default=>'N/A'
                };
            })
            ->editColumn('status', function ($driver) {
                $status = $driver->status;
                $html = '';
                if($status){
                    $html = '<p class="activeModel">
                                <span></span>
                                Active
                            </p>';
                }else{
                    $html = '<p class="deactiveModel">
                                <span></span>
                                Deactive
                            </p>';
                }
                return $html;
            })
            ->rawColumns(['action', 'status']);
    }

    public function query(Leasing $model)
    {
        $passiveStatus = LeasingStatus::where('is_passive',1)->first();
        $query = $model->newQuery() ->with([
            'driver', 
            'vehicle', 
            'leasingStatus'
        ])->where('leasing_status_id', $passiveStatus->id);

         if(request()->filled('brand_id')){
            $query->where('brand_id', request()->brand_id);
        }
        if(request()->filled('model_id')){
            $query->where('model_id', request()->model_id);
        }
        if(request()->filled('status_id')){
            $query->where('leasing_status_id', request()->status_id);
        }
        if(request()->filled('driver_id')){
            $query->where('driver_id', request()->driver_id);
        }

        if(request()->filled('table_id_number')){
            $query->where('tableId', request()->table_id_number);
        }
        if(request()->filled('state_registration_number')){
            $query->where('vehicle_id', request()->state_registration_number);
        }
        if(request()->filled('has_advertisement')){
            $query->where('has_advertisement', request()->has_advertisement);
        }

        if(request()->filled('payment_type')){
            $query->where('payment_type', request()->payment_type);
        }

        if (request()->filled('start_date')) {
            $query->where('start_date', '>=', request()->start_date);
        }

        if (request()->filled('end_date')) {
            $query->where('end_date', '<=', request()->end_date);
        }

        $query =$query->orderByRaw('CAST(tableId AS UNSIGNED) ASC');
        
        return $query;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('leasings')
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
            // ['data' => 'id', 'title' => 'No:'],
            ['data' => 'tableId', 'title' => 'Table İD'],
            ['data' => 'driver_id', 'title' => 'Ad soyad'],
            ['data' => 'model_id', 'title' => 'Model'],
            ['data' => 'brand_id', 'title' => 'Marka'],
            ['data' => 'dqn', 'title' => 'D.Q.N.'],
            ['data' => 'fin', 'title' => 'FİN'],
            ['data' => 'leasingStatus', 'title' => 'Lizinq Statusu'],
            ['data' => 'has_advertisement', 'title' => 'Reklam', 'visible' => false],
            ['data' => 'deposit_price', 'title' => 'Depozit qiyməti', 'visible' => false],
            ['data' => 'deposit_payment', 'title' => 'Depozit ilkin ödənişi', 'visible' => false],
            ['data' => 'deposit_debt', 'title' => 'Depozit borcu', 'visible' => false],
            ['data' => 'leasing_price', 'title' => 'Lizing qiyməti', 'visible' => false],
            ['data' => 'payment_type', 'title' => 'Ödəniş tipi', 'visible' => false],
            ['data' => 'daily_payment', 'title' => 'Günlük ödəniş', 'visible' => false],
            ['data' => 'monthly_payment', 'title' => 'Aylıq ödəniş', 'visible' => false],
            ['data' => 'leasing_period_days', 'title' => 'Lizing müddəti (gün)', 'visible' => false],
            ['data' => 'leasing_period_months', 'title' => 'Lizing müddəti (ay)', 'visible' => false],
            ['data' => 'start_date', 'title' => 'Başlama tarixi', 'visible' => false],
            ['data' => 'end_date', 'title' => 'Bitmə tarixi', 'visible' => false],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'Leasings_' . date('YmdHis');
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
