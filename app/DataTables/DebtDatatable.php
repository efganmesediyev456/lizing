<?php

namespace App\DataTables;

use App\Models\Credit;
use App\Models\Debt;
use App\Models\Driver;
use Yajra\DataTables\Services\DataTable;

class DebtDatatable extends DataTable
{
    protected $tableId;

    public function __construct($tableId = 'debts-table')
    {
        $this->tableId = $tableId;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($item) {
                $view = view('debts.action', [
                    'item' => $item
                ])->render();
                return $view;
            })
             ->addColumn('state_registration_number', function ($item) {
                return $item->vehicle?->state_registration_number;
            })
            ->addColumn('priceView', function ($item) {
                return $item->price." azn";
            })
            ->filterColumn('state_registration_number', function ($q,$s) {
                return $q->whereHas('vehicle',function($qq) use($s){
                    $qq->where('state_registration_number','like',"%$s%");
                });
            })
            
            ->rawColumns(['action', 'status']);
    }

    public function query(Debt $model)
    {
        $query = $model->newQuery()->orderBy('id', 'desc');
        return $query;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('debts-table')
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
            ['data' => 'date', 'title' => 'Tarix'],
            ['data' => 'tableId', 'title' => 'Table İD'],
            ['data' => 'state_registration_number', 'title' => 'D.Q.N.'],
            ['data' => 'spare_part_title', 'title' => 'Ehtiyyat hissəsinin adı'],
            ['data' => 'priceView', 'title' => 'Qiymət'],
           
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

}
