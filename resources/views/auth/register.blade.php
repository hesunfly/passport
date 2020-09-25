<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Register</title>
    <!-- Custom fonts for this template-->
    <link href="/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="/assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">创建一个账户!</h1>
                        </div>
                        <form class="user">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="username" placeholder="用户名">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" id="email" placeholder="邮箱地址">
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user"
                                           id="password" placeholder="密码">
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user"
                                           id="rePassword" placeholder="确认密码">
                                </div>
                            </div>
                            <a href="javascript:;" id="register_submit" class="btn btn-primary btn-user btn-block">
                                注册账户
                            </a>
                            <hr>
                            <a href="../index.html" class="btn btn-google btn-user btn-block">
                                <i class="fab fa-github fa-fw"></i> 通过 Github 注册
                            </a>
                            {{--<a href="../index.html" class="btn btn-facebook btn-user btn-block">
                                <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                            </a>--}}
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="forgot-password.blade.php">忘记密码?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="login.blade.php">已有账号? 去登录!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Bootstrap core JavaScript-->
<script src="/assets/vendor/jquery/jquery.min.js"></script>
<script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Custom scripts for all pages-->
<script src="/assets/js/sb-admin-2.min.js"></script>
<script src="/assets/vendor/axios/axios.min.js"></script>
<script src="/assets/vendor/layer/layer.js"></script>
<script>
    $(function () {
        $('#register_submit').click(function () {
            let name = $('#username').val();
            if (name.length === 0) {
                layer.msg('账号为必填项！', {
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                    }, function () {
                    }
                );
                return false;
            }

            let email = $('#email').val();
            if (email.length === 0) {
                layer.msg('邮箱为必填项！', {
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                    }, function () {
                    }
                );
                return false;
            }

            let password = $('#password').val();
            if (password.length === 0) {
                layer.msg('密码不可为空！', {
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                    }, function () {
                    }
                );
                return false;
            }

            let password_confirm = $('#rePassword').val();
            if (password_confirm.length === 0) {
                layer.msg('确认密码不可为空！', {
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                    }, function () {
                    }
                );
                return false;
            }

            if (password !== password_confirm) {
                layer.msg('确认密码不一致！', {
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                    }, function () {
                    }
                );
                return false;
            }

            axios.post(
                "{{ url('/register') }}",
                {
                    name, email, password,
                }
            ).then(function (response) {
                layer.msg('注册成功！', {
                        time: 1000 //2秒关闭（如果不配置，默认是3秒）
                    }, function () {
                        window.location.href = response.data;
                    }
                );
            }).catch(function (error) {
                layer.msg('error！', {
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                    }, function () {
                        return false;
                    }
                );
                if (error.request.status === 422) {
                    let msg = JSON.parse(error.request.responseText);
                    let errors = msg.errors;
                    console.log(errors);
                }
            });
        });

    });
</script>
</body>

</html>