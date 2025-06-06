<?php

namespace App\DataTables;

use App\Models\Driver;
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
            ->addColumn('action', function ($item) {
                $view = view('drivers.action', [
                    'item' => $item
                ])->render();
                return $view;
            })
            ->editColumn('created_at', function ($driver) {
                return $driver->created_at->format('Y-m-d');
            })
            ->editColumn('name', function ($driver) {
                return $driver->name . ' ' . $driver->surname;
            })
            ->editColumn('status', function ($driver) {
                $status = $driver->status;
                $html = '';
                if($status){
                    $html = '<p class="activeUser">
                                <span></span>
                                Active
                            </p>';
                }else{
                    $html = '<p class="deactiveUser">
                                <span></span>
                                Deactive
                            </p>';
                }
                return $html;
            })
            ->rawColumns(['action', 'status']);
    }

    public function query(Driver $model)
    {
        $query = $model->newQuery()->orderBy('id', 'desc');
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
            ['data' => 'name', 'title' => 'Ad Soyad'],
            ['data' => 'email', 'title' => 'Mail'],
            ['data' => 'fin', 'title' => 'FİN'],
            ['data' => 'phone', 'title' => 'Əlaqə nömrəsi'],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'Drivers_' . date('YmdHis');
    }
}
