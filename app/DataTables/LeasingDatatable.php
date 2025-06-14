<?php

namespace App\DataTables;

use App\Models\Brand;
use App\Models\Driver;
use App\Models\Insurance;
use App\Models\Leasing;
use App\Models\Model;
use App\Models\TechnicalReview;
use Yajra\DataTables\Services\DataTable;

class LeasingDatatable extends DataTable
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
                $view = view('leasings.actions', [
                    'item' => $item
                ])->render();
                return $view;
            })
            ->editColumn('driver_id', function ($item) {
                return $item->driver?->name.' '.$item->driver?->surname;
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
        $query = $model->newQuery()->orderBy('id', 'desc');
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
                'buttons'  => []
            ])
            ->dom('Bfrtip')
            ->orderBy(0);
    }

    protected function getColumns()
    {
        return [
            ['data' => 'id', 'title' => 'No:'],
            ['data' => 'tableId', 'title' => 'Table İD'],
            ['data' => 'driver_id', 'title' => 'Ad soyad'],
            ['data' => 'model_id', 'title' => 'Model'],
            ['data' => 'brand_id', 'title' => 'Marka'],
            ['data' => 'dqn', 'title' => 'D.Q.N.'],
            ['data' => 'fin', 'title' => 'FİN'],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'Leasings_' . date('YmdHis');
    }
}
