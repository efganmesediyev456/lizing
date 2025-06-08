<?php

namespace App\DataTables;

use App\Models\Brand;
use App\Models\Driver;
use App\Models\Model;
use App\Models\OilType;
use App\Models\TechnicalReview;
use Yajra\DataTables\Services\DataTable;

class OilTypeDatatable extends DataTable
{
    protected $tableId;

    public function __construct($tableId = 'oil-types')
    {
        $this->tableId = $tableId;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($item) {
                $view = view('oil_types.action', [
                    'item' => $item
                ])->render();
                return $view;
            })
            ->editColumn('created_at', function ($driver) {
                return $driver->created_at->format('Y-m-d');
            })
            ->editColumn('status', function ($driver) {
                $status = $driver->status;
                $html = '';
                 if($status){
                    $html = '<p class="activeOil">
                                <span></span>
                                Active
                            </p>';
                }else{
                    $html = '<p class="deactiveOil">
                                <span></span>
                                Deactive
                            </p>';
                }
                return $html;
            })
            ->rawColumns(['action', 'status']);
    }

    public function query(OilType $model)
    {
        $query = $model->newQuery()->orderBy('id', 'desc');
        return $query;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('oil-types')
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
            ['data' => 'title', 'title' => 'Ad'],
            ['data' => 'status', 'title' => 'Status'],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'OilTypes_' . date('YmdHis');
    }
}
