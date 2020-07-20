@extends('admin.base')

@section('content')

<div style="margin:0px; background-color: white; margin:0 10px;">
    <blockquote class="layui-elem-quote">
        <div class="layui-btn-group ">
            @can('zixun.article.destroy')
                <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删 除</button>
            @endcan
        </div>
        <!--
        <form class="layui-form" style="float:right;">
            <div class="layui-form-item" style="margin:0;">
                <label class="layui-form-label">状态</label>
                <div class="layui-input-inline">
                    <input type="hidden" name="app" value="wxPayRecord" />
                     <select name="keywords" lay-verify="required">
                        <option value="0">未处理</option>
                        <option value="1">已通过</option>
                        <option value="-1">未通过</option>
                      </select>
                </div>
                <div class="layui-form-mid layui-word-aux" style="padding:0;">
                    <button lay-filter="search" class="layui-btn" lay-submit style="height:38px;line-height:38px;"><i class="fa fa-search" aria-hidden="true"></i> 查询</button>
                </div>
            </div>
        </form>
        -->
    </blockquote>
    <div class="layui-card-body"><div id="content" style="width: 100%;height: 533px;"></div></div>
</div>
@endsection

@section('script')
    <script>
    layui.config({
        base: '/static/admin/js/',
        v: new Date().getTime()
    }).use(['xmerge','form','carousel'], function () {
        var $ = layui.jquery,
            xmerge = layui.xmerge(),
            carousel = layui.carousel,
            layerTips = parent.layer === undefined ? layui.layer : parent.layer,
            layer = layui.layer,
            form = layui.form;

        xmerge.page({
            url     :  app_url + 'wxPayRecord',
            columns : [
                {
                    fieldName   : '支付用户',
                    field       : 'nickname',
                },{
                    fieldName   : '支付结果',
                    field       : 'status',
                    format      : function (val ,obj) {
                        return obj == undefined?'':( obj.status > 0 ? '成功':'失败');
                    }
                },{
                    fieldName   : '支付金额',
                    field       : 'total_fee',
                },{
                    fieldName   : '支付项目',
                    field       : 'appTitle',
                },{
                    fieldName   : '支付详情',
                    field       : 'orderDetail',
                },{
                    fieldName   : '操作',
                    field       : 'id',
                    format      : function (val,obj) {
                        //console.log(obj.status)
                        return '<input type="button" value="删除" data-action="del" data-id="' + val + '" class="layui-btn layui-btn-disabled" /> '
                    }
                }],

            onSuccess: function ($elem) {
                $elem.children('tr').each(function () {
                    $(this).children('td:last-child').children('input').each(function () {

                        var $that = $(this);
                        var action = $that.data('action');
                        var id = $that.data('id');

                        $that.on('click', function () {
                            switch (action) {
                                case 'del': //删除
                                    xmerge.set({
                                        url: app_url + 'wxPayRecord',
                                        id:id,
                                        data:{
                                            force:false
                                        },
                                        success:function(resp){
                                            if(resp.code === 0) {
                                                layer.msg('操作成功', {
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
                                    var name = $that.parent('td').siblings('td[data-field=data]').text();
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
