/**
 项目JS主入口
 以依赖layui的layer和form模块为例
 **/
layui.define(['layer', 'form'], function(exports){
    var $ = layui.jquery
    layer = layui.layer,
        form = layui.form;

    //默认配置
    var xView = function(){
        this.config = {
            url:undefined,
            id:undefined,
            data:{},
            success:undefined
        };
    };

    xView.prototype.set = function (options) {
        var that = this;
        $.extend(true, that.config, options);
        return that;
    };

    xView.prototype.get = function(callBack){
        var that = this;
        var _config = that.config;
        $.ajax({
            url:_config.url+'/'+_config.id,
            type:'get',
            data:_config.data,
            dataType: 'json',
            success:function(result, status, xhr){
                callBack(result)
            }
        })
    };

    var xview = new xView();

    exports('xview', function(options){
        return xview.set(options)
    }); //注意，这里是模块输出的核心，模块名必须和use时的模块名一致
});
