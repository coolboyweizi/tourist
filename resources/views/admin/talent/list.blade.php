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
                <input type="hidden" name="app" value="talent" />
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
<!--弹窗-->
<div class="bg"></div>
<div class="recomTan">
    <div class="recomOver">
        <label>推荐理由</label>
        <input type="text" name="reason" placeholder="给一个推荐理由呗" />
        <input type="hidden" name="id"  id = 'ID'/>
    </div>
    <div class="recomOver">
        <label>预留等级</label>
        <select name="priority" id="prody">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
        </select>
    </div>
    <div class="queLink">
        <button class="queren">确认</button>
        <button class="quxiao">取消</button>
    </div>
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
            url:  app_url + 'talent',           //数据源地址
            columns: [
                {                          //配置数据列
                    fieldName: '定制用户',               //显示名称
                    field: 'nickName',                  //字段名
                },{
                    fieldName: '用户头像',
                    field: 'userAvatar',
                    format: function (id, obj) {
                        return obj == undefined ? '': "<img style='width: 50px; height: 50px;' src='"+obj.userAvatar+"' />";
                    }
                }, {                          //配置数据列
                    fieldName: '标题',               //显示名称
                    field: 'title',                  //字段名
                    sortable: true ,//是否显示排序
                    format: function (id, obj) {
                        return obj == undefined ? '': '<span style="width:200px;overflow:hidden;display: inline-block">'+obj.title+'</span>';
                    }
                }, {
                    fieldName: 'Logo',
                    field: 'logo',
                    format: function (id, obj) {
                        //id
                        //行数据对象
                        //返回值：格式化的纯文本或html文本
                        if (obj == undefined) {
                            return '';
                        }
                        var html = "<img style='width: 50px; height: 50px;' src='"+obj.logo+"' />";
                        return html;
                    }
                },{
                    fieldName: '始发地',
                    field: 'departure',
                },{
                    fieldName: '目的地',
                    field: 'destination',
                },{
                    fieldName: '评论数量',
                    field: 'comment',
                },{
                    fieldName: '预订数量',
                    field: 'ordered',
                },{
                    fieldName: '操作',
                    field: 'id',
                    format: function (val,obj) {
                        if(obj == undefined) {
                            return '';
                        }

                        if ( obj.status > 0 ) {
                            html = '<input type="button" value="下架" data-status="'+obj.status+'" data-action="status" data-id="' + val + '" class="layui-btn layui-btn-danger" /> ' ;
                        }else {
                            html = '<input type="button" value="上架" data-status="'+obj.status+'" data-action="status" data-id="' + val + '" class="layui-btn layui-btn-normal" /> ' ;
                        }
                        var recmd = (obj.recommend > 0) ? '取推':'推荐' ;
                        html += '<input type="button" value="'+recmd+'" data-recommend="'+obj.recommend+'" data-action="recommend" data-id="' + val + '" class="layui-btn layui-btn-mini layui-btn-primary" /> ' +
                            '<input type="button" value="编辑" data-action="edit" data-id="' + val + '" class="layui-btn layui-btn-mini" /> ' +
                            '<input type="button" value="价格" data-action="price" data-id="' + val + '" class="layui-btn layui-btn-normal" /> ' ;
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
                        var recommend_id = $that.data('recommend');

                        $that.on('click', function () {
                            switch (action) {
                               // 推荐操作
                                case 'recommend' :
                                    xmerge.set({
                                        url: app_url + 'recommend',
                                        id : recommend_id,
                                    });
                                    if(recommend_id >0) {
                                        //删除
                                        xmerge.set({
                                            success: function(resp) {
                                                if(resp.code == 0) {
                                                    // 取消推荐成功
                                                    $that.attr('data-recommend',0);
                                                    recommend_id = 0;
                                                    $that.val('推荐')
                                                }
                                            }
                                        });
                                        xmerge.delete();
                                    }else {
                                        $('.bg').show();
                                        $('.recomTan').show();

                                        $('.queren').click(function(){
                                             // 推荐
                                             xmerge.set({
                                                 data: {
                                                     'app':'talent',
                                                     'app_id': id,
                                                     'data':$('input[name="reason"]').val(),
                                                     'priority':$('select[name="priority"]').val(),
                                                 },
                                                success: function(resp) {
                                                    if(resp.code == 0) {
                                                        // 取消推荐成功
                                                        $that.attr('data-recommend',resp.data);
                                                        recommend_id = resp.data;
                                                        $that.val('取推');
                                                        window.location.reload();

                                                    }
                                                }
                                            });
                                            xmerge.post();
                                        })

                                        $('.quxiao').click(function(){
                                            $('.bg').hide();
                                            $('.recomTan').hide();

                                        });
                                    }
                                    break;

                                case 'edit':
                                    window.location.href= base_url + 'admin/talent/'+id+'/edit';
                                    break;

                                case 'price':
                                    window.location.href= base_url + 'admin/talentPrice/view/'+id;
                                    break;

                                case 'status':
                                    xmerge.set({
                                        url: app_url + 'talent',
                                        id: id,
                                        data: {
                                            status: status > 0 ? 0: 1
                                        },
                                        success: function (resp) {
                                            if(resp.code === 0) {
                                                layer.msg('操作成功', {
                                                    icon: 1,//提示的样式
                                                    time: 3000,
                                                    end:function(){
                                                        window.location.reload()
                                                    }
                                                })
                                            }else {
                                                layerTips.msg('操作失败');
                                            }
                                        }
                                    });
                                    xmerge.put()
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
