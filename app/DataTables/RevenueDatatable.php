<?php

namespace App\DataTables;

use App\Models\Brand;
use App\Models\Driver;
use App\Models\LeasingPayment;
use App\Models\Payment;
use App\Models\PenaltyType;
use Yajra\DataTables\Services\DataTable;

class RevenueDatatable extends DataTable
{
    protected $tableId;

    public function __construct($tableId = 'revenues-table')
    {
        $this->tableId = $tableId;
    }

    public function dataTable($query)
    {
        return datatables()
            ->collection($query)
            ->addColumn('action', function ($item) {
                $view = view('revenues.action', [
                    'item' => $item
                ])->render();
                return $view;
            })
            ->addIndexColumn() 

            ->addColumn('fullName', function ($item) {
                return $item->leasing?->driver?->fullName;
            })
            ->addColumn('price', function ($item) {
                return $item->price;
            })

            ->addColumn('state_registration_number', function ($item) {
                return $item->leasing?->vehicle?->state_registration_number;
            })
            ->with(['total_price' => $this->totalPrice])

            ->rawColumns(['action', 'status']);
    }

    public function query()
    {
        $items = Payment::where('status','completed')->get();


        if ($search = request()->get('search')['value'] ?? null) {
            $items = $items->filter(function($item) use ($search) {
                $fullName = $item->leasing?->driver?->fullName ?? '';
                $state_registration_number = $item->leasing?->vehicle?->state_registration_number;
                return stripos($fullName, $search) !== false
                    || stripos($item->updated_at, $search) !== false
                    || stripos($state_registration_number, $search) !== false;
            });
        }

        $totalPrice = $items->reduce(function ($carry, $item) {
            $numeric = (int) str_replace(['+', '-', 'azn', ' '], '', $item->price);
            $sign = str_starts_with($item->price, '-') ? -1 : 1;
            return $carry + ($numeric * $sign);
        }, 0);
        $this->totalPrice = $totalPrice;


        return $items;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('penalty-types-table')
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
            ['data' => 'fullName', 'title' => 'Ad soyad'],
            ['data' => 'state_registration_number', 'title' => 'D.Q.N.'],
            ['data' => 'price', 'title' => 'Gəlir'],
            ['data' => 'updated_at', 'title' => 'Tarix'],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'Penalty-Types_' . date('YmdHis');
    }
}
