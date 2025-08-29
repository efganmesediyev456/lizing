<?php

namespace App\DataTables;

use App\Models\Vehicle;
use App\Models\Brand;
use App\Models\Model;
use App\Models\VehicleStatus;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;

class VehiclesDataTable extends DataTable
{
    protected $tableId;

    public function __construct($tableId = 'vehicles-table')
    {
        $this->tableId = $tableId;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function ($item) {
                return view('vehicles.action', ['item' => $item])->render();
            })
            ->editColumn('created_at', fn($vehicle) => $vehicle->created_at?->format('Y-m-d'))
            ->editColumn('brand_id', fn($vehicle) => $vehicle->brand?->title)
            ->editColumn('model_id', fn($vehicle) => $vehicle->model?->title)
            ->addColumn('is_advertisement', fn($vehicle) => $vehicle->leasing?->has_advertisement ? 'Bəli' : 'Xeyr')
            ->addColumn('technical_expired', fn($vehicle) => $vehicle->technicalReview?->end_date?->format('Y-m-d'))
            ->addColumn('insurance_expired', fn($vehicle) => $vehicle->insurance?->end_date?->format('Y-m-d'))
            ->addColumn('insurance_name', fn($vehicle) => $vehicle->insurance?->company_name)
            ->addColumn('leasingDate', fn($vehicle) => $vehicle->leasing?->start_date?->format('Y-m-d'))
            ->addColumn('leasingEndDate', fn($vehicle) => $vehicle->leasing?->end_date?->format('Y-m-d'))
            ->addColumn('deposit', fn($vehicle) => $vehicle->leasing?->deposit_payment)
            ->addColumn('deposit_debt', fn($vehicle) => $vehicle->leasing?->deposit_debt)
            ->addColumn('leasingDailyPayment', fn($vehicle) => $vehicle->leasing?->daily_payment . ' AZN')
            ->addColumn('leasinMonthlyPayment', fn($vehicle) => $vehicle->leasing?->monthly_payment . ' AZN')
            ->addColumn('leasingPeriodMonths', fn($vehicle) => $vehicle->leasing?->leasing_period_months . ' Ay')
            ->addColumn('leasingPeriodDays', fn($vehicle) => $vehicle->leasing?->leasing_period_days . ' Gün')
            ->addColumn('total', fn($vehicle) => $vehicle->leasing?->leasing_price . ' AZN')
            ->editColumn('status', function ($vehicle) {
                $status = $vehicle->vehicleStatus?->title;
                return $status
                    ? '<p class="inDrive"><span></span>' . $status . '</p>'
                    : '<p class="idle"><span></span>Bizdə</p>';
            })
            ->rawColumns(['action', 'status']);
    }

    public function query(Vehicle $model)
    {
        $query = $model->newQuery()
            ->with(['brand', 'model', 'leasing', 'technicalReview', 'insurance', 'vehicleStatus']);
           

        $search = request('search') ? request('search')['value'] : '';

        // Texniki baxış filter
        if (request()->has('technical_start') && request()->has('technical_end')) {
            $start = request('technical_start');
            $end = Carbon::parse(request('technical_end'))->endOfDay();

            $query->whereHas('technicalReview', fn($q) => $q->whereBetween('end_date', [$start, $end]));
        }

        // Sığorta filter
        if (request()->has('insurance_start') && request()->has('insurance_end')) {
            $start = request('insurance_start');
            $end = Carbon::parse(request('insurance_end'))->endOfDay();

            $query->whereHas('insurance', fn($q) => $q->whereBetween('end_date', [$start, $end]));
        }

        // Marka filter
        if (request()->has('brand_id')) {
            $query->where('brand_id', request('brand_id'));
        }

        // Model filter
        if (request()->has('model_id')) {
            $query->where('model_id', request('model_id'));
        }

        if (request()->has('table_id_number')) {
            $query->where('table_id_number', request('table_id_number'));
        }

        // Status filter
        if (request()->has('status_id')) {
            $query->where('vehicle_status_id', request('status_id'));
        }

        if (request()->has('has_advertisement')) {
            $query->whereHas('leasing', fn($q) => $q->where('has_advertisement', request('has_advertisement')));
        }

        // Ümumi search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('table_id_number', 'like', "%{$search}%")
                  ->orWhere('state_registration_number', 'like', "%{$search}%")
                  ->orWhereHas('brand', fn($qq) => $qq->where('title', 'like', "%{$search}%"))
                  ->orWhereHas('model', fn($qq) => $qq->where('title', 'like', "%{$search}%"));
            });
        }

        $query->orderByRaw('CAST(table_id_number AS UNSIGNED) ASC');


        return $query;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId($this->tableId)
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'paging' => true,
                'info' => false,
                'searching' => true,
                'ordering' => true,
                'responsive' => true,
                'autoWidth' => false,
                'scrollX' => true,
                'pageLength' => 100,
                'buttons' => [['extend' => 'colvis', 'text' => 'Sütunları Göstər/Gizlə']]
            ])
            ->dom('Bfrtip')
            ->orderBy(0);
    }

    protected function getColumns()
    {
        return [
            ['data' => 'DT_RowIndex', 'title' => 'No:', 'orderable' => false, 'searchable' => false],
            ['data' => 'table_id_number', 'title' => 'Table İD'],
            ['data' => 'brand_id', 'title' => 'Marka'],
            ['data' => 'model_id', 'title' => 'Model'],
            ['data' => 'state_registration_number', 'title' => 'D.Q.N'],
            ['data' => 'production_year', 'title' => 'İli'],
            ['data' => 'engine', 'title' => 'Mühərrik'],
            ['data' => 'is_advertisement', 'title' => 'Reklam', 'visible' => false],
            ['data' => 'technical_expired', 'title' => 'Texniki baxışın bitdiyi vaxt', 'visible' => false],
            ['data' => 'insurance_expired', 'title' => 'Sığortanın bitəcəyi vaxt', 'visible' => false],
            ['data' => 'insurance_name', 'title' => 'Sığorta Şirkəti', 'visible' => false],
            ['data' => 'leasingDate', 'title' => 'Başlama tarixi', 'visible' => false],
            ['data' => 'leasingEndDate', 'title' => 'Bitmə tarixi', 'visible' => false],
            ['data' => 'deposit', 'title' => 'Depozit', 'visible' => false],
            ['data' => 'deposit_debt', 'title' => 'Depozit borcu', 'visible' => false],
            ['data' => 'leasingDailyPayment', 'title' => 'Gündəlik İcarəsi', 'visible' => false],
            ['data' => 'leasinMonthlyPayment', 'title' => 'Aylıq İcarəsi', 'visible' => false],
            ['data' => 'leasingPeriodMonths', 'title' => 'Ay', 'visible' => false],
            ['data' => 'leasingPeriodDays', 'title' => 'Gün', 'visible' => false],
            ['data' => 'total', 'title' => 'Ümumi', 'visible' => false],
            ['data' => 'status', 'title' => 'Status'],
            ['data' => 'action', 'title' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'Vehicles_' . date('YmdHis');
    }

    public function getFilterOptions()
    {
        return [
            'brands' => Brand::all(),
            'models' => Model::all(),
            'statuses' => VehicleStatus::all(),
            'tableIds' => Vehicle::get(),
        ];
    }
}
