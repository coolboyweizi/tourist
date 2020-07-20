layui.define(['layer', 'form'], function(exports){

    var siteUrl = 'http://demo.localhost/webApi/';

    var  $ = layui.jquery,
        layer = layui.layer,
        layerTips = parent.layer === undefined ? layui.layer : parent.layer, //获取父窗口的layer对象
        form = layui.form;

    //layer.msg('Hello World');

    var Xdelete = function(){
        this.config={
            url:undefined,
            id:undefined,
            force:false,
        }
    }

    Xdelete.prototype.set = function(options){
        var that = this;
        $.extend(true, that.config, options);
        return that;
    }

    Xdelete.prototype.delete = function(title,callBack){

        var that = this;
        var _config = that.config;

        $.ajax({
            url:  _config.url + '/' + _config.id,
            type:'delete',
            data:{
                force:_config.force
            },
            success:function(result, status, xhr){
                callBack(result)
            }

        });
            //$that.parent('td').parent('tr').remove()

    };

    var xdelete = new Xdelete();
    exports('xdelete', function(options){
        return xdelete.set(options);
    }); //注意，这里是模块输出的核心，模块名必须和use时的模块名一致
});
