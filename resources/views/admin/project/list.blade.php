@extends('admin.base')

@section('content')

    <div style="margin:0px; background-color: white; margin:0 10px;">
        <blockquote class="layui-elem-quote">
            <div class="layui-btn-group ">
                @can('zixun.article.destroy')
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删 除</button>
                @endcan
                @can('zixun.article.create')
                    <a class="layui-btn layui-btn-sm" href="{{ route('admin.project.create') }}">添 加</a>
                @endcan
            </div>
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
    <!--弹窗-->
    <div class="bg"></div>
    <div class="recomTan">
        <div class="recomOver">
            <label>推荐理由</label>
            <input type="text" name="reason" placeholder="官方推荐" />
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
        }).use(['xmerge','form','table'], function ()
        {

            var xmerge = layui.xmerge(),
                $ = layui.jquery,
                layerTips = parent.layer === undefined ? layui.layer : parent.layer, //获取父窗口的layer对象
                layer = layui.layer,
                table = layui.table,
                form = layui.form;

            xmerge.page({
                url:  app_url + 'project',           //数据源地址
                columns: [{                          //配置数据列
                    fieldName: '标题',               //显示名称
                    field: 'title',                  //字段名
                    sortable: true ,//是否显示排序
                    format: function (id, obj) {
                        //id
                        //行数据对象
                        //返回值：格式化的纯文本或html文本
                        if (obj == undefined) {
                            return '';
                        }
                        var html = '<span style="width:80px;overflow:hidden;display: inline-block">'+obj.title+'</span>';
                        return html;
                    }
                }, {
                    fieldName: '图片',
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
                    fieldName: '项目地址',
                    field: 'address',
                },{
                    fieldName: '开放时间',
                    field: 'opentime',
                },{
                    fieldName: '预订数量',
                    field: 'ordered',
                },/*{
                    fieldName: '状态',
                    field: 'status',
                    format: function (id, obj) {
                        //id
                        //行数据对象
                        //返回值：格式化的纯文本或html文本
                        if (obj == undefined) {
                            return '';
                        }
                        var html = (obj.status > 0 ? '可用' : '不可用');
                        return html;
                    }
                },*/{
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
                        html +=   '<input type="button" value="'+recmd+'" data-recommend="'+obj.recommend+'" data-action="recommend" data-id="' + val + '" class="layui-btn layui-btn-mini layui-btn-primary" /> ' +
                            '<input type="button" value="编辑" data-action="edit" data-id="' + val + '" class="layui-btn layui-btn-mini" /> ' +
                            '<input type="button" value="价格" data-action="price" data-id="' + val + '" class="layui-btn layui-btn-normal" /> ' +
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
                            var recommend_id = $that.data('recommend');
                            var status = $that.data('status')

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
                                                        'app':'project',
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
                                        window.location.href= base_url + 'admin/project/'+id+'/edit';
                                        break;

                                    case 'price':
                                        window.location.href= base_url + 'admin/projectPrice/view/'+id;
                                        break;
                                    case 'status':
                                        xmerge.set({
                                            url: app_url + 'project',
                                            id: id,
                                            data: {
                                                status: status > 0? 0: 1
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

                                    case 'del': //删除
                                        xmerge.set({
                                            url: app_url + 'project',
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
