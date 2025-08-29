<?php

namespace App\DataTables;

use App\Models\Brand;
use App\Models\Driver;
use App\Models\Penalty;
use App\Models\Vehicle;
use Yajra\DataTables\Services\DataTable;

class PenaltyDatatable extends DataTable
{
    protected $tableId;

    public function __construct($tableId = 'penalties-table')
    {
        $this->tableId = $tableId;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($item) {
                $view = view('penalties.action', [
                    'item' => $item
                ])->render();
                return $view;
            })
             ->addColumn('penaltyType', function ($item) {
                $penaltyType = $item->penaltyType;
                return $penaltyType?->title;
            })
            ->filterColumn('penaltyType', function ($q, $s) {
                $q->whereHas('penaltyType', function($qq) use($s){
                    $qq->where('title','like',"%$s%");
                });
            })
            ->editColumn('created_at', function ($driver) {
                return $driver->created_at->format('Y-m-d');
            })
            ->editColumn('status', function ($driver) {
                $status = $driver->status;
                $html = '';
                if($status==2){

                  
                    $html = '<p class="paid">
                                <span></span>
                                Ödənilib
                            </p>';
                }elseif($status==1){
                    $html = '<p class="unpaid">
                                <span></span>
                                Ödənilməyib
                            </p>';
                }
                return $html;
            })
            ->rawColumns(['action', 'status']);
    }

    public function query(Penalty $model)
    {
        $query = $model->newQuery()->orderBy('id', 'desc');

     
        if(request()->vehicle){
            $query->where('vehicle_id', request()->vehicle);
        }
        return $query;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('penalties-table')
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
            ['data' => 'date', 'title' => 'Tarix'],
            ['data' => 'penaltyType', 'title' => 'Cərimə adı'],
            ['data' => 'penalty_code', 'title' => 'Cərimə kodu'],
            ['data' => 'amount', 'title' => 'Məbləğ'],
            ['data' => 'status', 'title' => 'Status'],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'Penalties_' . date('YmdHis');
    }

 
}
