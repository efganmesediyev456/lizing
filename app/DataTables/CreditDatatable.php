<?php

namespace App\DataTables;

use App\Models\Credit;
use App\Models\Driver;
use Yajra\DataTables\Services\DataTable;

class CreditDatatable extends DataTable
{
    protected $tableId;

    public function __construct($tableId = 'credits-table')
    {
        $this->tableId = $tableId;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($item) {
                $view = view('credits.action', [
                    'item' => $item
                ])->render();
                return $view;
            })
            ->addIndexColumn() 

             ->addColumn('state_registration_number', function ($item) {
                return $item->vehicle?->state_registration_number;
            })
             ->addColumn('model', function ($item) {
                return $item->model?->title;
            })
            ->addColumn('total_payable_loan', function ($item) {
                return $item->total_payable_loan.' azn';
            })
            ->rawColumns(['action', 'status']);
    }

    public function query(Credit $model)
    {
        $query = $model->newQuery();

        $query =$query->orderByRaw('CAST(tableId AS UNSIGNED) ASC');

        return $query;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('credits-table')
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
            ['data' => 'tableId', 'title' => 'Table İD'],
            ['data' => 'state_registration_number', 'title' => 'D.Q.N.'],
            ['data' => 'model', 'title' => 'Model'],
            ['data' => 'code', 'title' => 'Kod'],
            ['data' => 'total_payable_loan', 'title' => 'Ü.Ö.K.'],
            ['data' => 'created_at', 'title' => 'Tarix'],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'credits_' . date('YmdHis');
    }
}
