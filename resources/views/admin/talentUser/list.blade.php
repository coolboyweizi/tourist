@extends('admin.base')

@section('content')

<div style="margin:0px; background-color: white; margin:0 10px;">
    <blockquote class="layui-elem-quote">
{{--        <div class="layui-btn-group ">
            @can('zixun.article.destroy')
                <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删 除</button>
            @endcan
            @can('zixun.article.create')
                <a class="layui-btn layui-btn-sm" href="{{ route('admin.talentUser.create') }}">添 加</a>
            @endcan
        </div>--}}
        <form class="layui-form" style="float:right;">
            <div class="layui-form-item" style="margin:0;">
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
            url:  app_url + 'talentUser',           //数据源地址
            columns: [
                {                          //配置数据列
                    fieldName: '用户名',               //显示名称
                    field: 'nickName',                  //字段名
                }, {                          //配置数据列
                    fieldName: '头像',               //显示名称
                    field: 'userAvatar',                  //字段名
                    format: function (val,obj) {
                        if(obj == undefined) {
                            return '';
                        }
                        return '<img  src="'+ obj.userAvatar +'" width="40" height="40" />'
                    }
                },{                          //配置数据列
                    fieldName: '组名',               //显示名称
                    field: 'groupName',                  //字段名
                }, {
                    fieldName: '达人分成(%)',
                    field: 'groupScale',
                },{
                    fieldName: '操作',
                    field: 'id',
                    format: function (val,obj) {
                        if(obj == undefined) {
                            return '';
                        }

                        return  '<input type="button" value="删除" data-action="del" data-id="' + val + '" class="layui-btn layui-btn-mini layui-btn-danger" />';

                    }
                }],

            onSuccess: function ($elem) {
                $elem.children('tr').each(function () {
                    $(this).children('td:last-child').children('input').each(function () {
                        var $that = $(this);
                        var action = $that.data('action');
                        var id = $that.data('id');
                        var recommend_id = $that.data('recommend');

                        $that.on('click', function () {
                            switch (action) {
                                case 'del': //删除
                                    xmerge.set({
                                        url: app_url + 'talentUser',
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
                                    var name = $that.parent('td').siblings('td[data-field=nickName]').text();
                                    //询问框
                                    layerTips.confirm('确定将[ <span style="color:red;">' + name + '</span> ]移除达人组 ？', { icon: 3, title: '系统提示' }, function (index) {
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
