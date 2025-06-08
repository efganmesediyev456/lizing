<?php

namespace App\DataTables;

use App\Models\Brand;
use App\Models\Driver;
use App\Models\Insurance;
use App\Models\Model;
use App\Models\TechnicalReview;
use Yajra\DataTables\Services\DataTable;

class InsurancesDatatable extends DataTable
{
    protected $tableId;

    public function __construct($tableId = 'insurances')
    {
        $this->tableId = $tableId;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($item) {
                $view = view('insurances.action', [
                    'item' => $item
                ])->render();
                return $view;
            })
            ->editColumn('created_at', function ($driver) {
                return $driver->created_at->format('Y-m-d');
            })

            ->editColumn('brand_id', function ($driver) {
                return $driver->brand?->title;
            })
             ->editColumn('vehicle_id', function ($driver) {
                return $driver->vehicle?->state_registration_number;
            })
             ->editColumn('model_id', function ($driver) {
                return $driver->model?->title;
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

    public function query(Insurance $model)
    {
        $query = $model->newQuery()->orderBy('id', 'desc');
        return $query;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('insurances')
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
            ['data' => 'brand_id', 'title' => 'Marka'],
            ['data' => 'model_id', 'title' => 'Model'],
            ['data' => 'vehicle_id', 'title' => 'D.Q.N.'],
            ['data' => 'start_date', 'title' => 'Başlama tarixi'],
            ['data' => 'end_date', 'title' => 'Bitmə tarixi'],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'Insurances_' . date('YmdHis');
    }
}
