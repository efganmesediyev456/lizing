<?php

namespace App\DataTables;

use App\Models\Brand;
use App\Models\Driver;
use App\Models\Model;
use App\Models\TechnicalReview;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;

class TechnicalReviewDatatable extends DataTable
{
    protected $tableId;

    public function __construct($tableId = 'technical-reviews')
    {
        $this->tableId = $tableId;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($item) {
                $view = view('technical_reviews.action', [
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
             ->editColumn('vehicle_id', function ($driver) {
                return $driver->vehicle?->state_registration_number;
            })
             ->editColumn('model_id', function ($driver) {
                return $driver->model?->title;
            })
            ->filterColumn("brand_id", function($q,$s){
                $q->whereHas("brand", function($qq) use($s){
                    $qq->where("title","like","%$s%");
                });
            })
             ->filterColumn("model_id", function($q,$s){
                $q->whereHas("model", function($qq) use($s){
                    $qq->where("title","like","%$s%");
                });
            })
             ->filterColumn("vehicle_id", function($q,$s){
                $q->whereHas("vehicle", function($qq) use($s){
                    $qq->where("state_registration_number","like","%$s%");
                });
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
            })->setRowClass(function($item){
                
                if(!$item->end_date) return '';
                $now = now();
                $endDate = Carbon::parse($item->end_date);
                $diffMonths = $now->diffInMonths($endDate, false);
                $color = '';
                if($diffMonths <= 12){
                    $color = 'tr-red';
                }elseif($diffMonths <= 36){
                    $color = 'tr-green';
                }elseif($diffMonths <= 60){
                    $color = 'tr-yellow';
                }
                return $color;
            })
            ->rawColumns(['action', 'status']);
    }

    public function query(TechnicalReview $model)
    {
        $query = $model->newQuery();
     

        $query =$query->orderByRaw('CAST(tableId AS UNSIGNED) ASC');


        if(request()->vehicle){
            $query = $query->where('vehicle_id',request()->vehicle);
        }
        return $query;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('technical-reviews')
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
            ['data' => 'brand_id', 'title' => 'Marka'],
            ['data' => 'model_id', 'title' => 'Model'],
            ['data' => 'vehicle_id', 'title' => 'D.Q.N.'],
            // ['data' => 'start_date', 'title' => 'Başlama tarixi'],
            ['data' => 'end_date', 'title' => 'Bitmə tarixi'],
            ['data' => 'transmission_oil_suppliers', 'title' => 'Karobka yaginin bize verenler'],
        
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'TechnicalReviews_' . date('YmdHis');
    }
}
