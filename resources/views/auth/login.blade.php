@component('component.head', ['title' => '登录'])
@endcomponent
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
                            <h1 class="h4 text-gray-900 mb-4">欢迎登录!</h1>
                        </div>
                        <form class="user">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="username"  placeholder="用户名/邮箱">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="password" placeholder="密码">
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" id="customCheck">
                                    <label class="custom-control-label" for="customCheck">记住密码</label>
                                </div>
                            </div>
                            <a href="javascript:;" id="login_submit" class="btn btn-primary btn-user btn-block">
                                登录
                            </a>
                            <hr>
                            <a href="../index.html" class="btn btn-google btn-user btn-block">
                                <i class="fab fa-github fa-fw"></i> 通过 Github 登录
                            </a>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="forgot-password.blade.php">忘记密码?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="login.blade.php">还没有账户? 去注册!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@component('component.foot-assets')
@endcomponent
<script>
    $(function () {
        $('#login_submit').click(function () {
            let username = $('#username').val();
            if (username.length === 0) {
                layer.msg('账号为必填项！', {
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

            axios.post(
                "{{ url('/login') }}",
                {
                    username, password,
                }
            ).then(function (response) {
                layer.msg('登录成功！', {
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
