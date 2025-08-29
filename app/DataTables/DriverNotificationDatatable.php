<?php

namespace App\DataTables;

use App\Models\Brand;
use App\Models\Driver;
use App\Models\DriverNotification;
use App\Models\Model;
use App\Models\OilType;
use App\Models\Payment;
use App\Models\TechnicalReview;
use Yajra\DataTables\Services\DataTable;

class DriverNotificationDatatable extends DataTable
{
    protected $tableId;

    public function __construct($tableId = 'notifications')
    {
        $this->tableId = $tableId;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($item) {
                $view = view('notifications.action', [
                    'item' => $item
                ])->render();
                return $view;
            })
            ->editColumn('created_at', function ($driver) {
                return $driver->created_at->format('Y-m-d');
            })
             ->addColumn('driver', function ($driver) {
                return $driver->driver?->fullName;
            })
            ->addColumn('driverNotificationTopic', function ($driver) {
                return $driver->driverNotificationTopic?->title;
            })
             ->addColumn('fileView', function ($item) {
                return '<a target="_blank" href="/storage/'.$item->image.'">Fayla bax</a>';
            })


            
            
            
            ->rawColumns(['action', 'status', 'fileView']);
    }

    public function query(DriverNotification $model)
    {
        $query = $model->newQuery();
        return $query;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('notifications_table')
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
            ['data' => 'created_at', 'title' => 'Tarix'],
            ['data' => 'driver', 'title' => 'Ad soyad'],
            ['data' => 'driverNotificationTopic', 'title' => 'Mövzu'],
            ['data' => 'driverNotificationTopic', 'title' => 'Mövzu'],
            ['data' => 'note', 'title' => 'Not'],
            // ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

   
}
