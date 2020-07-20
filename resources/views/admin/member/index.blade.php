@extends('admin.base')

@section('content')
    <div class="layui-card">
{{--        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">
                @can('member.member.destroy')
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删除</button>
                @endcan
                @can('member.member.create')
                   <!--  <a class="layui-btn layui-btn-sm" href="{{ route('admin.member.create') }}">添加</a> -->
                @endcan
                <button class="layui-btn layui-btn-sm" id="memberSearch">搜索</button>
            </div>
            <div class="layui-form">
                <div class="layui-input-inline">
                    <input type="text" name="name" id="name" placeholder="请输入昵称" class="layui-input">
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="phone" id="phone" placeholder="请输入手机号" class="layui-input">
                </div>
            </div>
        </div>--}}
        <blockquote class="layui-elem-quote">
            <div class="layui-btn-group ">
                @can('zixun.article.destroy')
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删 除</button>
                @endcan
            </div>
            <form class="layui-form" style="float:right;">
                <div class="layui-form-item" style="margin:0;">
                    <input type="hidden" name="app" value="travel" />
                    <label class="layui-form-label">名称</label>
                    <div class="layui-input-inline">
                        <input type="text" name="keywords" placeholder="支持模糊查询.." autocomplete="off" class="layui-input1">
                    </div>
                    <div class="layui-form-mid layui-word-aux" style="padding:0;">
                        <button lay-filter="search" class="layui-btn" lay-submit style="height:38px;line-height:38px;"><i class="fa fa-search" aria-hidden="true"></i> 查询</button>
                    </div>
                </div>
            </form>
        </blockquote>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('member.member.create')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan


                    @can('member.member.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan

                </div>
            </script>
            <script type="text/html" id="avatar">
                <a href="@{{d.avatar}}" target="_blank" title="点击查看"><img src="@{{d.avatar}}" alt="" width="28" height="28"></a>
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('member.member')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,height: 500
                    ,url: "{{ route('admin.member.data') }}" //数据接口
                    ,where:{model:"member"}
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'nickname', title: '昵称'}
                        ,{field: 'avatar', title: '头像',toolbar:'#avatar',width:100}
                        ,{field: 'amount', title: '账户余额'}
                        ,{field: 'freeze', title: '冻结余额'}
                        ,{field: 'gender', title: '性别'}
                        ,{field: 'created', title: '创建时间'}
                        ,{field: 'updated', title: '登陆时间'}
                        ,{fixed: 'right', width: 120, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('admin.member.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg)
                            });
                        });
                    } else if(layEvent === 'edit'){
                        location.href = '/admin/member/'+data.id+'/edit';
                    }
                });

                //按钮批量删除
                $("#listDelete").click(function () {
                    var ids = []
                    var hasCheck = table.checkStatus('dataTable')
                    var hasCheckData = hasCheck.data
                    if (hasCheckData.length>0){
                        $.each(hasCheckData,function (index,element) {
                            ids.push(element.id)
                        })
                    }
                    if (ids.length>0){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('admin.member.destroy') }}",{_method:'delete',ids:ids},function (result) {
                                if (result.code==0){
                                    dataTable.reload()
                                }
                                layer.close(index);
                                layer.msg(result.msg)
                            });
                        })
                    }else {
                        layer.msg('请选择删除项')
                    }
                })
                //搜索
                $("#memberSearch").click(function () {
                    var userSign = $("#user_sign").val()
                    var name = $("#name").val();
                    var phone = $("#phone").val();
                    dataTable.reload({
                        where:{user_sign:userSign,name:name,phone:phone},
                        page:{curr:1}
                    })
                })
            })
        </script>
    @endcan
@endsection



