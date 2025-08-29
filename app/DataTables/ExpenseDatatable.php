<?php

namespace App\DataTables;

use App\Helpers\CashboxHelper;
use App\Models\Brand;
use App\Models\Driver;
use App\Models\Expense;
use Yajra\DataTables\Services\DataTable;

class ExpenseDatatable extends DataTable
{
    protected $tableId;

    public function __construct($tableId = 'expenses-table')
    {
        $this->tableId = $tableId;
    }

    public function dataTable($query)
    {

        

       

        return datatables()
            ->collection($query)
            ->addIndexColumn()
            ->addColumn('action', function ($item) {
                $view = view('expenses.action', [
                    'item' => $item
                ])->render();
                return $view;
            })
            ->editColumn('created_at', function ($driver) {
                return $driver->created_at?->format('Y-m-d');
            })
            ->addColumn("state_registration_number", function($item){
                return $item->vehicle?->state_registration_number;
            })
            ->editColumn("total_expense", function($item){
                return '-'.$item->total_expense;
            })
            ->editColumn('status', function ($driver) {
                $status = $driver->status;
                $html = '';
                if($status){
                    $html = '<p class="activeBrand">
                                <span></span>
                                Active
                            </p>';
                }else{
                    $html = '<p class="deactiveBrand">
                                <span></span>
                                Deactive
                            </p>';
                }
                return $html;
            })
            ->with(['total_price' => $this->totalPrice])

            ->rawColumns(['action', 'status']);
    }

    public function query(Expense $model)
    {
        
        $query = $model->newQuery()->orderBy('id', 'desc')->get();



        // $query2= CashboxHelper::onlyInsurancesAndTechnicalReviews();
        // $merged = $query->merge($query2); 
        $merged = $query; 


        // if ($search = request()->get('search')['value'] ?? null) {
        //     $merged = $merged->filter(function ($item) use ($search) {
        //         $stateRegNum = $item->vehicle?->state_registration_number ?? '';
        //         $totalExpense = $item->vehicle?->state_registration_number ?? '';

        //         return stripos($item->tableId, $search) !== false
        //             || stripos($stateRegNum, $search) !== false
        //             || stripos($item->total_expense, $search) !== false
        //             || stripos($item->note, $search) !== false;
        //     });
        // }


        // $totalPrice = $merged->reduce(function ($carry, $item) {
        //     $numeric = (int) str_replace(['+', '-', 'azn', ' '], '', $item->total_expense);
        //     $sign = str_starts_with($item->total_expense, '-') ? -1 : 1;
        //     return $carry + ($numeric * $sign);
        // }, 0);

        // $this->totalPrice = $totalPrice;


        return $merged;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('expenses-table')
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
            ['data' => 'DT_RowIndex', 'title' => 'NO:', 'orderable' => false, 'searchable' => false],
            ['data' => 'tableId', 'title' => 'Table ID'],
            ['data' => 'state_registration_number', 'title' => 'D.Q.N.'],
            ['data' => 'total_expense', 'title' => 'Ümumi xərc'],
            ['data' => 'note', 'title' => 'Məlumat'],
            ['data' => 'date', 'title' => 'Tarix'],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

}
