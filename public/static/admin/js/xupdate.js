/**
 * 封装一个表单提交。
 * 基于LayUI的框架，底层是ajax实现
 */
layui.define(['layer', 'form'], function(exports){
    var $ = layui.jquery,
        layerTips = parent.layer === undefined ? layui.layer : parent.layer,
        layer = layui.layer,
        form = layui.form;


    //默认配置
    var xUpdate = function(){
        this.config = {
            url:undefined,
            id:undefined,
            data:undefined,
            onSuccess:undefined
        };
    };

    xUpdate.prototype.set= function(options){
        var that = this;
        $.extend(true, that.config, options);
        return that;
    };

    xUpdate.prototype.put = function(){
        var that = this;
        var _config = that.config;
        $.ajax({
            url:_config.url+'/'+_config.id,
            type:'put',
            data:_config.data,
            dataType: 'json',
            success:function(result, status, xhr){
                _config.onSuccess(result)
            }
        })
    };

    var xupdate = new xUpdate();
    exports('xupdate', function(options){
        return xupdate.set(options);
    }); //注意，这里是模块输出的核心，模块名必须和use时的模块名一致
});