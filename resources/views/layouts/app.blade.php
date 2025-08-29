<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/style.css') }}" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">



  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <link rel="stylesheet" href="{{ asset('assets/custom.css') }}?v={{ time() }}">

  <style>
    .dataTables_filter {
      display: none;
    }

    table.dataTable>thead>tr>th,
    table.dataTable>thead>tr>td {
      border: unset;
      text-align: left;
      padding-left: 0;
    }

    .dataTables_paginate {
      display: none;
    }
  </style>


</head>

<body>
  <div class="crm-container">
    @include('layouts.sidebar')
    <div class="crm-body">
      @include('layouts.header')
      @yield('content')
    </div>
  </div>
  <div class="add-user-container ">
    <div class="add-user saveFormArea">
      <h2 class="formTitle">Yüklənir...</h2>
      <button class="closeAddUser" type="button">
        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M6.83765 6.83765C7.01343 6.66209 7.25171 6.56348 7.50015 6.56348C7.74859 6.56348 7.98687 6.66209 8.16265 6.83765L23.1627 21.8377C23.2548 21.9235 23.3286 22.027 23.3799 22.142C23.4311 22.257 23.4587 22.3811 23.4609 22.507C23.4631 22.6329 23.44 22.7579 23.3928 22.8746C23.3457 22.9914 23.2755 23.0974 23.1865 23.1865C23.0974 23.2755 22.9914 23.3457 22.8746 23.3928C22.7579 23.44 22.6329 23.4631 22.507 23.4609C22.3811 23.4587 22.257 23.4311 22.142 23.3799C22.027 23.3286 21.9235 23.2548 21.8377 23.1627L6.83765 8.16265C6.66209 7.98687 6.56348 7.74859 6.56348 7.50015C6.56348 7.25171 6.66209 7.01343 6.83765 6.83765Z" fill="#2C2D33" />
          <path fill-rule="evenodd" clip-rule="evenodd" d="M23.1626 6.83765C23.3381 7.01343 23.4367 7.25171 23.4367 7.50015C23.4367 7.74859 23.3381 7.98687 23.1626 8.16265L8.16255 23.1627C7.98483 23.3283 7.74978 23.4184 7.5069 23.4141C7.26402 23.4098 7.03229 23.3114 6.86052 23.1397C6.68876 22.9679 6.59037 22.7362 6.58608 22.4933C6.5818 22.2504 6.67195 22.0154 6.83755 21.8377L21.8376 6.83765C22.0133 6.66209 22.2516 6.56348 22.5001 6.56348C22.7485 6.56348 22.9868 6.66209 23.1626 6.83765Z" fill="#2C2D33" />
        </svg>
      </button>
    </div>
  </div>


   <div class="error-modal-container" style="display: none;">
      <div class="error-modal">
        <button class="closeError" type="button">
            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.83765 6.83765C7.01343 6.66209 7.25171 6.56348 7.50015 6.56348C7.74859 6.56348 7.98687 6.66209 8.16265 6.83765L23.1627 21.8377C23.2548 21.9235 23.3286 22.027 23.3799 22.142C23.4311 22.257 23.4587 22.3811 23.4609 22.507C23.4631 22.6329 23.44 22.7579 23.3928 22.8746C23.3457 22.9914 23.2755 23.0974 23.1865 23.1865C23.0974 23.2755 22.9914 23.3457 22.8746 23.3928C22.7579 23.44 22.6329 23.4631 22.507 23.4609C22.3811 23.4587 22.257 23.4311 22.142 23.3799C22.027 23.3286 21.9235 23.2548 21.8377 23.1627L6.83765 8.16265C6.66209 7.98687 6.56348 7.74859 6.56348 7.50015C6.56348 7.25171 6.66209 7.01343 6.83765 6.83765Z" fill="#2C2D33"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M23.1626 6.83765C23.3381 7.01343 23.4367 7.25171 23.4367 7.50015C23.4367 7.74859 23.3381 7.98687 23.1626 8.16265L8.16255 23.1627C7.98483 23.3283 7.74978 23.4184 7.5069 23.4141C7.26402 23.4098 7.03229 23.3114 6.86052 23.1397C6.68876 22.9679 6.59037 22.7362 6.58608 22.4933C6.5818 22.2504 6.67195 22.0154 6.83755 21.8377L21.8376 6.83765C22.0133 6.66209 22.2516 6.56348 22.5001 6.56348C22.7485 6.56348 22.9868 6.66209 23.1626 6.83765Z" fill="#2C2D33"/>
            </svg>
        </button>
        <img src="{{ asset('assets/images/error.svg') }}" alt="">
        <h2>Xəta baş verdi!</h2>
        <p></p>
        <a href="" class="goBack">
          Geri qayit
        </a>
      </div>
    </div>



  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="{{ asset('assets/index.js') }}"></script>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(function() {


       $('[name="role_id"]').select2({
              placeholder: "Seçim edin",
              allowClear: true,
              width: '100%'
          });
          
      $(document).ajaxComplete(function () {
          $('.saveForm select').select2({
              placeholder: "Seçim edin",
              allowClear: true,
              width: '100%'
          });
      });


    $("body").on("click", ".deleteTableRow", function() {
        if (confirm("Are you sure to delete this item?")) {
          var model = $(this).attr("data-model");
          var id =$(this).attr("data-id");
          var permission =$(this).attr("data-permission");

          $.ajax({
                url:"{{ route('general.delete') }}",
                type:"post",
                data:{
                    model,id,permission,
                    _token:'{{ csrf_token() }}'
                },
                success:function(e){
                    $('.dataTable').each(function() {
                        $(this).DataTable().draw(false); // false: sayfa numarası korunur
                    });

                    Swal.fire({ title: "Uğurlu!", text: 'Ugurla silindi!', icon: "success", timer: 3000,'showConfirmButton':false });

                    
                    // $(".success-modal-container").css({
                    //     'display':'flex'
                    // });
                    // $(".success-modal-container").find('h2').text('Ugurla silindi!')
                },
                error:function(e){

                }
            })

        }
      });
    });

    function initFileInputUploadStyle(inputClass) {
      $('body').on('change', inputClass, function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const fileName = file.name;
        const fileUrl = URL.createObjectURL(file);

        const documentItem = `
                    <div class="document-item">
                        <div class="document-title">
                        <img src="../assets/icons/documentIcon.svg" alt="">
                        <p>${fileName}</p>
                        </div>
                        <div class="document-actions">
                        <a href="${fileUrl}" class="viewDocument" target="_blank">
                            <img src="../assets/icons/eye-gray.svg" alt="">
                        </a>
                        <button class="deleteDocument">
                            <img src="../assets/icons/trash-gray.svg" alt="">
                        </button>
                        </div>
                    </div>
                    `;

      const parent = $(this).closest('.add_file_box').next('.document-list');
        parent.find('.document-item').remove();
        parent.append(documentItem);
      });

      $('body').on('click', '.deleteDocument', function(e) {
        e.preventDefault();
        $(this).closest('.document-item').remove();
      });
    }
    function initFileInputUpload(selector, formdata, inputName) {
        const fileInput = document.querySelector(selector);
        if (fileInput && fileInput.files.length > 0) {
            formdata.append(inputName, fileInput.files[0]);
        }
    }
    

    $(document).ajaxError(function(event, jqxhr, settings, thrownError) {
        if (jqxhr.status === 403) {
            $(".error-modal-container").css({
              display:"flex"
            });
            $(".error-modal p").text(jqxhr.responseJSON.message);
            $(".closeAddUser").trigger("click")
        }
    });

</script>

  @stack("js")

</body>

</html>