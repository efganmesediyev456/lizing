<!DOCTYPE html>
<html lang="az">

<head>
    <meta charset="UTF-8">
    <title>Uğurlu Əməliyyat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #F6F6F6;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .success-container {
            text-align: center;
            background-color: #F6F6F6;
            padding: 40px;
            border-radius: 10px;
            max-width: 500px;
        }

        .success-container img {
            height: auto;
            margin-bottom: 20px;
        }

        .success-container h1 {
            font-family: Roboto;
            font-weight: 600;
            font-style: SemiBold;
            font-size: 20px;
            leading-trim: NONE;
            line-height: 30px;
            letter-spacing: 0px;
            text-align: center;
            margin-bottom: 20px;
        }

        .success-container p {

            font-family: Roboto;
            font-weight: 400;
            font-style: Regular;
            font-size: 16px;
            leading-trim: NONE;
            line-height: 24px;
            letter-spacing: 0%;
            text-align: center;
            margin-bottom: 30px;
            color: #979797;
        }

        .success-container a {
            display: inline-block;
            color: white;
            position: absolute;
            bottom: 0;
            left: 10px;
            text-decoration: unset;
            angle: 0 deg;
            opacity: 1;
            border-radius: 24px;
            padding-top: 14px;
            padding-right: 12px;
            padding-bottom: 14px;
            padding-left: 12px;
            gap: 10px;
            background: #1E1E1E;
            width: calc(100% - 40px);
        }

        .success-container a:hover {
            background-color: #059669;
        }
    </style>
</head>

<body>

    <div class="success-container" style="display:none;" id="success-container">
        <img src="{{ asset('storage/' . $success->image) }}" alt="Success"> <!-- şəkil yolu burada -->
        <h1>{{ $success->name }}</h1>
        <p>{{ $success->description }}</p>
        <a href="{{ url('/') }}">Qəbzi göstər</a>
    </div>

    <div class="success-container" style="display:none;" id="error-container">
        <img width="112px" src="{{ asset('/assets/images/errorpayment.png') }}" alt="Success"> <!-- şəkil yolu burada -->
        <h1>Xəta</h1>
        <p>Ödəniş zamanı xəta baş verdi. Təkrar cəhd edin!</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function() {
            $.ajax({
                url: "{{ route('order.status', ['kapital_order_id' => request()->ID]) }}",
                method: 'POST',
                data: {
                    '_token': "{{ csrf_token() }}",
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Uğurlu əməliyyat!',
                        text: 'Ödənişiniz uğurla tamamlandı.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $("#success-container").fadeIn();
                    });

                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Xəta baş verdi!',
                        text: 'Zəhmət olmasa yenidən cəhd edin.',
                        showConfirmButton: false,
                        timer: 2000,
                    }).then(() => {
                        $("#error-container").fadeIn();
                    });
                }
            });
        });
    </script>

</body>

</html>
