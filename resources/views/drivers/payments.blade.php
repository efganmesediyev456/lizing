@extends('layouts.app')


@section('content')
    <style>
        .tableFlex {
            display: flex;
            width: 100%;

            &>div {
                flex: 1;
            }
        }

        .payment_table {
            margin-top: 30px;

            h2 {
                margin-bottom: 22px;
            }
        }
    </style>
    <div class="drivers-container">
        <div class="drivers-container-head">
            <h1>Sürücü ({{ $driver->fullName }})</h1>

            <div class="head-buttons">


            </div>
        </div>

        <div class="drivers-body">

            <div class="drivers-table">
                @foreach ($response as $leasingData)
                    <div class="leasing-block" style="margin-bottom:40px;">


                        <div class="tableFlex">
                            <div>
                                <h2>Müqavilə Məlumatları</h2>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Table ID</th>
                                        <td>{{ $leasingData['leasing']->tableId }}</td>
                                    </tr>
                                    <tr>
                                        <th>Müqavilə qiyməti</th>
                                        <td>{{ $leasingData['leasing']->leasing_price }}</td>
                                    </tr>
                                    <tr>
                                        <th>Aylıq ödəniş</th>
                                        <td>{{ $leasingData['leasing']->monthly_payment }}</td>
                                    </tr>
                                    <tr>
                                        <th>Müddət</th>
                                        <td>{{ $leasingData['leasing']->leasing_period_months }} ay</td>
                                    </tr>
                                    <tr>
                                        <th>Başlama tarixi</th>
                                        <td>{{ $leasingData['leasing']->start_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Bitmə tarixi</th>
                                        <td>{{ $leasingData['leasing']->end_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Qeydlər</th>
                                        <td>{{ $leasingData['leasing']->notes }}</td>
                                    </tr>

                                    <tr>
                                        <th>Ümumi borc(Leasing)</th>
                                        <td>
                                            <span @if (!empty($leasingData['total_debt'])) style="color:red;" @endif>
                                                {{ $leasingData['total_debt'] ?? '-' }}
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>İlkin depozit ödəniş borcu</th>
                                        <td>
                                            <span @if (!empty($driver?->leasing?->deposit_payment)) style="color:red;" @endif>
                                                {{ $driver?->leasing?->deposit_payment ?? '-' }}
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Depozit borcu</th>
                                        <td>
                                            <span @if (!empty($driver?->leasing?->deposit_debt)) style="color:red;" @endif>
                                                {{ $driver?->leasing?->deposit_debt ?? '-' }}
                                            </span>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                            <div>
                                <h2>Avtomobil Məlumatları</h2>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Dövlət Nömrəsi</th>
                                        <td>{{ $leasingData['vehicle']->state_registration_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>VIN</th>
                                        <td>{{ $leasingData['vehicle']->vin_code }}</td>
                                    </tr>
                                    <tr>
                                        <th>İl</th>
                                        <td>{{ $leasingData['vehicle']->production_year }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mühərrik</th>
                                        <td>{{ $leasingData['vehicle']->engine }}</td>
                                    </tr>
                                    <tr>
                                        <th>Gediş məsafəsi</th>
                                        <td>{{ $leasingData['vehicle']->mileage }} km</td>
                                    </tr>
                                </table>
                            </div>

                        </div>




                        <div class="payment_table">
                            <h2>Leasing Ödəniş Qrafiki</h2>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tarix</th>
                                        <th>Status</th>
                                        <th>Məbləğ</th>
                                        <th>Ödənilib</th>
                                        <th>Qalıq</th>
                                        <th>Ay</th>
                                        <th>Həftə günü</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($leasingData['records'] as $record)
                                        <tr>
                                            <td>{{ $record['id'] }}</td>
                                            <td>{{ $record['payment_date'] }}</td>
                                            <td>
                                                @if ($record['status'] == 'completed')
                                                    <span style="color: green;">Tam ödənilib</span>
                                                @elseif($record['status'] == 'partial')
                                                    <span style="color: orange;">Qismən ödənilib</span>
                                                @else
                                                    <span style="color: red;">Gözləyir</span>
                                                @endif
                                            </td>
                                            <td>{{ $record['price'] }}</td>
                                            <td>{{ $record['paid'] }}</td>
                                            <td>{{ $record['remaining_amount'] }}</td>
                                            <td>{{ $record['month_name'] }}</td>
                                            <td>{{ $record['week_day_name'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="payment_table">
                            <h2>Sürücü Ödəniş Qrafiki</h2>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tarix</th>
                                        <th>Status</th>

                                        <th>Nağd/Ofis</th>
                                        <th>Məbləğ</th>
                                        <th style="text-align: center">Ödəniş tipi</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($leasingData['driver_payments'] as $record)
                                        <tr>
                                            <td>{{ $record['id'] }}</td>
                                            <td>{{ $record['created_at'] }}</td>
                                            <td>
                                                @if ($record['status'] == 'completed')
                                                    <span style="color: green;">Tam ödənilib</span>
                                                @elseif($record['status'] == 'pending')
                                                    <span style="color: red;">Gözləyir</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($record['payment_back_or_app'] == 0)
                                                    <span>Nağd(Onlayn)</span>
                                                @elseif($record['payment_back_or_app'] == 1)
                                                    <span>Ofis</span>
                                                @endif
                                            </td>

                                            <td>{{ $record['price'] }}</td>
                                            <td style="text-align: center">
                                                @if ($record['payment_type'] == 'daily')
                                                    <span>Gündəlik</span>
                                                @elseif($record['payment_type'] == 'monthly')
                                                    <span>Aylıq</span>
                                                @elseif($record['payment_type'] == 'deposit_payment')
                                                    <span>Ilkin depozit</span>
                                                @elseif($record['payment_type'] == 'deposit_debt')
                                                    <span>Depozit</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>



    <div class="success-modal-container" style="display: none;">
        <div class="success-modal">
            <button class="closeSuccess" type="button">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M6.83765 6.83765C7.01343 6.66209 7.25171 6.56348 7.50015 6.56348C7.74859 6.56348 7.98687 6.66209 8.16265 6.83765L23.1627 21.8377C23.2548 21.9235 23.3286 22.027 23.3799 22.142C23.4311 22.257 23.4587 22.3811 23.4609 22.507C23.4631 22.6329 23.44 22.7579 23.3928 22.8746C23.3457 22.9914 23.2755 23.0974 23.1865 23.1865C23.0974 23.2755 22.9914 23.3457 22.8746 23.3928C22.7579 23.44 22.6329 23.4631 22.507 23.4609C22.3811 23.4587 22.257 23.4311 22.142 23.3799C22.027 23.3286 21.9235 23.2548 21.8377 23.1627L6.83765 8.16265C6.66209 7.98687 6.56348 7.74859 6.56348 7.50015C6.56348 7.25171 6.66209 7.01343 6.83765 6.83765Z"
                        fill="#2C2D33" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M23.1626 6.83765C23.3381 7.01343 23.4367 7.25171 23.4367 7.50015C23.4367 7.74859 23.3381 7.98687 23.1626 8.16265L8.16255 23.1627C7.98483 23.3283 7.74978 23.4184 7.5069 23.4141C7.26402 23.4098 7.03229 23.3114 6.86052 23.1397C6.68876 22.9679 6.59037 22.7362 6.58608 22.4933C6.5818 22.2504 6.67195 22.0154 6.83755 21.8377L21.8376 6.83765C22.0133 6.66209 22.2516 6.56348 22.5001 6.56348C22.7485 6.56348 22.9868 6.66209 23.1626 6.83765Z"
                        fill="#2C2D33" />
                </svg>
            </button>
            <img src="{{ asset('assets/images/success.svg') }}" alt="">
            <h2>Uğurla əlavə olundu !</h2>
            <a href="" class="goBack">
                Geri qayit
            </a>
        </div>
    </div>
@endsection
