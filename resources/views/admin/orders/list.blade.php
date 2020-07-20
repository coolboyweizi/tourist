@extends('admin.base')

@section('content')

<div style="margin:0px; background-color: white; margin:0 10px;">
    <blockquote class="layui-elem-quote">
        <div class="layui-btn-group ">
            @can('zixun.article.destroy')
                <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删 除</button>
            @endcan
        </div>
        <form class="layui-form" style="float:right;">
            <div class="layui-form-item" style="margin:0;">
                <label class="layui-form-label">订单号</label>
                <div class="layui-input-inline">
                    <input type="hidden" name="app" value="order" />
                    <input type="text" name="keywords" placeholder="仅支持订单号查询.." autocomplete="off" class="layui-input1">
                </div>
                <div class="layui-form-mid layui-word-aux" style="padding:0;">
                    <button lay-filter="search" class="layui-btn" lay-submit style="height:38px;line-height:38px;"><i class="fa fa-search" aria-hidden="true"></i> 查询</button>
                </div>
            </div>
        </form>
    </blockquote>
    <div class="layui-card-body"><div id="content" style="width: 100%;height: 533px;"></div></div>
</div>
@endsection

@section('script')
    <script>
    layui.config({
        base: '/static/admin/js/',
        v: new Date().getTime()
    }).use(['xmerge','form'], function () {


        var xmerge = layui.xmerge(),
            $ = layui.jquery,
            layerTips = parent.layer === undefined ? layui.layer : parent.layer, //获取父窗口的layer对象
            layer = layui.layer,//获取当前窗口的layer对象;
            form = layui.form;

        xmerge.page({
            url:  app_url + 'order',                 //数据源地址
            columns: [{
                    fieldName: '订单号',
                    field: 'order_id',
                    format: function(value,obj) {
                        return obj == undefined ? '00' : value 
                    }
                },{
                    fieldName: '订购者',
                    field: 'nickname',
                },{
                    fieldName: '图片',
                    field: 'avatar',
                    format: function (id, obj) {
                        //id
                        //行数据对象
                        //返回值：格式化的纯文本或html文本
                        if (obj == undefined) {
                            return '';
                        }
                        var html = "<img style='width: 50px; height: 50px;' src='"+obj.avatar+"' />";
                        return html;
                    }
                },{
                    fieldName: '订单产品',
                    field: 'appAlias',
                },{                          //配置数据列
                    fieldName: '购买产品',                //显示名称
                    field: 'appTitle',                  //字段名
                    sortable: true ,//是否显示排序
                    format: function (id, obj) {
                        //id
                        //行数据对象
                        //返回值：格式化的纯文本或html文本
                        if (obj == undefined) {
                            return '';
                        }
                        return '<span style="width:200px;overflow:hidden;display: inline-block">'+obj.appTitle+'</span>';
                    }
                },{
                    fieldName: '订单金额',
                    field: 'amount',
                },{
                    fieldName: '下单时间',
                    field: 'created',
                },{
                    fieldName: '备注',
                    field: 'remark'
                },{
                    fieldName: '操作',
                    field: 'id',
                    format: function (val,obj) {
                        if (obj == undefined ) {
                            return '';
                        }
                        var html =  '<input type="button" value="'+obj.statusCn+'" data-status="'+ obj.status +'" data-action="edit" data-id="' + val + '" class="layui-btn layui-btn-mini" />' +
                                    '<input type="button" value="删除" data-action="del" data-id="' + val + '" class="layui-btn layui-btn-mini layui-btn-danger" />';
                        return html;
                    }
                }],

            onSuccess: function ($elem) {
                $elem.children('tr').each(function () {
                    $(this).children('td:last-child').children('input').each(function () {
                        var $that = $(this);
                        var action = $that.data('action');
                        var id = $that.data('id');
                        var status = $that.data('status');
                        var name = $that.parent('td').siblings('td[data-field=appTitle]').text();
                        $that.on('click', function () {
                            switch (action) {

                                case 'edit':
                                    var name = $that.parent('td').siblings('td[data-field=appTitle]').text();
                                    // 向前进步1
                                    if (status == 3) {
                                        layer.alert('[ <span style="color:red;">' + name + '</span> ] 订单已经完成', {icon: 1});
                                        break;
                                    }
                                    xmerge.set({
                                        url: app_url + 'order',
                                        data: {
                                            status: status + 1
                                        },
                                        id: id
                                    });
                                    xmerge.put(function (resp) {
                                        // 回调函数
                                        if (resp.code === 0) {
                                            window.location.reload()
                                        } else {
                                            layer.alert('[ <span style="color:red;">' + name + '</span> ] ' + resp.data, {icon: 2});
                                        }
                                    });
                                    break;

                                case 'del': //删除
                                    xmerge.set({
                                        url: app_url + 'order',
                                        id:id,
                                        data:{
                                            force:false
                                        },
                                        success:function(resp){
                                            if(resp.code === 0) {
                                                layer.msg('删除成功', {
                                                    icon: 1,//提示的样式
                                                    time: 3000,
                                                    end:function(){
                                                        $that.parent('td').parent('tr').remove();
                                                        layerTips.msg('删除成功.');
                                                    }
                                                })
                                            }else {
                                                layerTips.msg('删除失败');
                                            }
                                        }
                                    });
                                    var name = $that.parent('td').siblings('td[data-field=title]').text();
                                    //询问框
                                    layerTips.confirm('确定要删除[ <span style="color:red;">' + name + '</span> ] ？', { icon: 3, title: '系统提示' }, function (index) {
                                        xmerge.delete();
                                    });
                                    break;
                            }
                        });
                    });
                });
            }
        });



        //监听搜索表单的提交事件
        form.on('submit(search)', function (data) {
            pageList.search(data.field);
            return false;
        });
        $(window).on('resize', function (e) {
            var $that = $(this);
            $('#content').height($that.height() - 92);
        }).resize();
    });
    </script>
@endsection
