/**
 * 封装一个表单提交。
 * 基于LayUI的框架，底层是ajax实现
 */
layui.define(['form'],function (exports) {
    var $ = layui.jquery,       // 创建一个类jQuery对象
        layer = layui.layer,
        form = layui.form;    // 提交需要依赖表单

    /**
     * 构造器，初始化参数
     * @constructor
     */
    var XCreate = function () {
        this.config = {
            url: undefined,             // 提交URL地址
            data: undefined,            // 提交的数据
            onSuccess: undefined,       // 提交回调函数
        };
    }

    /**
     * 设置额外的属性。
     * @param options
     * @returns {TCreate}
     */
    XCreate.prototype.set = function (options) {
        var that = this;
        $.extend(true, that.config, options);
        return that;
    }

    /**
     * POST 方法，向服务器端请求数据
     * @param options
     */
    XCreate.prototype.post = function () {

        var that = this;                // 对象
        var _config = that.config;      // 对象配置文件

        // 进行参数检测
        if (_config.url == undefined) {
            throwError('Paging Error:请配置远程URL!');
        }

        $.ajax({
            url  :  _config.url,
            type  : 'post',
            dataType: 'json',
            data: _config.data,
            success: function (result, status, xhr) {
                if (result.code === 0) {
                    _config.onSuccess(result);
                }else {
                    layer.alert(result.data, {
                        title: '最终的提交信息'
                    })
                }
            }
        })
    }

    function throwError(msg) {
        throw new Error(msg);
    };

    var xcreate = new XCreate();

    exports('xcreate', function(options){
        return xcreate.set(options)
    });

})