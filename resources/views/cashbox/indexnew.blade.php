@extends('layouts.app')

@section('content')
    <style>



        
        .center {
            text-align: center;
            margin-bottom: 24px;
        }


       
        table {
  border-radius: 12px;
  border-collapse: separate !important;
  border-spacing: 0;
  border: 1.4px solid #a5a3b0; /* yalnız table */
  overflow: hidden;
}


table.table th,
table.table td {
  padding: 12px;
  text-align: center !important;
  border: .1px solid black;; /* bunlardan qaldır */
}


table.table tr:hover {
  background-color: #f2f2f2; /* istəsən açıq-boz ver */
}

        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="password"],
        textarea,
        select {
            width: 50%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        /* Fokus zamanı */
        input:focus,
        textarea:focus,
        select:focus {
            border-color: #007bff;
            box-shadow: 0 0 4px rgba(0, 123, 255, 0.3);
        }

        /* Placeholder */
        ::placeholder {
            color: #999;
            font-size: 13px;
        }

        /* Disable olunmuş input */
        input:disabled,
        textarea:disabled {
            background: #f5f5f5;
            cursor: not-allowed;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
            border: none;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
        }

        .btn-primary:active {
            background-color: #0056b3;
            transform: scale(0.97);
        }
    </style>
    <div class="cashbox-container technical-container">
        <div class="cashbox-container-head">
            <h1>Gündəlik kassa hesabatı ({{ $summary['date'] }})</h1>

            {{-- <div class="head-buttons">
                <a href="{{ route('cashbox.export') }}" class="export_excel">Export</a>
            </div> --}}
        </div>

        <div class="cashbox-body technical-body">


           
              
                <div class="cashbox-table">
                    <h3 class="center">Maşınlar üzrə gəlirlər</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Maşın(Table Id)</th>
                                <th>Maşın nömrəsi</th>
                                <th>Sürücü adı</th>
                                <th>Ofis</th>
                                <th>Kart</th>
                                <th>Cəmi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($summary['vehicles'] as $row)
                                <tr>
                                    <td>{{ $row['table_id_number'] }}</td>
                                    <td>{{ $row['vehicle_name'] }}</td>
                                    <td>{{ $row['driver_name'] }}</td>
                                    <td>
                                        {{ $row['cash'] != 0 ? number_format($row['cash'], 2) . ' AZN' : '' }}
                                    </td>
                                    <td>
                                        {{ $row['online'] != 0 ? number_format($row['online'], 2) . ' AZN' : '' }}
                                    </td>

                                    <td style="text-align: end">{{ number_format($row['total'], 2) }} AZN</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="cashbox-table">
                    <h3 class="center">Xərclər</h3>

                    <form action="{{ route('expense-types.expenseCreate') }}" method="POST">
                        @csrf
                        <table class="table">
                            <tbody>
                                @foreach ($expenseTypes as $expenseType)
                                    <tr>
                                        <td>{{ $expenseType->title }}</td>
                                        @php
                                            $val = \App\Models\CashExpense::whereDate('date', $date)
                                                ->where('expense_type_id', $expenseType->id)
                                                ->first();
                                        @endphp
                                        <td>
                                            <input type="text" class="input" name="expense[{{ $expenseType->id }}]"
                                                value="{{ $val?->price }}"> AZN
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div style="margin-top:15px; text-align:right;">
                            <button type="submit" class="btn btn-primary">Xərclər Yadda saxla</button>
                        </div>
                    </form>
                </div>

                <div class="cashbox-table">
                    <h3 class="center">Ümumi Gəlirlər</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Ofis</th>
                                <th>Kart</th>
                                <th>Cəmi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ number_format($summary['income']['cash'], 2) }} AZN</td>
                                <td>{{ number_format($summary['income']['online'], 2) }} AZN</td>
                                <td style="text-align: end">{{ number_format($summary['income']['total'], 2) }} AZN</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- 📉 Ümumi xərclər (expense) --}}
                <div class="cashbox-table">
                    <h3 class="center">Ümumi Xərclər</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Ofis</th>
                                <th>Cəmi</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>{{ number_format(abs($summary['expense']['total']), 2) }} AZN</td>
                                <td style="text-align: end">{{ number_format(abs($summary['expense']['total']), 2) }} AZN
                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>






                {{-- 📊 Nəticə --}}
                <div class="total-payment">
                    <p>Net kassa: </p>
                    <span>{{ number_format($summary['net_total'], 2) }} AZN</span>
                </div>
        </div>
    </div>
@endsection
