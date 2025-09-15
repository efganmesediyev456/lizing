<?php

namespace App\DataTables;

use App\Models\Brand;
use App\Models\City;
use App\Models\Driver;
use App\Models\DriverNotification;
use App\Models\DriverNotificationTopic;
use App\Models\DriverStatus;
use App\Models\LeasingStatus;
use App\Models\Model;
use App\Models\OilType;
use App\Models\Payment;
use App\Models\TechnicalReview;
use App\Models\Vehicle;
use Yajra\DataTables\Services\DataTable;

class NotificationDatatable extends DataTable
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
            ->addIndexColumn()

            ->addColumn('action', function ($item) {
                $view = view('notification_all.action', [
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
            ->addColumn('fullName', function ($item) {
                return $item->driver?->fullName;
            })
            ->rawColumns(['action', 'status', 'fileView']);
    }

    public function query(DriverNotification $model)
    {
        $query = $model->newQuery()->orderBy('id','desc');
        if (request()->filled('driver_notification_topic_id')) {
            $query = $query->where('driver_notification_topic_id', request()->driver_notification_topic_id);
        }
        if (request()->filled('status_id')) {
            $query = $query->where('type', request()->status_id);
        }

        
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
            // ['data' => 'driver', 'title' => 'Ad soyad'],
            ['data' => 'driverNotificationTopic', 'title' => 'Bildiriş Səbəbi'],
            ['data' => 'note', 'title' => 'Qeyd'],
            ['data' => 'created_at', 'title' => 'Tarix'],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }


      public function getFilterOptions()
    {
        return [
            'driver_notification_topics' => DriverNotificationTopic::all(),
            'statuses' => DriverStatus::all(),
            'brands'=>Brand::all(),
            'models' => Model::get(),
            'tableIds' => Vehicle::get(),
            'drivers'=>Driver::get(),
            'driverFins'=>Driver::get(),
            'vehicles'=>Vehicle::get()
        ];
    }

   
}
