@extends('layouts.app')


@section('content')


 <div class="profile-container  logoManagement-container">
            <div class="profile-container-head">
                <h1>Profil məlumatları</h1>
            </div>
            <div class="profile-body logoManagement-body">
                <div class="profile-body-head">
                    <h2>Ümumi Məlumatlar</h2>
                </div>
                <form action="" class="profileForm saveForm addLogo"  enctype="multipart/form-data">
                     <div class="form-items">

                     <div style="  grid-column: span 2;">
                        <div class="add_file_box" >
                        <img src="../assets/icons/uploadIcon.svg" alt="" class="uploadIcon">
                        <div class="box-text"> 
                            <p>Select a Müqavilə file or drag and drop here</p>
                            <span>JPG, XLSX or PDF, file size no more than 10MB</span>
                        </div>
                        <p class="selectFileTxt">Fayl seç</p>
                        <input type="file" name="image" class="logo">
                    </div>
                    <div class="logoImg">
                            <img src="/storage/{{ $user->image }}" alt="">
                    </div>
                     </div>
                      


                        <div class="form-item">
                            <label for="">Ad</label>
                            <div class="form-input">
                               
                                <input type="text" name="name" value="{{ $user->name }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Soyad</label>
                            <div class="form-input">
                                <input type="text" name="surname" value="{{ $user->surname }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Email</label>
                            <div class="form-input">
                                <input type="text" name="email" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Rol</label>
                            <select name="" id="">
                                
                                <option value="" >{{ $user->roles->first()?->name }}</option>
                                
                            </select>
                        </div>
                        <div class="form-item">
                            <label for="">Şifrə</label>
                            <div class="form-input">
                                <input name="password" type="password">
                                <button class="password-eye" type="button">
                                    <svg class="eye-open" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 9C12.7956 9 13.5587 9.31607 14.1213 9.87868C14.6839 10.4413 15 11.2044 15 12C15 12.7956 14.6839 13.5587 14.1213 14.1213C13.5587 14.6839 12.7956 15 12 15C11.2044 15 10.4413 14.6839 9.87868 14.1213C9.31607 13.5587 9 12.7956 9 12C9 11.2044 9.31607 10.4413 9.87868 9.87868C10.4413 9.31607 11.2044 9 12 9ZM12 4.5C17 4.5 21.27 7.61 23 12C21.27 16.39 17 19.5 12 19.5C7 19.5 2.73 16.39 1 12C2.73 7.61 7 4.5 12 4.5ZM3.18 12C3.98825 13.6503 5.24331 15.0407 6.80248 16.0133C8.36165 16.9858 10.1624 17.5013 12 17.5013C13.8376 17.5013 15.6383 16.9858 17.1975 16.0133C18.7567 15.0407 20.0117 13.6503 20.82 12C20.0117 10.3497 18.7567 8.95925 17.1975 7.98675C15.6383 7.01424 13.8376 6.49868 12 6.49868C10.1624 6.49868 8.36165 7.01424 6.80248 7.98675C5.24331 8.95925 3.98825 10.3497 3.18 12Z" fill="#A7A7A7"></path>
                                    </svg>
                                    <svg class="eye-close" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 5.27L3.28 4L20 20.72L18.73 22L15.65 18.92C14.5 19.3 13.28 19.5 12 19.5C7 19.5 2.73 16.39 1 12C1.69 10.24 2.79 8.69 4.19 7.46L2 5.27ZM12 9C12.7956 9 13.5587 9.31607 14.1213 9.87868C14.6839 10.4413 15 11.2044 15 12C15.0005 12.3406 14.943 12.6787 14.83 13L11 9.17C11.3213 9.05698 11.6594 8.99949 12 9ZM12 4.5C17 4.5 21.27 7.61 23 12C22.1834 14.0729 20.7966 15.8723 19 17.19L17.58 15.76C18.9629 14.8034 20.0783 13.5091 20.82 12C20.0117 10.3499 18.7565 8.95963 17.1974 7.98735C15.6382 7.01508 13.8375 6.49976 12 6.5C10.91 6.5 9.84 6.68 8.84 7L7.3 5.47C8.74 4.85 10.33 4.5 12 4.5ZM3.18 12C3.98835 13.6501 5.24345 15.0404 6.80264 16.0126C8.36182 16.9849 10.1625 17.5002 12 17.5C12.69 17.5 13.37 17.43 14 17.29L11.72 15C11.0242 14.9254 10.3748 14.6149 9.87997 14.12C9.38512 13.6252 9.07458 12.9758 9 12.28L5.6 8.87C4.61 9.72 3.78 10.78 3.18 12Z" fill="#A7A7A7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Şifrə təkrar</label>
                            <div class="form-input">
                                <input name="password_confirmation" type="password">
                                <button class="password-eye" type="button">
                                    <svg class="eye-open" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 9C12.7956 9 13.5587 9.31607 14.1213 9.87868C14.6839 10.4413 15 11.2044 15 12C15 12.7956 14.6839 13.5587 14.1213 14.1213C13.5587 14.6839 12.7956 15 12 15C11.2044 15 10.4413 14.6839 9.87868 14.1213C9.31607 13.5587 9 12.7956 9 12C9 11.2044 9.31607 10.4413 9.87868 9.87868C10.4413 9.31607 11.2044 9 12 9ZM12 4.5C17 4.5 21.27 7.61 23 12C21.27 16.39 17 19.5 12 19.5C7 19.5 2.73 16.39 1 12C2.73 7.61 7 4.5 12 4.5ZM3.18 12C3.98825 13.6503 5.24331 15.0407 6.80248 16.0133C8.36165 16.9858 10.1624 17.5013 12 17.5013C13.8376 17.5013 15.6383 16.9858 17.1975 16.0133C18.7567 15.0407 20.0117 13.6503 20.82 12C20.0117 10.3497 18.7567 8.95925 17.1975 7.98675C15.6383 7.01424 13.8376 6.49868 12 6.49868C10.1624 6.49868 8.36165 7.01424 6.80248 7.98675C5.24331 8.95925 3.98825 10.3497 3.18 12Z" fill="#A7A7A7"></path>
                                    </svg>
                                    <svg class="eye-close" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 5.27L3.28 4L20 20.72L18.73 22L15.65 18.92C14.5 19.3 13.28 19.5 12 19.5C7 19.5 2.73 16.39 1 12C1.69 10.24 2.79 8.69 4.19 7.46L2 5.27ZM12 9C12.7956 9 13.5587 9.31607 14.1213 9.87868C14.6839 10.4413 15 11.2044 15 12C15.0005 12.3406 14.943 12.6787 14.83 13L11 9.17C11.3213 9.05698 11.6594 8.99949 12 9ZM12 4.5C17 4.5 21.27 7.61 23 12C22.1834 14.0729 20.7966 15.8723 19 17.19L17.58 15.76C18.9629 14.8034 20.0783 13.5091 20.82 12C20.0117 10.3499 18.7565 8.95963 17.1974 7.98735C15.6382 7.01508 13.8375 6.49976 12 6.5C10.91 6.5 9.84 6.68 8.84 7L7.3 5.47C8.74 4.85 10.33 4.5 12 4.5ZM3.18 12C3.98835 13.6501 5.24345 15.0404 6.80264 16.0126C8.36182 16.9849 10.1625 17.5002 12 17.5C12.69 17.5 13.37 17.43 14 17.29L11.72 15C11.0242 14.9254 10.3748 14.6149 9.87997 14.12C9.38512 13.6252 9.07458 12.9758 9 12.28L5.6 8.87C4.61 9.72 3.78 10.78 3.18 12Z" fill="#A7A7A7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button class="saveProfile" type="submit">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 20.289L21.288 17L20.6 16.312L18.5 18.412V13.525H17.5V18.412L15.4 16.312L14.712 17L18 20.289ZM14.5 23.5V22.5H21.5V23.5H14.5ZM4.5 19.5V2.5H13L18.5 8V11.14H17.5V8.5H12.5V3.5H5.5V18.5H12.116V19.5H4.5Z" fill="#7B7676"/>
                        </svg>
                        Yadda saxla
                    </button>
                </form>
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


<script>
    $(function() {
       
    $('body').on('change', '.logo', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const fileName = file.name;
        const fileUrl = URL.createObjectURL(file);
        $(".logoImg img").attr('src',fileUrl)
      });

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
                    $(".success-modal-container").css({
                        'display':'flex'
                    })
                    $(".saveForm")[0].reset()
                    $(".success-modal-container").find('h2').text(e.message)
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
    });
</script>


@endpush