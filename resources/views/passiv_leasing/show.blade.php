@extends('layouts.app')


@section('content')
    <style>
        .brand-table {
            overflow-x: unset !important;
        }
    </style>
    <div class="viewLeasing-container">
        <a href="{{ route('leasing.passiv') }}" class="backLink">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#131527" />
            </svg>
            Geri
        </a>
        <div class="viewLeasing-container-head">
            <h1>Lizing məlumatı : {{ $driver?->name }} {{ $driver?->surname }}</h1>
        </div>
        <div class="viewLeasing-body">
            <div class="viewLeasing-tabs">
                <button class="leasing_tab active" id="driverInfo">Sürücü Məlumatlar</button>
                <button class="leasing_tab" id="autoInfo">Auto məlumatlar</button>
                <button class="leasing_tab" id="leasingInfo">Lizing məlumatlar</button>
            </div>
            <div class="viewLeasing_content driverInfoContent active" data-id="driverInfo">
                <div class="form-items">
                    <div class="form-item">
                        <label for="">Ad</label>
                        <div class="form-input">
                            <input type="text" value="{{ $driver?->name }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Soyad</label>
                        <div class="form-input">
                            <input type="text" value="{{ $driver?->surname }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Əlaqə nömrəsi</label>
                        <div class="form-input">
                            <input type="text" value="{{ $driver?->phone }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Şəhər</label>
                        <div class="form-input">
                            <input type="text" value="{{ $driver?->city?->title }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Şəxsiyyət FİN</label>
                        <div class="form-input">
                            <input type="text" value="{{ $driver?->fin }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Şəxsiyyətin seriya nömrəsi</label>
                        <div class="form-input">
                            <input type="text" value="{{ $driver?->id_card_serial_code }}">
                        </div>
                    </div>
                </div>

                <div class="brand-container" style="padding:0;">
                    <div class="brand-body" style="margin:0;">
                        <div class="brand-table">
                            {!! $dataTable->table(['class' => 'table table-bordered']) !!}
                        </div>
                    </div>
                </div>

                <div class="pagination-result">
                    <p class="result-text">Showing 1 to 10 of 50 entries</p>
                    <div class="pagination-result-right">
                        <div class="show_count">
                            <span>Display</span>
                            <input type="number" id="perPageInput" min="1" value="10">
                        </div>
                        <div class="pagination">
                            <a href="" class="prev">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 12L6 8L10 4" stroke="#343A40" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>
                            <a href="" class="pagination-item active">1</a>
                            <a href="" class="pagination-item">2</a>
                            <a href="" class="pagination-item">3</a>
                            <a href="" class="pagination-item">4</a>
                            <a href="" class="next">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 12L10 8L6 4" stroke="#343A40" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="viewLeasing_content autoInfoContent" data-id="autoInfo">
                <div class="form-items">
                    <div class="form-item">
                        <label for="">İD nömrə</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->vehicle?->table_id_number }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">VIN kod</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->vehicle?->vin_code }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Marka</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->brand?->title }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Model</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->model?->title }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Dövlət qeydiyyat nişanı</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->vehicle?->state_registration_number }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Istehsal ili</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->vehicle?->production_year }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Alış qiyməti</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->vehicle?->purchase_price }}">
                            <span>azn</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Yanacaq növü</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->vehicle?->oilType?->title }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Gediş məsafəsi</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->vehicle?->mileage }}">
                            <span>km</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Mühərrik</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->vehicle?->engine }}">
                            <span>l</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="viewLeasing_content leasingInfoContent" data-id="leasingInfo">
                <div class="form-items">
                    <div class="form-item">
                        <label for="">Depozit ödənişi</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->deposit_payment }}">
                            <span>azn</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Lizing ödənişi</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->deposit_price }}">
                            <span>azn</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Günlük ödəniş</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->daily_payment }}">
                            <span>azn</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Lizing müddəti</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->leasing_period_months }}">
                            <span>ay</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Başlama tarixi</label>
                        <div class="form-input">
                            <input type="date" value="{{ $item->start_date->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Bitmə tarixi</label>
                        <div class="form-input">
                            <input type="date" value="{{ $item->end_date->format('Y-m-d') }}">
                        </div>
                    </div>
                </div>
                <div class="form-item">
                    <label for="">Qeyd</label>
                    <div class="form-input">
                        <textarea name="" id="">{{ $item->notes }}</textarea>
                    </div>
                </div>
                <div class="documents">
                    <div class="document-box">
                        <h2>Əlavə edilən fayllar</h2>
                        <div class="document-list">
                            <div class="document-item">
                                <div class="document-title">
                                    <img src="../assets/icons/documentIcon.svg" alt="">
                                    <p>demo_image.jpg</p>
                                </div>
                                <div class="document-actions">
                                    <a href="" class="viewDocument" target="_blank">
                                        <img src="../assets/icons/eye-gray.svg" alt="">
                                    </a>
                                    <button class="deleteDocument">
                                        <img src="../assets/icons/trash-gray.svg" alt="">
                                    </button>
                                </div>
                            </div>
                            <div class="document-item">
                                <div class="document-title">
                                    <img src="../assets/icons/documentIcon.svg" alt="">
                                    <p>demo_image.jpg</p>
                                </div>
                                <div class="document-actions">
                                    <a href="" class="viewDocument" target="_blank">
                                        <img src="../assets/icons/eye-gray.svg" alt="">
                                    </a>
                                    <button class="deleteDocument">
                                        <img src="../assets/icons/trash-gray.svg" alt="">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('js')
    {!! $dataTable->scripts() !!}

    <script>
        $(function() {






            let tableId = '{{ $tableId ?? 'leasings' }}';
            let table = $('#' + tableId).DataTable();

            function updateCustomInfo(settings) {
                let start = settings._iDisplayStart + 1;
                let length = settings._iDisplayLength;
                let total = settings.fnRecordsDisplay();

                let end = start + length - 1;
                if (end > total) end = total;

                $('.result-text').text(`Showing ${start} to ${end} of ${total} entries`);
            }

            table.on('draw', function() {
                updateCustomInfo(table.settings()[0]);
            });

            updateCustomInfo(table.settings()[0]);


            $(".datatable-search").on("keyup", function() {
                var value = $(this).val();
                table.search(value).draw();
            })



            function updatePagination() {
                let info = table.page.info();
                let totalPages = info.pages;
                let currentPage = info.page + 1; // 0-based indexdir

                // Pagination container
                let pagination = $('.pagination');

                // Pagination itemları silirik (prev, next xaric)
                pagination.find('.pagination-item').remove();

                // Əgər 7-dən çox səhifə varsa
                if (totalPages > 7) {

                    $('.pagination-dots').remove()
                    // İlk səhifə həmişə görünür
                    $('<a href="#" class="pagination-item ' + (currentPage === 1 ? 'active' : '') + '">1</a>')
                        .insertBefore(pagination.find('.next'));

                    // Əgər cari səhifə ilk 4-dən kiçikdirsə
                    if (currentPage < 5) {
                        // 2-5 səhifələri göstər
                        for (let i = 2; i <= 5; i++) {
                            $('<a href="#" class="pagination-item ' + (i === currentPage ? 'active' : '') + '">' +
                                    i + '</a>')
                                .insertBefore(pagination.find('.next'));
                        }

                        // Sonra 3 nöqtə
                        $('<span class="pagination-dots">...</span>')
                            .insertBefore(pagination.find('.next'));

                        // Son səhifə
                        $('<a href="#" class="pagination-item">' + totalPages + '</a>')
                            .insertBefore(pagination.find('.next'));
                    }
                    // Əgər cari səhifə son 4-dən böyükdürsə
                    else if (currentPage > (totalPages - 4)) {
                        // 3 nöqtə
                        $('<span class="pagination-dots">...</span>')
                            .insertBefore(pagination.find('.next'));

                        // Son 5 səhifə
                        for (let i = totalPages - 4; i < totalPages; i++) {
                            $('<a href="#" class="pagination-item ' + (i === currentPage ? 'active' : '') + '">' +
                                    i + '</a>')
                                .insertBefore(pagination.find('.next'));
                        }

                        // Son səhifə
                        $('<a href="#" class="pagination-item ' + (currentPage === totalPages ? 'active' : '') +
                                '">' + totalPages + '</a>')
                            .insertBefore(pagination.find('.next'));
                    }
                    // Ortadakı səhifələr üçün
                    else {
                        // Başlanğıc 3 nöqtə
                        $('<span class="pagination-dots">...</span>')
                            .insertBefore(pagination.find('.next'));

                        // Cari səhifənin ətrafındakı səhifələr
                        for (let i = currentPage - 1; i <= currentPage + 1; i++) {
                            $('<a href="#" class="pagination-item ' + (i === currentPage ? 'active' : '') + '">' +
                                    i + '</a>')
                                .insertBefore(pagination.find('.next'));
                        }

                        // Son 3 nöqtə
                        $('<span class="pagination-dots">...</span>')
                            .insertBefore(pagination.find('.next'));

                        // Son səhifə
                        $('<a href="#" class="pagination-item">' + totalPages + '</a>')
                            .insertBefore(pagination.find('.next'));
                    }
                } else {
                    // 7-dən az səhifə varsa normal göstər
                    for (let i = 1; i <= totalPages; i++) {
                        $('<a href="#" class="pagination-item ' + (i === currentPage ? 'active' : '') + '">' + i +
                                '</a>')
                            .insertBefore(pagination.find('.next'));
                    }
                }

                // prev linkin disabled olub-olmadığını ayarla
                if (currentPage === 1) {
                    pagination.find('.prev').addClass('disabled');
                } else {
                    pagination.find('.prev').removeClass('disabled');
                }

                // next linkin disabled olub-olmadığını ayarla
                if (currentPage === totalPages) {
                    pagination.find('.next').addClass('disabled');
                } else {
                    pagination.find('.next').removeClass('disabled');
                }
            }




            // Pagination itemlarına click event əlavə et
            $('.pagination').on('click', '.pagination-item', function(e) {
                e.preventDefault();
                let page = parseInt($(this).text()) - 1; // 0-based index
                table.page(page).draw('page');
            });

            // prev link
            $('.pagination').on('click', '.prev:not(.disabled)', function(e) {
                e.preventDefault();
                table.page('previous').draw('page');
            });

            // next link
            $('.pagination').on('click', '.next:not(.disabled)', function(e) {
                e.preventDefault();
                table.page('next').draw('page');
            });

            // DataTable draw eventində info və paginationu yenilə
            table.on('draw', function() {
                updateCustomInfo(table.settings()[0]);
                updatePagination();
            });

            // İlk çağırışlar
            updateCustomInfo(table.settings()[0]);
            updatePagination();



            $(".addItem").click(function() {
                $(".message").remove()
                $(".saveForm").remove()
                $(".formTitle").text("Yüklənir...")

                $.ajax({
                    url: "{{ route('leasing.form') }}",
                    type: "post",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(e) {
                        $(".saveFormArea").append(e.view)
                        $(".formTitle").text(e.formTitle)

                    },
                    error: function(e) {

                    }
                })
            })

            $("body").on('click', '.editItem', function() {
                $(".message").remove()
                $(".saveForm").remove()
                $(".formTitle").text("Yüklənir...")

                var id = $(this).attr('data-id')
                $.ajax({
                    url: "{{ route('leasing.form') }}" + "/" + id,
                    type: "post",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(e) {
                        $(".saveFormArea").append(e.view)
                        $(".formTitle").text(e.formTitle)

                    },
                    error: function() {

                    }
                })
            })


            $('body').on('submit', '.saveForm', function(e) {
                e.preventDefault();
                var form = this;
                var formdata = new FormData(form);
                formdata.append("_token", "{{ csrf_token() }}")

                $(".formError").remove()

                $.ajax({
                    url: $(form).attr('action'),
                    type: $(form).attr('method') || 'POST',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function(e) {
                        $(".closeAddUser").trigger("click")
                        $(".success-modal-container").css({
                            'display': 'flex'
                        })
                        table.draw();
                        $(".success-modal-container").find('h2').text(e.message)

                    },
                    error: function(xhr) {
                        for (let a in xhr.responseJSON.errors) {
                            for (let b in xhr.responseJSON.errors[a]) {
                                if ($(form).find("[name='" + a + "']").parents('.form-item')
                                    .length) {
                                    $(form).find("[name='" + a + "']").parents('.form-item')
                                        .append('<p class="formError" style="color:red">' + xhr
                                            .responseJSON.errors[a][b] + '</p>')
                                } else if ($(form).find("[name='" + a + "']").parents(
                                        '.add_file_box').length) {
                                    $(form).find("[name='" + a + "']").parents('.add_file_box')
                                        .after('<p class="formError" style="color:red">' + xhr
                                            .responseJSON.errors[a][b] + '</p>')
                                }
                            }
                        }
                    }
                });
            });



            $("body").on("change", '#id_card_serial_code', function() {
                var value = $(this).val();
                $.ajax({
                    url: "{{ route('getSerialCard') }}",
                    type: "post",
                    data: {
                        value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(e) {
                        for (a in e) {
                            $(".saveForm").find("[name='" + a + "']").val(e[a])
                        }
                    },
                    error: function(e) {

                    }
                })
            })



            $("body").on("change", '#driver_id', function() {
                var value = $(this).val();
                $.ajax({
                    url: "{{ route('getDriverFin') }}",
                    type: "post",
                    data: {
                        value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(e) {
                        console.log(e)
                        $("#fin").html(e.view)
                    }
                })
            })



            $("body").on("input", "[name='deposit_price'], [name='deposit_payment']", function(e) {
                var depositPrice = parseInt($("[name='deposit_price']").val());
                $(".removeErr").remove()
                var depositPayment = parseInt($("[name='deposit_payment']").val());
                var depositDebt = depositPrice - depositPayment;
                $("[name='deposit_debt']").val(depositDebt);
                if (depositPrice < depositPayment) {
                    $("[name='deposit_payment']").parent().after(
                        '<p class="removeErr" style="color:red">Depozit ödənişi Depozit qiymətindən böyük ola bilməz</p>'
                        );
                }
            })


            $("body").on("input", "[name='daily_payment']", function() {
                if ($(this).val().length > 0) {
                    $("[name='monthly_payment']").val('');
                    $("[name='leasing_period_months']").val('');
                }
            });

            $("body").on("input", "[name='monthly_payment']", function() {
                if ($(this).val().length > 0) {
                    $("[name='daily_payment']").val('');
                    $("[name='leasing_period_days']").val('');
                }
            });

            $("body").on("input", "[name='leasing_period_months']", function() {
                if ($(this).val().length > 0) {
                    $("[name='leasing_period_days']").val('');
                    $("[name='daily_payment']").val('');
                }
            });

            $("body").on("input", "[name='leasing_period_days']", function() {
                if ($(this).val().length > 0) {
                    $("[name='leasing_period_months']").val('');
                    $("[name='monthly_payment']").val('');
                }
            });


            initFileInputUploadStyle('.id_card_front');
            initFileInputUploadStyle('.id_card_back');

            $('#perPageInput').on('input', function() {
                let val = parseInt($(this).val());
                if (!isNaN(val) && val > 0) {
                    table.page.len(val).draw();
                }
            });


            $("body").on("click", ".createPaymentButton", function(e) {
                $("#createPayment").css({
                    "display": "flex"
                })
                var id = $(this).attr('data-id');
                $("[name='price']").val("");

                $("#submitPaymentForm").find('[name="leasing_id"]').val(id);
            })






            $("#submitPaymentForm").on("submit", function(e) {
                e.preventDefault();

                let price = $("#submitPaymentForm [name='price']").val();
                let payment_status = $("#submitPaymentForm [name='payment_status']").val();
                let leasing_id = $("#submitPaymentForm [name='leasing_id']").val();

                $.ajax({
                    url: $("#submitPaymentForm").attr('action'),
                    method: "POST",
                    data: {
                        price: price,
                        payment_status: payment_status,
                        _token: '{{ csrf_token() }}',
                        'leasing_id': leasing_id
                    },
                    success: function(response) {
                        alert("Uğurla göndərildi")
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status !== 422) {
                            let errorModal = $(".error-modal-container");
                            errorModal.find("p").text(xhr.responseJSON.message ||
                                "Naməlum xəta baş verdi");

                            errorModal.css("display", "flex");
                        } else {
                            alert(xhr.responseJSON.message)
                        }
                    }
                });
            });

            $(".error-modal-container .closeError").on("click", function() {
                $(".error-modal-container").hide();
            });

            $(".error-modal-container .goBack").on("click", function(e) {
                e.preventDefault();
                $(".error-modal-container").hide();
            });




        });
    </script>
@endpush
