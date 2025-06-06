<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style.css" />
</head>
<body>

    <div class="entry-container">
        <img src="./assets/images/entryBg.png" alt="" class="bgImg">
        <div class="entry-box">
            <div class="logo">
                <img src="./assets/images/crmLogo.svg" alt="">
            </div>
            <h1 class="box-title">DAXİL OL</h1>
            <form action="" id="loginForm">
                 <div id="error-message" style="color:red; display:none;margin-bottom:24px;"></div>
                 <div id="success-message" style="color:green; display:none;margin-bottom:24px;"></div>

                <div class="form-inputs">
                    <input id="email" type="email" placeholder="Email" name="email">
                    <input id="password" type="password" placeholder="Password" name="password">
                </div>
                <div class="form-bottom">
                    <div class="saveMemory">
                        <input type="checkbox">
                        <label for="">Yadda saxla</label>
                    </div>
                    <a href="forgetPassword.html" class="forgetPasswordLink">Şifrəni unutmusuz?</a>
                </div>
                <button class="submitBtn" type="submit">Daxil ol</button>
            </form>
            
        </div>
    </div>

    <script src="./assets/index.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                
                var email = $('#email').val();
                var password = $('#password').val();

                $.ajax({
                    url: '/login',
                    method: 'POST',
                    data: {
                        email: email,
                        password: password,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#success-message').text(response.success).show();
                        $('#error-message').hide();
                        setTimeout(function(e){
                            window.location.href="/dashboard"
                        },2000);
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            $('#error-message').text(errors.email ? errors.email[0] : errors.password[0]).show();
                        } else {
                            $('#error-message').text(xhr.responseJSON.error).show();
                        }
                        $('#success-message').hide();
                    }
                });
            });
        });
    </script>

</body>
</html>