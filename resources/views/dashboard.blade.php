@extends('layouts.app')


@section('content')







<div class="dashboard-continer"> 
          <h1>Dashboard</h1>
          
          <div class="dashboard-boxes">
    @foreach($stats as $stat)
        <a href="#" class="dashboard-box">
            <div class="box-left">
                <h2 class="box-title">{{ $stat['title'] }}</h2>
                <h3 class="box-count">{{ $stat['count'] }}</h3>

                @if($stat['diff']['status'] == 'increase')
                    <div class="box-increase box-status">
                        <img src="{{ asset('assets/icons/increase.svg') }}" alt="">
                        <p><span>{{ $stat['diff']['percent'] }}%</span> Artıb</p>
                    </div>
                @elseif($stat['diff']['status'] == 'decrease')
                    <div class="box-decrease box-status">
                        <img src="{{ asset('assets/icons/decrease.svg') }}" alt="">
                        <p><span>{{ $stat['diff']['percent'] }}%</span> Azalıb</p>
                    </div>
                @else
                    <div class="box-static box-status">
                        <img src="{{ asset('assets/icons/static.svg') }}" alt="">
                        <p><span>0%</span> Sabit</p>
                    </div>
                @endif
            </div>
            <div class="icon">
                <img src="{{ asset('assets/icons/' . $stat['icon']) }}" alt="">
            </div>
        </a>
    @endforeach
</div>

          <div class="today_notifications_container">
            <h2>Bu günkü bildirişlər</h2>
            <div class="today_notifications">
              <div class="calendar">
                  <div class="calendar-header">
                      <div class="calendar-month-year">
                        <div class="calendar-month"></div>
                        <div class="calendar-year"></div>
                      </div>
                      <div class="calendar-header-buttons">
                          <button class="prev-month">
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.66601 11.8764C11.426 9.10757 14.1236 6.40597 16.7588 3.77157C16.8967 3.62657 16.9737 3.4341 16.9737 3.23397C16.9737 3.03384 16.8967 2.84137 16.7588 2.69637C16.3856 2.28117 15.7952 2.31717 15.5264 2.60037C12.7952 5.33877 9.93801 8.20077 6.95481 11.1864C6.71801 11.3808 6.59961 11.6104 6.59961 11.8752C6.59961 12.14 6.71801 12.3768 6.95481 12.5856L15.9344 21.3528C16.1068 21.5109 16.334 21.5958 16.5679 21.5893C16.8017 21.5828 17.0239 21.4855 17.1872 21.318C17.6168 20.8872 17.4512 20.4624 17.2568 20.2608C14.3887 17.4698 11.5247 14.6746 8.66481 11.8752" fill="#B6B6B6"/>
                              </svg>
                               
                          </button>
                          <button class="next-month">
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.334 12.1236C12.574 14.8924 9.87639 17.594 7.24119 20.2284C7.10326 20.3734 7.02633 20.5659 7.02633 20.766C7.02633 20.9662 7.10326 21.1586 7.24119 21.3036C7.61439 21.7188 8.20479 21.6828 8.47359 21.3996C11.2048 18.6612 14.062 15.7992 17.0452 12.8136C17.282 12.6192 17.4004 12.3896 17.4004 12.1248C17.4004 11.86 17.282 11.6232 17.0452 11.4144L8.06559 2.64723C7.89321 2.48906 7.666 2.40423 7.43214 2.41073C7.19828 2.41722 6.97613 2.51453 6.81279 2.68203C6.38319 3.11283 6.54879 3.53763 6.74319 3.73922C9.61129 6.53022 12.4753 9.32542 15.3352 12.1248" fill="#B6B6B6"/>
                              </svg>
                          </button>
                      </div>
                  </div>
                  <div class="calendar-days">
                      <!-- Gün adları buraya JavaScript ile eklenecek -->
                    </div>
                  <div class="calendar-grid">
                  <!-- Günler bura JavaScript ile add olacaq -->
                  </div>
              </div>
              <div class="today_notifications_boxes">
                <div class="today_notifications_box">
                  <h3 class="box-title">Gözlənilən ödənişlər</h3>
                  <div class="box-list">
                    @foreach($paymentsDueTodays as $paymentsDueToday)
                    <div class="list-item">{{$paymentsDueToday->fullName}} – {{ $paymentsDueToday->debt }} AZN </div>
                    @endforeach
                  </div>
                </div>
                <div class="today_notifications_box">
                  <h3 class="box-title">Sənəd Gözləyir</h3>
                  <div class="box-list">
                    @foreach($documentIsPendings as $documentIsPending)
                    <div class="list-item">{{ $documentIsPending->fullName }}</div>
                    @endforeach
                    
                  </div>
                </div>
                

                <div class="today_notifications_box">
                <h3 class="box-title">Gecikmə və xəbərdarlıq</h3>
                <div class="box-list">
                    @forelse($paymentsOverdues as $payment)
                    @php
                        // Neçə gün gecikib
                        $daysLate = now()->diffInDays(\Carbon\Carbon::parse($payment->payment_date));
                        // Müştəri adı hardan gəlirsə onu düzəlt
                        $customerName = $payment->driver?->fullName ?? 'Naməlum';
                    @endphp
                    <div class="list-item">{{ $customerName }} – {{ $daysLate }} gün</div>
                    @empty
                    <div class="list-item">Gecikmiş ödəniş yoxdur</div>
                    @endforelse
                </div>
                </div>


                <div class="today_notifications_box">
                  <h3 class="box-title">Günlük Ödəniş Edilib</h3>
                  <div class="box-list">
                    @foreach($paymentDrivers as $driver)
                    <div class="list-item">{{ $driver->fullName }}</div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
         
          <div class="chart-items">
            <div class="chart-item">
                <div class="chart-item-head">
                    <h2>Aylıq ödəniş</h2>
                    <select name="" id="yearSelector">
                        @for($y = now()->year; $y >= now()->year - 5; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="chart-item-body">
                    <div class="chart">
                        <canvas id="chartForCount"></canvas>
                    </div>
                </div>
            </div>
        </div>

        </div>

@endsection


@push("js")


 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   
<script>
    const ctx = document.getElementById("chartForCount").getContext("2d");

    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(67, 121, 238, 0.16)');
    gradient.addColorStop(1, 'rgba(255, 255, 255, 0.17)');

    let chart;

    function fetchAndRenderChart(year) {
        fetch(`/dashboard/payments?year=${year}`)
            .then(res => res.json())
            .then(data => {
                if (chart) chart.destroy();

                chart = new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: ["Yan", "Fev", "Mar", "Apr", "May", "İyun", "İyul", "Avq", "Sent", "Okt", "Noy", "Dek"],
                        datasets: [{
                            label: "İllik Ödəniş",
                            data: data,
                            borderWidth: 3,
                            borderColor: "#4880FF",
                            pointBackgroundColor: "#4880FF",
                            pointRadius: 5,
                            fill: true,
                            backgroundColor: gradient
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
    }

    // İl seçimi dəyişəndə
    document.getElementById('yearSelector').addEventListener('change', function () {
        fetchAndRenderChart(this.value);
    });

    // İlk yükləmədə cari il
    fetchAndRenderChart(new Date().getFullYear());
</script>

@endpush