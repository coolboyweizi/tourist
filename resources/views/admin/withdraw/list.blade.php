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
                    <input type="hidden" name="app" value="withdraw" />
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
            url     :  app_url + 'withdraw',
            columns : [
                {
                    fieldName   : '提现用户',
                    field       : 'userNickname',
                },{
                    fieldName   : '用户头像',
                    field       : 'userAvatar',
                    format      : function (val ,obj) {
                        return obj == undefined?'':
                            '<img src="'+obj.userAvatar+'" style="width: 50px; height:50px" />';
                    }
                },{
                    fieldName   : '账户余额',
                    field       : 'userMoney',
                },{
                    fieldName   : '提现金额',
                    field       : 'money',
                },{
                    fieldName   : '操作',
                    field       : 'id',
                    format      : function (val,obj) {
                        //console.log(obj.status)
                        if(obj.status > 0){
                            return  '<input type="button" value="已通过" data-action="approved" data-id="' + val + '" class="layui-btn layui-btn-disabled" /> ' +
                                '<input type="button" value="删除" data-action="del" data-id="' + val + '" class="layui-btn layui-btn-mini layui-btn-danger" />';
                        }else if(obj.status < 0){
                            return  '<input type="button" value=" 未通过" data-action="notPass" data-id="' + val + '" class="layui-btn layui-btn-disabled" /> ' +
                                '<input type="button" value="删除" data-action="del" data-id="' + val + '" class="layui-btn layui-btn-mini layui-btn-danger" />';
                        }else{
                            return  '<input type="button" value="已通过" data-action="approved1" data-id="' + val + '" class="layui-btn layui-btn-normal" /> ' +
                                '<input type="button" value="未通过" data-action="notPass2" data-id="' + val + '" class="layui-btn layui-btn-warm" /> ' ;
                                // '<input type="button" value="删除" data-action="del" data-id="' + val + '" class="layui-btn layui-btn-mini layui-btn-danger" />';
                        }
                        
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
                                case 'approved1':
                                      xmerge.set({
                                        url:app_url + 'withdraw',
                                        id:id,
                                        data:{
                                            status:1
                                        },
                                        success:function(resp){
                                            if(resp.code == 0){
                                                $that.removeClass('layui-btn-mini');
                                                $that.addClass('layui-btn-disabled');
                                                window.location.reload();
                                            }
                                        }
                                      });
                                      xmerge.put();
                                      break;
                                case 'notPass2':
                                      xmerge.set({
                                        url:app_url + 'withdraw',
                                        id:id,
                                        data:{
                                            status:-1
                                        },
                                        success:function(resp){
                                            if(resp.code == 0){
                                                $that.removeClass('layui-btn-mini');
                                                $that.addClass('layui-btn-disabled');
                                                window.location.reload();
                                            }
                                        }
                                      });
                                      xmerge.put();
                                      break;
                                case 'del': //删除
                                    xmerge.set({
                                        url: app_url + 'withdraw',
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
