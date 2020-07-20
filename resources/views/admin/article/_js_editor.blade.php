<script>
    layui.config({
        base: '/static/admin/js/',
    }).use([ 'layedit', 'upload'], function() {
        var layedit = layui.layedit,
            uploads = layui.upload;

        //  编辑器
        var index = layedit.build('content',{
            uploadImage: {
                url: base_url + 'upload',
                field: 'img'
            }
        });

        uploads.render({
            elem  : '#uploadPic',
            url   : base_url + 'upload',
            accept: 'img',
            size  : 4096,
            field: 'img',
            before: function(obj){
                obj.preview(function(index, file, result){
                    $('#layui-upload-box').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                });
            },
            done: function (resp) {
                if(resp.code == 0){
                    $("#thumb").val(resp.data);
                    $('#layui-upload-box li p').text('上传结果');
                    return layer.msg('上传成功');
                }
                return layer.msg(resp.msg);
            }
        });
    })
</script>