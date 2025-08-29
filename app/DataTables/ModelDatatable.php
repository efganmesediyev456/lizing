<?php

namespace App\DataTables;

use App\Models\Brand;
use App\Models\Driver;
use App\Models\Model;
use Yajra\DataTables\Services\DataTable;

class ModelDatatable extends DataTable
{
    protected $tableId;

    public function __construct($tableId = 'models-table')
    {
        $this->tableId = $tableId;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($item) {
                $view = view('models.action', [
                    'item' => $item
                ])->render();
                return $view;
            })
            ->addIndexColumn() 
            ->editColumn('created_at', function ($driver) {
                return $driver->created_at->format('Y-m-d');
            })

            ->editColumn('brand_id', function ($driver) {
                return $driver->brand?->title;
            })
             ->editColumn('ban_type_id', function ($driver) {
                return $driver->banType?->title;
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
            })->filterColumn("ban_type_id", function($query, $search){
                $query->whereHas('banType', function($q) use($search){
                    $q->where('title','like','%'.$search.'%');
                });
            })
            ->filterColumn("brand_id", function($q, $search){
                $q->whereHas('brand', function($qq) use($search){
                    $qq->where('title','like',"%$search%");
                });
            })
            ->rawColumns(['action', 'status']);
    }

    public function query(Model $model)
    {
        $query = $model->newQuery();
        $query=$query->orderBy('id', 'desc');
        return $query;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('models-table')
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
            ['data' => 'brand_id', 'title' => 'Marka'],
            ['data' => 'title', 'title' => 'Model'],
            ['data' => 'ban_type_id', 'title' => 'Ban növü'],
            ['data' => 'status', 'title' => 'Status'],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'Models_' . date('YmdHis');
    }
}
