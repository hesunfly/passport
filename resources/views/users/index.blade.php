@component('component.head', ['title' => '用户列表'])
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
                        <h6 class="m-0 font-weight-bold text-primary">用户列表</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>用户名</th>
                                    <th>邮箱</th>
                                    <th>uuid</th>
                                    <th>状态</th>
                                    <th>注册时间</th>
{{--                                    <th>操作</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @component('component.footer')
        @endcomponent
    </div>
</div>
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="auth/login.blade.php">Logout</a>
            </div>
        </div>
    </div>
</div>
@component('component.foot-assets')
@endcomponent
<script src="/assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        let data = {!!  $users !!};

        $('#dataTable').DataTable({
            data:data,
            // dom: 'l <"div.toolbar"> tip',
            ordering: false,
            select: true,
            processing: "处理中...",
            lengthMenu: [ 15, 25, 50, 75, 100],
            language:{
                "processing": "处理中...",
                "lengthMenu": "显示 _MENU_ 项结果",
                "zeroRecords": "没有匹配结果",
                "info": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                "infoEmpty": "显示第 0 至 0 项结果，共 0 项",
                "infoFiltered": "(由 _MAX_ 项结果过滤)",
                "infoPostFix": "",
                "search": "",
                "searchPlaceholder": "输入关键字检索",
                "url": "",
                "emptyTable": "表中数据为空",
                "loadingRecords": "载入中...",
                "infoThousands": ",",
                "paginate": {
                    "first": "首页",
                    "previous": "上页",
                    "next": "下页",
                    "last": "末页"
                },
                "aria": {
                    "paginate": {
                        "first": "首页",
                        "previous": "上页",
                        "next": "下页",
                        "last": "末页"
                    },
                    "sortAscending": "以升序排列此列",
                    "sortDescending": "以降序排列此列"
                },
                "thousands": "."
            },
            columns:[
                { data: 'name' },
                { data: 'email' },
                { data: 'uuid' },
                {
                    data: 'status',
                    render: function (data, type, row) {
                        if (Number(data) === 1) {
                            return '正常';
                        }
                        return '禁用';
                    }
                },
                { data: 'created_at'},
            ]
        });
    });
</script>
<style>
</style>
</body>

</html>
