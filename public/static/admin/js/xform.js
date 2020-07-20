/**
 * 表单结构填充框架
 * 1、field字段。 key => value  key代表字段 value title名
 *
 *      Field: {
 *          'nickname'
 *      }
 * 2、Json数据格式
 *
 * <div class="layui-form-item">
 <label for="" class="layui-form-label">昵称</label>
 <div class="layui-input-inline">
 <input type="text" name="name" value="{{ $member->name ?? old('name') }}" lay-verify="required" placeholder="请输入昵称" class="layui-input" >
 </div>
 </div>

 */

layui.define([],function (exports) {

    // 声明一个函数对象
    var XFrom = function () {
        this.config = {
            fields: [],
            data : undefined,
            area : '#container'
        };
    }

    // 设置方法
    XFrom.prototype.set = function (options) {
        var that = this;
        $.extend(true, that.config, options);
        return that;
    }
    
    // 设置方法
    XFrom.prototype.render = function () {

        var that = this;
        var _fields = that.config.fields;   // 相关字段
        var _data   = that.config.data ;  // json 数据
      
        for (var i = _fields.length - 1; i >= 0; i--) {
            var _fieldName = _fields[i].fieldName  // 获取字段名
            $.each(_data, function(key,val){
                if (key == _fieldName) {
                    // 获取对象。
                     var _that = $("input[name='"+key+"']");
                    // 数据处理 。 判断是否需要渲染
                    if( _fields[i].render !== false ) {
                        _that.val(val)
                    }
                    // 执行回调函数
                    if( _fields[i].format !== undefined ) {
                        _fields[i].format(_that, val)
                    }
                }
            })
        }
    }

    var xFrom = new XFrom();
    exports('xform', function(options){
        return xFrom.set(options);
    }); //注意，这里是模块输出的核心，模
})