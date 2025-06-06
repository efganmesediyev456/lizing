<?php

namespace App\DataTables;

use App\Models\Vehicle;
use Yajra\DataTables\Services\DataTable;

class VehiclesDataTable extends DataTable
{
    protected $tableId;

    public function __construct($tableId = 'vehicles-table')
    {
        $this->tableId = $tableId;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($item) {
                $view = view('vehicles.action', [
                    'item' => $item
                ])->render();
                return $view;
            })
            ->editColumn('created_at', function ($vehicle) {
                return $vehicle->created_at->format('Y-m-d');
            })
            ->editColumn('brand_id', function ($vehicle) {
                return $vehicle->brand?->title;
            })
             ->editColumn('model_id', function ($vehicle) {
                return $vehicle->model?->title;
            })
            ->editColumn('status', function ($vehicle) {
                $status = $vehicle->status;
                $html = '';
                if($status){
                    $html = '<p class="inDrive">
                                <span></span>
                                Active
                            </p>';
                }else{
                    $html = '<p class="idle">
                                <span></span>
                                        Deactive
                            </p>';
                }
                return $html;
            })
            ->rawColumns(['action', 'status']);
    }

    public function query(Vehicle $model)
    {
        $query = $model->newQuery()->orderBy('id', 'desc');
        return $query;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('vehicles-table')
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
            ['data' => 'table_id_number', 'title' => 'Table İD'],
             ['data' => 'brand_id', 'title' => 'Marka'],
            ['data' => 'model_id', 'title' => 'Model'],
            ['data' => 'state_registration_number', 'title' => 'D.Q.N'],
            ['data' => 'status', 'title' => 'Status'],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'Vehicles_' . date('YmdHis');
    }
}
