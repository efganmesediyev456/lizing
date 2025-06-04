<?php

namespace App\DataTables;

use Spatie\Permission\Models\Role;
use Yajra\DataTables\Services\DataTable;

class RoleManagementDatatable extends DataTable
{

    protected $tableId;

    public function __construct($tableId = 'role-managements-table')
    {
        $this->tableId = $tableId;
    }


    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($item) {
                $view=view('role-managements.action', [
                    'item'=>$item
                ])->render();
                return $view;
            })
            ->editColumn('name', function ($item) {
                return $item->name;
            })
            ->editColumn('status', function ($item) {
                $status = $item->status;
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

    public function query(Role $model)
    {
        $query = $model->newQuery()->orderBy('id', 'desc');

        return $query;
    }


    public function html()
    {
        return $this->builder()
            ->setTableId('role-managements-table')
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
            ['data' => 'name', 'title' => 'Rolun adı'],
            ['data' => 'status', 'title' => 'Status'],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'RoleManagements_' . date('YmdHis');
    }
}
