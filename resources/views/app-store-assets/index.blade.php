@extends('layouts.app')


@section('content')

    <div class="logoManagement-container">
        <div class="logoManagement-container-head">
            <h1>App məlumatlar</h1>
        </div>
        <div class="logoManagement-body">
            <div class="logoManagement-body-head">
                <h2>Ümumi Məlumatlar</h2>
            </div>
    <form action="{{ route('app-store-assets.save') }}" class="addLogo saveForm"
                enctype="multipart/form-data">
                @method('put')
                @csrf

        <div class="form-item">
            <label>App Name</label>
            <input type="text" name="app_name" class="form-control"  value="{{ $asset->app_name }}">
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" >{{ $asset->description }}</textarea>
        </div>

        <div class="form-group">
            <label>Full Description</label>
            <textarea name="full_description" class="form-control" >{{ $asset->full_description }}</textarea>
        </div>

        <div class="form-group">
            <label>App Icon (512x512 px)</label>
            <input type="file" name="app_icon" class="form-control-file" accept="image/*" >
            <img width="300px" src="{{  '/storage/'.$asset->icon_path  }}" alt="">
        </div>

         <div class="form-group">
            <label>Feature graphic(play store da background photo) - 1024x500
</label>
            <input type="file" name="feature_graphic_image" class="form-control-file" accept="image/*" >
            <img width="300px" src="{{  '/storage/'.$asset->feature_graphic_image  }}" alt="">
        </div>

        <div class="form-group">
            <label>Screenshots - 16:9 2-8 photo </label>
            <input type="file" name="screenshots[]" class="form-control-file" accept="image/*" multiple>
            @foreach($asset->screenshot_paths as $path)
                <img width="300px" src="{{ $path }}" alt="">
            @endforeach
        </div>

         <div class="form-group">
            <label>Tablet - 16:9 tablet view 2-8 photo </label>
            <input type="file" name="tablets[]" class="form-control-file" accept="image/*" multiple>
            @foreach($asset->tablets as $path)
                <img width="300px" src="{{ $path }}" alt="">
            @endforeach
        </div>

        <div class="form-group">
            <label>App Category</label>
            <select name="app_category" class="form-control" required>
                <option value="">Select Category</option>
                <option @selected($asset->app_category == 'productivity') value="productivity">Productivity</option>
                <option @selected($asset->app_category == 'education') value="education">Education</option>
                <option @selected($asset->app_category == 'entertainment')  value="entertainment">Entertainment</option>
                <option  @selected($asset->app_category == 'games') value="games">Games</option>
            </select>
        </div>

        <div class="form-group">
            <label>Privacy Policy URL (Optional)</label>
            <input type="url" name="privacy_policy_url" class="form-control" value="{{ $asset->privacy_policy_url }}">
        </div>


                <button class="saveLogo" type="submit">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M18 20.289L21.288 17L20.6 16.312L18.5 18.412V13.525H17.5V18.412L15.4 16.312L14.712 17L18 20.289ZM14.5 23.5V22.5H21.5V23.5H14.5ZM4.5 19.5V2.5H13L18.5 8V11.14H17.5V8.5H12.5V3.5H5.5V18.5H12.116V19.5H4.5Z"
                            fill="#7B7676" />
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


@push("js")


    <script>
        $(function () {

            $('body').on('change', '.logo', function (e) {
                const file = e.target.files[0];
                if (!file) return;
                const fileName = file.name;
                const fileUrl = URL.createObjectURL(file);
                $(".logoImg img").attr('src', fileUrl)
            });

            $('body').on('submit', '.saveForm', function (e) {
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
                    success: function (e) {
                        $(".closeAddUser").trigger("click")
                        $(".success-modal-container").css({
                            'display': 'flex'
                        })
                        $(".success-modal-container").find('h2').text(e.message)
                    },
                    error: function (xhr) {
                        for (let a in xhr.responseJSON.errors) {
                            for (let b in xhr.responseJSON.errors[a]) {
                                if ($(form).find("[name='" + a + "']").parents('.form-item').length) {
                                    $(form).find("[name='" + a + "']").parents('.form-item').append('<p class="formError" style="color:red">' + xhr.responseJSON.errors[a][b] + '</p>')
                                } else if ($(form).find("[name='" + a + "']").parents('.add_file_box').length) {
                                    $(form).find("[name='" + a + "']").parents('.add_file_box').after('<p class="formError" style="color:red">' + xhr.responseJSON.errors[a][b] + '</p>')
                                }
                            }
                        }
                    }
                });
            });
        });
    </script>


@endpush