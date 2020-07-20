<script type="text/javascript">
    layui.config({
        base: '/static/admin/js/',
    }).use([ 'form', 'layedit','xmerge','upload'], function() {

        var $ = layui.jquery,
            form    = layui.form,
            layedit = layui.layedit,
            upload = layui.upload,
            verify =layui.verify,
            xmerge  = layui.xmerge();

        var id = {{ $id ??0 }},
            index = undefined;

        // 查询数据并渲染
        if ( id > 0 ) {
            xmerge.set({
                url: app_url + 'project',
                id: id,
                fields: [
                    {
                        'fieldName': 'title',
                    },
                    {
                        'fieldName': 'thumbs',
                        'render': false,
                        'format': function (that, val) {
                            $.each(JSON.parse(val), function (key, img) {
                                // 显示图片
                                $('#thumbsImg ul').append('<li><img src="' + img + '" alt="' + img + '" class=" picTus"><i onclick="deleteEvent(this)"></i></li>')
                                // 赋值input
                                $('#thumbsImg').after(
                                    "<input id='" + img + "' type='hidden' name='thumbs[]' value=" + img + ">"
                                );
                            })
                        }
                    },
                    {
                        'fieldName': 'logo',
                        'render': false,
                        'format': function (that, val) {
                            $("#logoImg").attr('src', val);
                            $("input[name='logo']").val(val);
                        }
                    },
                    {
                        'fieldName': 'illustrate',
                        'render': false,
                        'format': function (that, val) {
                            $('textarea[name=illustrate]').val(val)
                        }
                    },
                    {
                        'fieldName': 'address',
                    },
                    {
                        'fieldName': 'opentime',
                        'render': false,
                        'format': function (that, val) {
                            $('textarea[name=opentime]').val(val)
                        }
                    },
                    {
                        'fieldName': 'notice',
                        'render': false,
                        'format': function (that, val) {
                            $('textarea[name=notice]').val(val)
                        }

                    },
                    {
                        'fieldName': 'status',
                        'render': false,
                        'format': function (that, val) {
                            $('select[name=status]').val(val)
                        }
                    },
                    {
                        'fieldName': 'ordered',
                    },
                    {
                        'fieldName': 'tagsA',
                    },
                    {
                        'fieldName': 'tagsB',
                    },
                    {
                        'fieldName': 'tagsC',
                    },
                    {
                        'fieldName': 'detail',
                        'render': false,
                        'format': function (that, value) {
                            $("#detail").val(value);
                            index = layedit.build('detail', {
                                uploadImage: {
                                    url: base_url + 'upload',
                                    field: 'img'
                                }
                            });
                        }
                    }]
            })
            xmerge.get();
        }else {
            index = layedit.build('detail', {
                uploadImage: {
                    url: base_url + 'upload',
                    field: 'img'
                }
            });
        }

        //监听提交
        form.on('submit(formDemo)', function(data) {

            $.extend(true, data.field, {
                'detail' : layedit.getContent(index)
            });
            // 更新操作
            xmerge.set({
                url: app_url + 'project',
                data:data.field,
                success:function(resp){
                    if(resp.code === 0) {
                        layer.msg('修改成功', {
                            icon: 1,//提示的样式
                            time: 3000,
                            end:function(){
                                location.href=base_url + 'admin/project/view';
                            }
                        })
                    }else {

                    }
                }
            });
            id > 0  ? xmerge.put(): xmerge.post();

            return false; //注释掉这行代码后，表单将会以普通方式提交表单，否则以ajax方式提交表单
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
