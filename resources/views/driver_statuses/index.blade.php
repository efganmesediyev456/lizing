@extends('layouts.app')


@section('content')

        <div class="model-container">
            <div class="model-container-head">
                <h1>Sürücü statusları</h1>
                <div class="head-buttons">
                    <a href="" class="export_excel">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.75022 16.5C0.000222408 17.25 0.750222 9 6.75022 9.75C4.50022 1.5 17.2502 1.5 16.5002 7.5C24.0002 5.25 24.0002 17.25 17.2502 16.5M8.25022 19.5L12.0002 22.5M12.0002 22.5L15.7502 19.5M12.0002 22.5V12" stroke="#7B7676" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg> 
                        Export
                    </a>
                    <button class="addNewModel addNewUsers addItem" type="button">
                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.5 12.998H13.5V17.998C13.5 18.2632 13.3946 18.5176 13.2071 18.7051C13.0196 18.8926 12.7652 18.998 12.5 18.998C12.2348 18.998 11.9804 18.8926 11.7929 18.7051C11.6054 18.5176 11.5 18.2632 11.5 17.998V12.998H6.5C6.23478 12.998 5.98043 12.8926 5.79289 12.7051C5.60536 12.5176 5.5 12.2632 5.5 11.998C5.5 11.7328 5.60536 11.4784 5.79289 11.2909C5.98043 11.1033 6.23478 10.998 6.5 10.998H11.5V5.99799C11.5 5.73277 11.6054 5.47842 11.7929 5.29088C11.9804 5.10334 12.2348 4.99799 12.5 4.99799C12.7652 4.99799 13.0196 5.10334 13.2071 5.29088C13.3946 5.47842 13.5 5.73277 13.5 5.99799V10.998H18.5C18.7652 10.998 19.0196 11.1033 19.2071 11.2909C19.3946 11.4784 19.5 11.7328 19.5 11.998C19.5 12.2632 19.3946 12.5176 19.2071 12.7051C19.0196 12.8926 18.7652 12.998 18.5 12.998Z" fill="white"/>
                        </svg>
                        Yeni Sürücü statusu Əlavə et
                    </button>
                </div>
            </div>
            <div class="model-body">
                <div class="model-body-head">
                    <h2>Ümumi Məlumatlar</h2>
                    <form class="modul-search">
                        <button class="search_btn" type="submit">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.3853 15.446C13.0375 16.5229 11.3284 17.0429 9.60922 16.8991C7.88999 16.7552 6.29108 15.9586 5.14088 14.6727C3.99068 13.3869 3.3765 11.7094 3.42449 9.9848C3.47248 8.26024 4.17898 6.6195 5.39891 5.39958C6.61883 4.17965 8.25956 3.47315 9.98413 3.42516C11.7087 3.37717 13.3862 3.99135 14.6721 5.14155C15.9579 6.29175 16.7546 7.89066 16.8984 9.60989C17.0422 11.3291 16.5222 13.0382 15.4453 14.386L20.6013 19.541C20.675 19.6097 20.7341 19.6925 20.7751 19.7845C20.8161 19.8765 20.8381 19.9758 20.8399 20.0765C20.8417 20.1772 20.8232 20.2772 20.7855 20.3706C20.7477 20.464 20.6916 20.5488 20.6204 20.62C20.5492 20.6913 20.4643 20.7474 20.3709 20.7851C20.2775 20.8228 20.1775 20.8414 20.0768 20.8396C19.9761 20.8378 19.8768 20.8158 19.7848 20.7748C19.6928 20.7338 19.61 20.6747 19.5413 20.601L14.3853 15.446ZM6.45933 13.884C5.72537 13.15 5.22549 12.2148 5.02284 11.1968C4.8202 10.1787 4.92391 9.12344 5.32084 8.1643C5.71778 7.20517 6.39014 6.38523 7.25295 5.8081C8.11575 5.23098 9.13027 4.92258 10.1683 4.92189C11.2063 4.92119 12.2213 5.22822 13.0848 5.80418C13.9484 6.38014 14.6219 7.19917 15.0201 8.15778C15.4183 9.11638 15.5235 10.1715 15.3222 11.1898C15.1209 12.2082 14.6223 13.144 13.8893 13.879L13.8843 13.884L13.8793 13.888C12.8944 14.8706 11.5598 15.4221 10.1685 15.4214C8.77725 15.4206 7.44318 14.8677 6.45933 13.884Z" fill="#B3B3B3"/>
                            </svg>
                        </button>
                        <input type="text" placeholder="Search" class="datatable-search"> 
                    </form>
                </div>
                <div class="model-table">
                      {!! $dataTable->table(['class' => 'table table-bordered']) !!}
                </div>
            </div>
        </div>
        <div class="pagination-result">
            <p class="result-text"></p>
            <div class="pagination-result-right">
                <div class="show_count">
                    <span>Display</span>
                     <input type="number" id="perPageInput" min="1" value="100">
                </div>
                <div class="pagination">
                    <a href="" class="prev">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 12L6 8L10 4" stroke="#343A40" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <a href="" class="pagination-item active">1</a>
                    <a href="" class="pagination-item">2</a>
                    <a href="" class="pagination-item">3</a>
                    <a href="" class="pagination-item">4</a>
                    <a href="" class="next">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 12L10 8L6 4" stroke="#343A40" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>


         <div class="success-modal-container" style="display: none;">
            <div class="success-modal">
                <button class="closeSuccess" type="button">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.83765 6.83765C7.01343 6.66209 7.25171 6.56348 7.50015 6.56348C7.74859 6.56348 7.98687 6.66209 8.16265 6.83765L23.1627 21.8377C23.2548 21.9235 23.3286 22.027 23.3799 22.142C23.4311 22.257 23.4587 22.3811 23.4609 22.507C23.4631 22.6329 23.44 22.7579 23.3928 22.8746C23.3457 22.9914 23.2755 23.0974 23.1865 23.1865C23.0974 23.2755 22.9914 23.3457 22.8746 23.3928C22.7579 23.44 22.6329 23.4631 22.507 23.4609C22.3811 23.4587 22.257 23.4311 22.142 23.3799C22.027 23.3286 21.9235 23.2548 21.8377 23.1627L6.83765 8.16265C6.66209 7.98687 6.56348 7.74859 6.56348 7.50015C6.56348 7.25171 6.66209 7.01343 6.83765 6.83765Z" fill="#2C2D33"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M23.1626 6.83765C23.3381 7.01343 23.4367 7.25171 23.4367 7.50015C23.4367 7.74859 23.3381 7.98687 23.1626 8.16265L8.16255 23.1627C7.98483 23.3283 7.74978 23.4184 7.5069 23.4141C7.26402 23.4098 7.03229 23.3114 6.86052 23.1397C6.68876 22.9679 6.59037 22.7362 6.58608 22.4933C6.5818 22.2504 6.67195 22.0154 6.83755 21.8377L21.8376 6.83765C22.0133 6.66209 22.2516 6.56348 22.5001 6.56348C22.7485 6.56348 22.9868 6.66209 23.1626 6.83765Z" fill="#2C2D33"/>
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


