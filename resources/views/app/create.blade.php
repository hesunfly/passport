@component('component.head', ['title' => '应用列表'])
@endcomponent
<body id="page-top">
<div id="wrapper">
    @component('component.sidebar')
    @endcomponent
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @component('component.header')
            @endcomponent
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            添加应用
                        </h6>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group"><label for="exampleFormControlInput1">应用</label><input
                                    class="form-control" id="name" type="text"
                                    placeholder="应用名称">
                            </div>
                            <div class="form-group"><label for="exampleFormControlInput1">域名</label><input
                                    class="form-control" id="app_host" type="text"
                                    placeholder="应用域名">
                            </div>
                            <div class="form-group"><label for="exampleFormControlInput1">状态</label>
                                <div class="custom-control custom-radio">
                                <span>
                                <input class="custom-control-input" id="enable" type="radio" value="1" name="enabled">
                                <label class="custom-control-label" for="enable">启用</label>
                                    </span>
                                    &ensp;&ensp;&ensp;&ensp;
                                    <span>
                                <input class="custom-control-input" id="disabled" checked type="radio" value="0" name="enabled">
                                <label class="custom-control-label" for="disabled">关闭</label>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-outline-primary" id="app_submit" type="button">提交</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        @component('component.footer')
        @endcomponent
    </div>
</div>

@component('component.foot-assets')
@endcomponent

<script>
    $(function () {
        $('#app_submit').click(function () {
            let name = $('#name').val();
            if (name.length === 0) {
                layer.msg('应用名称为必填项！', {
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                    }, function () {
                    }
                );
                return false;
            }

            let app_host = $('#app_host').val();
            if (app_host.length === 0) {
                layer.msg('应用域名为必填项！', {
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                    }, function () {
                    }
                );
                return false;
            }

            let enabled = $("input[name='enabled']:checked").val();

            axios.post(
                "{{ url('/apps/store') }}",
                {
                    name, app_host, enabled,
                }
            ).then(function (response) {
                layer.msg('添加成功！', {
                        time: 1000 //2秒关闭（如果不配置，默认是3秒）
                    }, function () {
                        window.location.href = "{{ url('apps') }}";
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


<style>
</style>
</body>

</html>
