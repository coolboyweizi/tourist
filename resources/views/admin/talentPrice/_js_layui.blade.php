<script type="text/javascript">
    layui.config({
        base: '/static/admin/js/',
    }).use([ 'form', 'layedit','xmerge','upload','laydate'], function() {

        var $ = layui.jquery,
            form    = layui.form,
            layedit = layui.layedit,
            upload = layui.upload,
            laydate = layui.laydate,
            xmerge  = layui.xmerge();

        var id = {{ $id??0 }},
            index = undefined;

        // 查询数据并渲染
        if ( id > 0 ) {
            xmerge.set({
                url: app_url + 'projectPrice',
                id: id,
                fields: [
                    {
                        'fieldName': 'title',
                    },
                    
                    {
                        'fieldName': 'price',
                    },
                    {
                        'fieldName': 'unit',
                    },
                    {
                        'fieldName': 'type',
                    },
                    {
                        'fieldName': 'tips',
                        'render': false,
                        'format': function (that, val) {
                            $('textarea[name=tips]').val(val)
                        }

                    },
                    {
                        'fieldName': 'stime',
                    },
                    {
                        'fieldName': 'etime',
                    },
                    {
                        'fieldName': 'status',
                        'render': false,
                        'format': function (that, val) {
                            //that.
                            $("input[name=status][value=1]").attr("checked", val == 1 ? true : false);
                            $("input[name=status][value=0]").attr("checked", val == 0 ? true : false);
                            form.render(); //更新全部
                        }
                    },
                    {
                        'fieldName': 'priority',
                        'render': false,
                        'format': function (that, val) {
                            $('select[name=priority]').val(val)
                        }
                    }
                ]
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
                url: app_url + 'projectPrice',
                data:data.field,
                success:function(resp){
                    if(resp.code === 0) {
                        layer.msg('修改成功', {
                            icon: 1,//提示的样式
                            time: 3000,
                            end:function(){
                                location.href=base_url + 'admin/projectPrice/view/'+data.field.app_id;
                            }
                        })
                    }else {

                    }
                }
            });
            id > 0  ? xmerge.put(): xmerge.post();

            return false; //注释掉这行代码后，表单将会以普通方式提交表单，否则以ajax方式提交表单
        });

       

        //执行一个laydate实例
          laydate.render({
            elem: '#test1' //指定元素
          });
          laydate.render({
            elem: '#test2' //指定元素
          });
    });


</script>
