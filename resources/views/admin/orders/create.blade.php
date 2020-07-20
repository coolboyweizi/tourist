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
    }).use([ 'form', 'xcreate','upload'], function() {

        var form = layui.form,
            $ = layui.jquery,
            upload = layui.upload,
            layer = layui.layer,
            xcreate = layui.xcreate();

        form.on('submit(formDemo)', function(data) {
            xcreate.set({
                url: app_url + 'project',
                data:data.field,
                onsuccess:function (resp) {
                    console.log(resp);
                    window.location.href="list.blade.php";
                }
            });
            xcreate.post();
            return false;
        });

        // Logo Upload
        upload.render({
            elem  : '#logo',
            url   : base_url + 'upload',
            accept: 'img',
            size  : 4096,
            field: 'img',
            done: function (resp) {
                if (resp.code > 0 ) {
                    layer.alert(resp.data, {
                        title: '上传图片失败'
                    })
                } else {
                    $("#logoImg").attr('src',resp.data);
                    $("input[name='logo']").val(resp.data);
                }
            }
        })

        // 图册上传
        upload.render({
            elem  : '#thumbs',
            url   : base_url + 'upload',
            field : 'img',
            done  : function (resp) {
                if (resp.code > 0 ) {
                    layer.alert(resp.data, {
                        title: '上传图片失败'
                    })
                } else {
                    $('#thumbsImg ul').append('<li><img src="'+ resp.data +'" alt="'+ resp.data +'" class=" picTus"><i onclick="deleteEvent(this)"></i></li>')
                    $('#thumbsImg').after(
                        "<input id='"+resp.data+"' type='hidden' name='thumbs[]' value="+resp.data+">"
                    );
                }
            }
        })
        // 上传详情
        upload.render({
            elem  : '#details',
            url   : base_url + 'upload',
            field : 'img',
            done  : function (resp) {
                if (resp.code > 0 ) {
                    layer.alert(resp.data, {
                        title: '上传图片失败'
                    })
                    return false ;
                }
                $('#detailsImg').attr('src', resp.data); //图片链接（base64）
                $("input[name='detail']").val(resp.data)
            }
        })

    });

</script>
@endsection