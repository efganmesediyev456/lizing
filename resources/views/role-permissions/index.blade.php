@extends('layouts.app')


@section('content')



@if(session()->has('success'))
  <div class="success-modal-container" style="display: flex;">
            <div class="success-modal">
                <button class="closeSuccess" type="button">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.83765 6.83765C7.01343 6.66209 7.25171 6.56348 7.50015 6.56348C7.74859 6.56348 7.98687 6.66209 8.16265 6.83765L23.1627 21.8377C23.2548 21.9235 23.3286 22.027 23.3799 22.142C23.4311 22.257 23.4587 22.3811 23.4609 22.507C23.4631 22.6329 23.44 22.7579 23.3928 22.8746C23.3457 22.9914 23.2755 23.0974 23.1865 23.1865C23.0974 23.2755 22.9914 23.3457 22.8746 23.3928C22.7579 23.44 22.6329 23.4631 22.507 23.4609C22.3811 23.4587 22.257 23.4311 22.142 23.3799C22.027 23.3286 21.9235 23.2548 21.8377 23.1627L6.83765 8.16265C6.66209 7.98687 6.56348 7.74859 6.56348 7.50015C6.56348 7.25171 6.66209 7.01343 6.83765 6.83765Z" fill="#2C2D33"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M23.1626 6.83765C23.3381 7.01343 23.4367 7.25171 23.4367 7.50015C23.4367 7.74859 23.3381 7.98687 23.1626 8.16265L8.16255 23.1627C7.98483 23.3283 7.74978 23.4184 7.5069 23.4141C7.26402 23.4098 7.03229 23.3114 6.86052 23.1397C6.68876 22.9679 6.59037 22.7362 6.58608 22.4933C6.5818 22.2504 6.67195 22.0154 6.83755 21.8377L21.8376 6.83765C22.0133 6.66209 22.2516 6.56348 22.5001 6.56348C22.7485 6.56348 22.9868 6.66209 23.1626 6.83765Z" fill="#2C2D33"/>
                    </svg>
                </button>
                <img src="./assets/images/success.svg" alt="">
                <h2>Uğurla əlavə olundu !</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam in lacinia orci, non porttitor.</p>
                <a href="" class="goBack">
                Geri qayit
                </a>
            </div>
        </div>
@endif

<div class="rolePermission-container">
            <div class="rolePermission-container-head">
                <h1>Rol İcazələri</h1>
                <div class="head-buttons">
                    <a href="" class="export_excel">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.75022 16.5C0.000222408 17.25 0.750222 9 6.75022 9.75C4.50022 1.5 17.2502 1.5 16.5002 7.5C24.0002 5.25 24.0002 17.25 17.2502 16.5M8.25022 19.5L12.0002 22.5M12.0002 22.5L15.7502 19.5M12.0002 22.5V12" stroke="#7B7676" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        Export
                    </a>
                    <a href="{{ route('role-permissions.create') }}" class="addNewRolePermission">
                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.5 12.998H13.5V17.998C13.5 18.2632 13.3946 18.5176 13.2071 18.7051C13.0196 18.8926 12.7652 18.998 12.5 18.998C12.2348 18.998 11.9804 18.8926 11.7929 18.7051C11.6054 18.5176 11.5 18.2632 11.5 17.998V12.998H6.5C6.23478 12.998 5.98043 12.8926 5.79289 12.7051C5.60536 12.5176 5.5 12.2632 5.5 11.998C5.5 11.7328 5.60536 11.4784 5.79289 11.2909C5.98043 11.1033 6.23478 10.998 6.5 10.998H11.5V5.99799C11.5 5.73277 11.6054 5.47842 11.7929 5.29088C11.9804 5.10334 12.2348 4.99799 12.5 4.99799C12.7652 4.99799 13.0196 5.10334 13.2071 5.29088C13.3946 5.47842 13.5 5.73277 13.5 5.99799V10.998H18.5C18.7652 10.998 19.0196 11.1033 19.2071 11.2909C19.3946 11.4784 19.5 11.7328 19.5 11.998C19.5 12.2632 19.3946 12.5176 19.2071 12.7051C19.0196 12.8926 18.7652 12.998 18.5 12.998Z" fill="white"></path>
                        </svg>
                        Əlavə et
                    </a>
                </div>
            </div>
            <div class="rolePermission-body">
                <div class="rolePermission-table">
                    
                                {!! $dataTable->table(['class' => 'table table-bordered']) !!}
                </div>
            </div>
        </div>


<div class="pagination-result">
    <p class="result-text" id="result-text">Showing 1 to 10 of 50 entries</p>
    <div class="pagination-result-right">
        <div class="show_count">
            <span>Display</span>
            <input type="number">
        </div>
        <div class="pagination">
            <a href="" class="prev">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 12L6 8L10 4" stroke="#343A40" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
            <a href="" class="pagination-item active">1</a>
            <a href="" class="pagination-item">2</a>
            <a href="" class="pagination-item">3</a>
            <a href="" class="pagination-item">4</a>
            <a href="" class="next">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 12L10 8L6 4" stroke="#343A40" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>
    </div>
</div>
@endsection


@push("js")

{!! $dataTable->scripts() !!}

<script>
    $(function() {
        let tableId = '{{ $tableId ?? "role-permissions-table" }}';
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

            // Yeni pagination itemları əlavə edirik
            for (let i = 1; i <= totalPages; i++) {
                let activeClass = i === currentPage ? 'active' : '';
                $('<a href="#" class="pagination-item ' + activeClass + '">' + i + '</a>')
                    .insertBefore(pagination.find('.next'));
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
            $.ajax({
                url: "{{ route('role-managements.form') }}",
                type: "post",
                data: {
                    _token: '{{csrf_token()}}'
                },
                success: function(e) {
                    $(".saveFormArea").append(e.view)
                },
                error: function() {

                }
            })
        })

        $("body").on('click', '.editItem', function() {
            $(".message").remove()
            $(".saveForm").remove()
            var id = $(this).attr('data-id')
            $.ajax({
                url: "{{ route('role-managements.form') }}" + "/" + id,
                type: "post",
                data: {
                    _token: '{{csrf_token()}}'
                },
                success: function(e) {
                    $(".saveFormArea").append(e.view)
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

           

            $.ajax({
                url: $(form).attr('action'),
                type: $(form).attr('method') || 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function(e) {
                    $(".saveForm").remove()
                    $(".saveFormArea").append(e.view);
                    table.draw()

                },
                error: function(xhr) {
                    console.log("Xəta baş verdi:", xhr);
                }
            });
        });



        initFileInputUploadStyle('.id_card_front');
        initFileInputUploadStyle('.id_card_back');
    });
</script>


@endpush