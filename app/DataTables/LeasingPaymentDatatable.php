<?php

namespace App\DataTables;

use App\Models\Brand;
use App\Models\Driver;
use App\Models\Insurance;
use App\Models\Leasing;
use App\Models\LeasingStatus;
use App\Models\Model;
use App\Models\TechnicalReview;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Column;

class LeasingPaymentDatatable extends DataTable
{
    protected $tableId;
    protected $leasings;

    public function __construct($leasings)
    {
        $this->tableId = 'leasings';
        $this->leasings = $leasings;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($item) {
                $view = view('passiv_leasing.actions', [
                    'item' => $item
                ])->render();
                return $view;
            })
             ->addColumn('leasingStatus', function ($item) {
                return $item->leasingStatus?->title ?? 'Status yoxdur';
            })
             ->editColumn('price', function ($item) {
                return $item->price.' AZN';
            })
             ->editColumn('remaining_amount', function ($item) {
                return $item->remaining_amount.' AZN';
            })
            ->editColumn('status', function ($item) {
                return match($item->status){
                    "pending"=>"Ödəniş gözlənilir",
                    "completed"=>"Tamamlandı",
                    default=>"Bilinməyən"
                };
            })
            ->rawColumns(['action', 'status']);
    }

    public function query()
    {
        return $this->leasings;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('leasings')
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
            ['data'=>'payment_date','title'=>'Ödəniləcək tarix'],
            ['data'=>'status','title'=>'status'],
            ['data'=>'price','title'=>'Qiymət'],
            ['data'=>'remaining_amount','title'=>'Qalan borc'],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'Leasings_' . date('YmdHis');
    }
}
