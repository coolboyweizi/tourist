@extends('admin.base')

@section('content')

    <div style="margin:0px; background-color: white; margin:0 10px;">
        <blockquote class="layui-elem-quote">
            <div class="layui-btn-group ">
                @can('zixun.article.destroy')
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">
                        删 除
                    </button>
                @endcan
            </div>
        </blockquote>
        <div class="layui-card-body">
            <div id="content" style="width: 100%;height: 533px;">

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.config({
            base: '/static/admin/js/',
            v: new Date().getTime()
        }).use( ['xmerge','form','carousel'], function () {
            var $ = layui.jquery,
                xmerge = layui.xmerge(),
                carousel = layui.carousel,
                layerTips = parent.layer === undefined ? layui.layer : parent.layer,
                layer = layui.layer,
                form = layui.form;

            xmerge.page({
                url     :  app_url + 'comment',
                columns : [
                    {
                        type:'checkbox'
                    },
                    {
                        fieldName   : '产品类型',
                        field       : 'app',
                        sortable    : true ,//是否显示排序
                        format      : function (app, obj) {
                            return  obj == undefined ?'' : '<span style="width:200px;overflow:hidden;display: inline-block">'+obj.appAlias+'</span>';
                        }
                    },{
                        fieldName   : '产品标题',
                        field       : 'appTitle',
                        sortable    : true ,//是否显示排序
                        format      : function (title, obj) {
                            return  obj == undefined ?'' : '<span style="width:200px;overflow:hidden;display: inline-block">'+obj.appTitle+'</span>';
                        }
                    }, {
                        fieldName   : '用户',
                        field       : 'userNickname',
                        format      : function (val, obj) {
                            return '<span style="width:200px;overflow:hidden;display: inline-block">'+obj.userNickname+'</span>';
                        }
                    },{
                        fieldName   : '用户头像',
                        field       : 'userAvatar',
                        format      : function (id,obj) {
                            return '<img src="'+obj.userAvatar+'" style="width:50px;height: 50px" />'
                        }
                    },{
                        fieldName   : '内容',
                        field       : 'data',
                    },{
                        fieldName   : '图册',
                        field       : 'thumbs',
                        format      : function (id, obj) {
                            var html = '<div class="layui-carousel" id="ins'+id+'" style="margin-top: 15px;"><div carousel-item="">';
                            var thumbs = JSON.parse(obj.thumbs);
                            for (var i = 0; i < thumbs.length; i++) {
                                if ( null !== thumbs[i]) {
                                    html += '<div>'+thumbs[i]+'</div>';
                                }else {
                                    html += '<div>https://static.scxysd.com/revimg1.jpg</div>';
                                }
                            }
                            html += '</div></div>';

                            carousel.render({
                                elem: '#ins'+id
                                ,interval: 1800
                                ,anim: 'fade'
                                ,height: '120px'
                            });

                            return html;
                        }
                    },{
                        fieldName   : '操作',
                        field       : 'id',
                        format: function (val,obj) {
                            //console.log(obj.status)
                            if(obj.status > 0){
                                return  '<input type="button" value=" 审核" data-action="approved" data-id="' + val + '" class="layui-btn layui-btn-warmlayui-btn-disabled" /> ' +
                                    '<input type="button" value="删除" data-action="del" data-id="' + val + '" class="layui-btn layui-btn-mini layui-btn-danger" />';
                            }else if(obj.status < 0){
                                return  '<input type="button" value=" 未通过" data-action="notPass" data-id="' + val + '" class="layui-btn layui-btn-warm layui-btn-disabled" /> ' +
                                    '<input type="button" value="删除" data-action="del" data-id="' + val + '" class="layui-btn layui-btn-mini layui-btn-danger" />';
                            }else{
                                return  '<input type="button" value="审核" data-action="approved1" data-id="' + val + '" class="layui-btn layui-btn-mini" /> ' +
                                    '<input type="button" value="拒绝" data-action="notPass2" data-id="' + val + '" class="layui-btn layui-btn-warm layui-btn-mini" /> ';
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
                                    case 'edit':
                                        window.location.href= base_url + 'admin/comment/'+id+'/edit';
                                        break;
                                    case 'approved1':
                                        xmerge.set({
                                            url:app_url + 'comment',
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
                                            url:app_url + 'comment',
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
                                            url: app_url + 'comment',
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
