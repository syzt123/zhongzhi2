@extends('admin.layout.detail')
<style type="text/css">
    #pull_right{
        text-align:center;
    }
    .pull-right {
        /*float: left!important;*/
    }
    .pagination {
        display: inline-block;
        padding-left: 0;
        margin: 20px 0;
        border-radius: 4px;
    }
    .pagination > li {
        display: inline;
    }
    .pagination > li > a,
    .pagination > li > span {
        position: relative;
        float: left;
        padding: 6px 12px;
        margin-left: -1px;
        line-height: 1.42857143;
        color: #428bca;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd;
    }
    .pagination > li:first-child > a,
    .pagination > li:first-child > span {
        margin-left: 0;
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }
    .pagination > li:last-child > a,
    .pagination > li:last-child > span {
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }
    .pagination > li > a:hover,
    .pagination > li > span:hover,
    .pagination > li > a:focus,
    .pagination > li > span:focus {
        color: #2a6496;
        background-color: #eee;
        border-color: #ddd;
    }
    .pagination > .active > a,
    .pagination > .active > span,
    .pagination > .active > a:hover,
    .pagination > .active > span:hover,
    .pagination > .active > a:focus,
    .pagination > .active > span:focus {
        z-index: 2;
        color: #fff;
        cursor: default;
        background-color: #428bca;
        border-color: #428bca;
    }
    .pagination > .disabled > span,
    .pagination > .disabled > span:hover,
    .pagination > .disabled > span:focus,
    .pagination > .disabled > a,
    .pagination > .disabled > a:hover,
    .pagination > .disabled > a:focus {
        color: #777;
        cursor: not-allowed;
        background-color: #fff;
        border-color: #ddd;
    }
    .clear{
        clear: both;
    }
</style>
@section('sidebar')
    @parent

@endsection

@section('content')
        <div class="layui-table">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="pull-left">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <form action="" method="post" >{{--onsubmit="return sort()"--}}
                        {{ csrf_field() }}
                        <div class="box-body">

                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th>??????id</th>
                                    <th>?????????</th>
                                    <th>??????????????????</th>
                                    <th>???????????????????????????</th>
                                    <th>??????????????????????????????</th>
                                   {{-- <th>??????/?????????/?????????</th>--}}
                                </tr>
                                @if($result->count())
                                    @foreach($result as $key=>$value)
                                        <tr>
                                            <td>{{ $value->id ?? ''}}</td>
                                            <td>{{ isset($value->land->id) ?$value->land->name: ''}} </td>
                                            <td>{{ $value->number ?? ''}} </td>

                                            <td>{{ isset($value->user->id) ?$value->user->nickname:  ''}} </td>
                                            <td>{{ isset($value->user->tel) ?$value->user->tel: ''}} </td>
                                           {{-- <td>
                                               ?????????
                                            </td>--}}

                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">????????????</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </form>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        @if($result->count())
                            <div class="pull-left" style="padding-top: 8px;white-space: nowrap;">
                                ????????? {{ $result->firstItem() }} ?????? {{ $result->lastItem() }} ??????????????????{{ $result->total() }}?????????
                            </div>
                        @endif

                            {{ $result->links("vendor.pagination.default") }}
                    </div>
                </div>
            </div>
        </div>
@endsection
<script type="text/html" id="toolbarDemo">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm" lay-event="add">??????</button>
    </div>
</script>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-xs" lay-event="edit">??????</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">??????</a>

</script>
<script type="text/html" id="txVideoUrl">
    <a class="layui-btn layui-btn-xs" lay-event="getVideoUrl">????????????</a>
</script>
@section('js')

    <script>
        //JS
        layui.use(['table', 'layer'], function () {
            var table = layui.table, $ = layui.$;
            var layer = layui.layer;
            table.render({
                elem: '#test'
                , url: "{{url('admin/number/data')}}"
                , toolbar: '#toolbarDemo' //???????????????????????????????????????????????????
                , page: true //????????????
                , cellMinWidth: 80 //?????????????????????????????????????????????layui 2.2.1 ??????
                , cols: [[
                    {field: 'id', min: 80, title: 'ID', sort: true}
                    , {field: 'number', min: 80, title: '????????????'}
                    , {field: 'number', min: 80, title: '??????????????????'}
                    , {field: 'number', min: 80, title: '????????????'}
                    , {field: 'l_status', min: 80, title: '??????'}
                    , {fixed: 'right', title: '??????', toolbar: '#barDemo', width: 150}
                ]]
                , parseData: function (res) { //res ???????????????????????????
                    return {
                        "code": !res.code, //??????????????????
                        "msg": res.message, //??????????????????
                        "count": res.data.total, //??????????????????
                        "data": res.data.data //??????????????????
                    };
                }
            });


            //??????????????????
            table.on('toolbar(test)', function (obj) {
                var checkStatus = table.checkStatus(obj.config.id);
                switch (obj.event) {
                    case 'add':
                        window.location = "{{url('admin/number/add')}}";
                        break;
                }
            });
            //?????????????????????
            table.on('tool(test)', function (obj) {
                var data = obj.data;
                if (obj.event === 'del') {
                    layer.confirm('??????????????????', function (index) {
                        $.ajax({
                            url: "{{url('admin/number/del/id')}}".replace(/id/, data.id),
                            type: 'delete'
                            , headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            }
                            , success: function (res) {
                                if (res.code) {
                                    obj.del();
                                    layer.close(index);
                                    table.render(
                                        {
                                            elem: '#test'
                                            , url: "{{url('admin/number/data')}}"
                                            , toolbar: '#toolbarDemo' //???????????????????????????????????????????????????
                                            , page: true //????????????
                                            , cellMinWidth: 80 //?????????????????????????????????????????????layui 2.2.1 ??????
                                            , cols: [[
                                                {field: 'id', min: 80, title: 'ID', sort: true}
                                                , {field: 'monitor', min: 80, title: '???????????????'}
                                                , {field: 'v_num', min: 80, title: '?????????'}
                                                , {field: 'l_status', min: 80, title: '??????'}
                                                , {fixed: 'right', title: '??????', toolbar: '#barDemo', width: 150}
                                            ]]
                                            , parseData: function (res) { //res ???????????????????????????
                                                // console.log(res)
                                                // for (var i = 0; i < res.data.data.length; i++) {
                                                //     res.data.data[i].v_price = res.data.data[i].v_price / 100
                                                //     res.data.data[i].n_price = res.data.data[i].n_price / 100
                                                // }
                                                return {
                                                    "code": !res.code, //??????????????????
                                                    "msg": res.message, //??????????????????
                                                    "count": res.data.total, //??????????????????
                                                    "data": res.data.data //??????????????????
                                                };
                                            }
                                        }
                                    )
                                } else {
                                    layer.msg(res.message)
                                }

                            },
                            error: function (data) {
                                layer.alert(JSON.stringify(data), {
                                    title: data
                                });
                            }
                        })
                    });
                } else if (obj.event === 'edit') {
                    window.location = "{{ url('admin/number/edit/id') }}".replace(/id/, data.id);
                }

            });
        });
    </script>

@endsection
