<?php

namespace App\DataTables;

use App\Models\Brand;
use App\Models\Driver;
use App\Models\Model;
use App\Models\OilChange;
use App\Models\TechnicalReview;
use Yajra\DataTables\Services\DataTable;

class OilChangeDatatable extends DataTable
{
    protected $tableId;

    public function __construct($tableId = 'oil-changes')
    {
        $this->tableId = $tableId;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($item) {
                $view = view('oil_changes.action', [
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

             ->filterColumn('vehicle_id', function ($q,$s) {
                $q->whereHas('vehicle', function($qq) use($s){
                    $qq->where('state_registration_number','like',"%$s%");
                });
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

    public function query(OilChange $model)
    {
        $query = $model->newQuery()->orderBy('id', 'desc');
        return $query;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('oil_changes')
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
            ['data' => 'id', 'title' => 'No:'],
            ['data' => 'tableId', 'title' => 'Table İD'],
            ['data' => 'vehicle_id', 'title' => 'D.Q.N.'],
            ['data' => 'change_interval', 'title' => 'Y.D. km'],
            ['data' => 'next_change_interval', 'title' => 'N.Y.D.'],
            ['data' => 'status', 'title' => 'Status'],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'OilChanges_' . date('YmdHis');
    }
}
