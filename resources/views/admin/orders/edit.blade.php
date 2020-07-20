@extends('admin.base')

@section('content')


<div class="layui-card">
    <div class="layui-card-header layuiadmin-card-header-auto increadOn" style="cursor: move;">
        <h2>添加景区</h2>
        <a href="javascrip:;" onclick="window.history.go(-1)">返回>></a>
    </div>

    @include('admin.project._form')

</div>


@endsection

@section('script')
    @include('admin.project._js')
<script type="text/javascript">
    layui.config({
            base: '/static/admin/js/',
    }).use([ 'form', 'table','xupdate','xview','xform'], function() {

        var form = layui.form;
        var table = layui.table;
        var xform = layui.xform();
        var $ = layui.jquery;

        var id = {{ $id }};
        var xupdate = layui.xupdate();
        var xview = layui.xview();

        // 获取数据
        xview.set({
            url: app_url + 'project',
            id:  id,

        });
        xview.get(function(result){
            if(result.code ===0){
                // 数据填充
                xform.set({
                    fields: {
                        'title':[
                            'ob'
                        ]
                    },

                    data: result.data
                })

                xform.render();

            }else{
                layer.msg(' 提交失败.');
            }
        });
        //监听提交
        form.on('submit(formDemo)', function(data) {
            xupdate.set({
                url: app_url + 'project',
                id:id,
                data:$("form").serialize(),
            });
            xupdate.put(function(result){
                if(result.code ===0){
                    console.log(result)
                    window.location.href= base_url + 'admin/project/list'
                }else{
                    layer.msg(' 提交失败.');
                }
            })
            return false; //注释掉这行代码后，表单将会以普通方式提交表单，否则以ajax方式提交表单
        });

    });
    layui.use('upload', function(){
        var $ = layui.jquery;
        var upload = layui.upload;

        //执行实例
        var uploadInst = upload.render({
            elem: '#test1',
            field: 'img',
            url: 'https://hongyuan.scxysd.com/upload',
            accept: 'img', // 允许上传的文件类型,
            size: 2048 ,// 最大允许上传的文件大小  单位 KB,
            before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#demo1').attr('src', result); //图片链接（base64）
                });
            }
            ,done: function(res){
                //如果上传失败
                if(res.code > 0){
                    return layer.msg('上传失败');
                }
                $("input[name='logo']").val(res.data)
            }
            ,error: function(){
                //演示失败状态，并实现重传
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function(){
                    uploadInst.upload();
                });
            }
        });
        //多张图片上传
        upload.render({
            elem: '#test2'
            ,url: 'https://hongyuan.scxysd.com/upload'
            ,field: 'img'
            ,multiple: true
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#demo2 ul').append('<li><img src="'+ result +'" alt="'+ file.name +'" class=" picTus"><i onclick="deleteEvent(this)"></i></li>')
                });
            }
            ,done: function(res){
                if (res.code > 0) {
                    alert("error")
                }else {
                    //alert(res.data)
                    $("#test2").after(
                        "<input id='"+res.data+"' type='hidden' name='thumbs[]' value="+res.data+">"
                    );
                }
            }
        });
        //图文介绍示例
        var uploadInst = upload.render({
            elem: '#test3',
            field: 'img',
            url: 'https://hongyuan.scxysd.com/upload',
            accept: 'img', // 允许上传的文件类型,
            size: 2048 ,// 最大允许上传的文件大小  单位 KB,
            before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#demo3').attr('src', result); //图片链接（base64）
                });
            }
            ,done: function(res){
                //如果上传失败
                if(res.code > 0){
                    return layer.msg('上传失败');
                }
                //上传成功
                $("input[name='detail']").val(res.data)
            }
            ,error: function(){
                //演示失败状态，并实现重传
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function(){
                    uploadInst.upload();
                });
            }
        });
    });





    //图片删除
    function deleteEvent(self){
        var _this = $(self)
        var ids = _this.siblings().attr('src');
        _this.parents('li').remove();
        console.log(ids)
        $('input[type="hidden"][value=\''+ids+'\']').remove();

    }

</script>
@endsection