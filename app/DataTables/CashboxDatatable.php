<?php

namespace App\DataTables;

use App\Helpers\CashboxHelper;
use App\Models\City;
use App\Models\Driver;
use Yajra\DataTables\Services\DataTable;

class CashboxDatatable extends DataTable
{
    protected $tableId;

    public function __construct($tableId = 'cashbox-table')
    {
        $this->tableId = $tableId;
    }

    public function dataTable($query)
    {
        return datatables()
            ->collection($query)
            ->addColumn('action', function ($item) {
                $view = view('cashbox.action', [
                    'item' => $item
                ])->render();
                return $view;
            })
            ->addIndexColumn() 
            ->editColumn('created_at', function ($item) {
                return $item->created_at?->format('d.m.Y');
            })
            ->addColumn('state_registration_number', function ($item) {
                if ($item->model == 'payment') {
                    return $item->leasing?->vehicle?->state_registration_number;
                }
                return $item->vehicle?->state_registration_number;
            })
            ->editColumn('status', function ($driver) {
                $status = $driver->status;
                $html = '';
                if ($status) {
                    $html = '<p class="activeModel">
                                <span></span>
                                Active
                            </p>';
                } else {
                    $html = '<p class="deactiveModel">
                                <span></span>
                                Deactive
                            </p>';
                }
                return $html;
            })
            ->rawColumns(['action', 'status'])
            ->with(['total_price' => $this->totalPrice, 'totalExpense'=>$this->totalExpense, 'totalIncome'=>$this->totalIncome]);
    }

    public function query(CashboxHelper $model)
    {
        $query = $model->all();
        return $query;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('cities-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'paging' => true,
                'info' => false,
                'searching' => true,
                'ordering' => false,
                'buttons' => []
            ])
            ->dom('Bfrtip')
            ->orderBy(0);
    }

    protected function getColumns()
    {
        return [
            ['data' => 'DT_RowIndex', 'title' => 'No:', 'orderable' => false, 'searchable' => false],
            ['data' => 'tableId', 'title' => 'Table İD'],
            ['data' => 'state_registration_number', 'title' => 'D.Q.N.'],
            ['data' => 'category', 'title' => 'Kateqoriya'],
            ['data' => 'type', 'title' => 'Növ'],
            ['data' => 'price', 'title' => 'Məbləğ'],
            ['data' => 'created_at', 'title' => 'Tarix'],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'cities_' . date('YmdHis');
    }
}