@push("js")

{!! $dataTable->scripts() !!}

<script>
    $(function() {
        let tableId = '{{ $tableId ?? "driver-status-table" }}';
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
                let currentPage = info.page + 1; 

                let pagination = $('.pagination');

                pagination.find('.pagination-item').remove();

                if (totalPages > 7) {

                    $('.pagination-dots').remove()
                    $('<a href="#" class="pagination-item ' + (currentPage === 1 ? 'active' : '') + '">1</a>')
                        .insertBefore(pagination.find('.next'));

                    if (currentPage < 5) {
                        for (let i = 2; i <= 5; i++) {
                            $('<a href="#" class="pagination-item ' + (i === currentPage ? 'active' : '') + '">' +
                                    i + '</a>')
                                .insertBefore(pagination.find('.next'));
                        }

                        $('<span class="pagination-dots">...</span>')
                            .insertBefore(pagination.find('.next'));

                        $('<a href="#" class="pagination-item">' + totalPages + '</a>')
                            .insertBefore(pagination.find('.next'));
                    }
                    else if (currentPage > (totalPages - 4)) {
                        $('<span class="pagination-dots">...</span>')
                            .insertBefore(pagination.find('.next'));

                        for (let i = totalPages - 4; i < totalPages; i++) {
                            $('<a href="#" class="pagination-item ' + (i === currentPage ? 'active' : '') + '">' +
                                    i + '</a>')
                                .insertBefore(pagination.find('.next'));
                        }

                        $('<a href="#" class="pagination-item ' + (currentPage === totalPages ? 'active' : '') +
                                '">' + totalPages + '</a>')
                            .insertBefore(pagination.find('.next'));
                    }
                    else {
                        $('<span class="pagination-dots">...</span>')
                            .insertBefore(pagination.find('.next'));

                        for (let i = currentPage - 1; i <= currentPage + 1; i++) {
                            $('<a href="#" class="pagination-item ' + (i === currentPage ? 'active' : '') + '">' +
                                    i + '</a>')
                                .insertBefore(pagination.find('.next'));
                        }

                        $('<span class="pagination-dots">...</span>')
                            .insertBefore(pagination.find('.next'));

                        $('<a href="#" class="pagination-item">' + totalPages + '</a>')
                            .insertBefore(pagination.find('.next'));
                    }
                } else {
                    for (let i = 1; i <= totalPages; i++) {
                        $('<a href="#" class="pagination-item ' + (i === currentPage ? 'active' : '') + '">' + i +
                                '</a>')
                            .insertBefore(pagination.find('.next'));
                    }
                }

                if (currentPage === 1) {
                    pagination.find('.prev').addClass('disabled');
                } else {
                    pagination.find('.prev').removeClass('disabled');
                }

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
                url: "{{ route('driver_statuses.form') }}",
                type: "post",
                data: {
                    _token: '{{csrf_token()}}'
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
            var id = $(this).attr('data-id')
            $(".formTitle").text("Yüklənir...")

            $.ajax({
                url: "{{ route('driver_statuses.form') }}" + "/" + id,
                type: "post",
                data: {
                    _token: '{{csrf_token()}}'
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
            formdata.append("_token", "{{csrf_token()}}")

            $(".formError").remove()

            $.ajax({
                url: $(form).attr('action'),
                type: $(form).attr('method') || 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function(e) {
                    $(".closeAddUser").trigger("click")
                    // $(".success-modal-container").css({
                    //     'display':'flex'
                    // })
                    table.draw();
                    Swal.fire({
                            title: "Uğurlu!",
                            text: e.message,
                            icon: "success",
                            timer: 3000, 
                            timerProgressBar: false,
                            showConfirmButton: false,
                    });
                    // $(".success-modal-container").find('h2').text(e.message)

                },
                error: function(xhr) {
                    for(let a in xhr.responseJSON.errors){
                        for(let b in xhr.responseJSON.errors[a]){
                            if($(form).find("[name='"+a+"']").parents('.form-item').length){
                                $(form).find("[name='"+a+"']").parents('.form-item').append('<p class="formError" style="color:red">'+xhr.responseJSON.errors[a][b]+'</p>')
                            }else if($(form).find("[name='"+a+"']").parents('.add_file_box').length){
                                $(form).find("[name='"+a+"']").parents('.add_file_box').after('<p class="formError" style="color:red">'+xhr.responseJSON.errors[a][b]+'</p>')
                            }
                        }
                    }
                }
            });
        });
        initFileInputUploadStyle('.id_card_front');
        initFileInputUploadStyle('.id_card_back');

        $('#perPageInput').on('input', function () {
            let val = parseInt($(this).val());
            if (!isNaN(val) && val > 0) {
                table.page.len(val).draw();
            }
        });
    });
</script>
@endpush