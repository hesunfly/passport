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
                            应用列表
                            <a href="{{ url('apps/create') }}" id="app_create" class="btn btn-success btn-icon-split" style="float: right;height: 1.7rem;line-height: 0.9rem;">
                                <span class="icon text-white-50">
                                    <i class="fas fa-plus"></i>
                                </span>
                                <span class="text">添加</span>
                            </a>
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>标题</th>
                                    <th>App Name</th>
                                    <th>域名</th>
                                    <th>状态</th>
                                    <th>添加时间</th>
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

@component('component.foot-assets')
@endcomponent
<script src="/assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        let data = {!!  $apps !!};

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
                "emptyTable": "暂时没有数据哦！",
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
                { data: 'app_name' },
                { data: 'app_host' },
                {
                    data: 'enable',
                    render: function (data, type, row) {
                        if (Number(data) === 1) {
                            return '正常';
                        }
                        return '关闭';
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
