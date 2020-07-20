// 分页查询公共模块
layui.define(['btable','layer', 'xdelete', 'form'], function(exports){

    var $ = layui.jquery,
        btable = layui.btable();

    var PageList = function () {
        this.config = {
            url: undefined,
            elem: '#content',
            pageSize: 10,
            params:{},
            openWait: true,
            even: true,//隔行变色
            field: 'id', //主键ID
            //skin: 'row',
            checkbox: false,//是否显示多选框
            columns:undefined,
            paged: true, //是否显示分页
            singleSelect: false, //只允许选择一行，checkbox为true生效
        };
    }

    PageList.prototype.set = function (options) {
        var that = this;
        $.extend(true, that.config, options);
        return that;
    };


    PageList.prototype.render = function () {
        var that = this;
        var _config = that.config;
        btable.set(
            _config
        )
        btable.render();
    }


    PageList.prototype.search = function (options) {
        btable.get(options, base_url+'search');
    }

    var pageList = new PageList();

    exports('pageList', function (options) {
        return pageList.set(options);
    });
})