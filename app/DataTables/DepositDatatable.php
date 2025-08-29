<?php

namespace App\DataTables;

use App\Models\Brand;
use App\Models\Driver;
use App\Models\Model;
use App\Models\OilType;
use App\Models\Payment;
use App\Models\TechnicalReview;
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
                    "deposit_payment"=>"Depozit",
                    default=>"Bilinməyən status"
                };
            })
            ->rawColumns(['action', 'status']);
    }

    public function query(Payment $model)
    {
        $query = $model->newQuery()->whereIn('payment_type',['deposit_payment','deposit_debt','deposit_admin'])->orderBy('id', 'desc');
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
            ['data' => 'created_at', 'title' => 'Tarix'],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'OilTypes_' . date('YmdHis');
    }
}
