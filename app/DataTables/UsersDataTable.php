<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{

    protected $tableId;

    public function __construct($tableId = 'users-table')
    {
        $this->tableId = $tableId;
    }


    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($item) {
                $view=view('users.action', [
                    'item'=>$item
                ])->render();
                return $view;
            })
            ->editColumn('created_at', function ($user) {
                return $user->created_at->format('Y-m-d');
            })
            ->editColumn('name', function ($user) {
                return $user->name.' '.$user->surname;
            })
            ->editColumn('status', function ($user) {
                $status = $user->status;
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

    public function query(User $model)
    {
        $query = $model->newQuery()->orderBy('id', 'desc');


        return $query;
    }


    public function html()
    {
        return $this->builder()
            ->setTableId('users-table')
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
            ['data' => 'id', 'title' => 'NO:'],
            ['data' => 'created_at', 'title' => 'Tarix'],
            ['data' => 'name', 'title' => 'Ad Soyad'],
            ['data' => 'email', 'title' => 'Mail'],
            ['data' => 'fin', 'title' => 'FİN'],
            ['data' => 'status', 'title' => 'Status'],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
