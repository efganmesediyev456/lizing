<?php

namespace App\DataTables;

use App\Models\BanType;
use App\Models\Brand;
use App\Models\Driver;
use Yajra\DataTables\Services\DataTable;

class BanTypeDatatable extends DataTable
{
    protected $tableId;

    public function __construct($tableId = 'ban-types-table')
    {
        $this->tableId = $tableId;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($item) {
                $view = view('ban-types.action', [
                    'item' => $item
                ])->render();
                return $view;
            })
                     ->addIndexColumn() 

            ->editColumn('status', function ($driver) {
                $status = $driver->status;
                $html = '';
                if($status){
                    $html = '<p class="activeBan">
                                <span></span>
                                Active
                            </p>';
                }else{
                    $html = '<p class="deactiveBan">
                                <span></span>
                                Deactive
                            </p>';
                }
                return $html;
            })
            ->rawColumns(['action', 'status']);
    }

    public function query(BanType $model)
    {
        $query = $model->newQuery()->orderBy('id', 'desc');
       

        return $query;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('ban-types-table')
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
            ['data' => 'title', 'title' => 'Ban növü'],
            ['data' => 'status', 'title' => 'Status'],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'BanTypes_' . date('YmdHis');
    }
}
