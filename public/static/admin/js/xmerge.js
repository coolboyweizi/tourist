/**
 * 封装一个表单提交。
 * 基于LayUI的框架，底层是ajax实现
 */
layui.define(['form','pageList'], function(exports) {
    var $ = layui.jquery, // 创建一个类jQuery对象
        layer = layui.layer,
        form = layui.form; // 提交需要依赖表单
        pageList = layui.pageList();
    
    //初始化参数
    var xMerge = function(){
    	this.config = {
    		url: undefined,
			id: 0,
			data: {},
			error: undefined,
			success: undefined,
			fields: undefined,
			area : '#container'
    	}
    }

    //设置属性
    xMerge.prototype.set= function(options){
    	var that = this;
        $.extend(true, that.config, options);
        return that;
    }

    //单个查询
    xMerge.prototype.get = function() {
		// id success
		var that = this;
        var _config = that.config;
        var _fields = that.config.fields;

        if (_fields === undefined) {
        	throwError("没有配置字段");
        }

        $.extend(	
         	true, 
         	that.config, 
         	{
         		success: function(resp) {
         			if(resp.code !== 0) {
         				throwError(resp.data)
         			}
         			var _data = resp.data;
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
         	}
         );

        request('get', that.config);

	}

	//修改
	xMerge.prototype.put = function(_call = undefined){
		var that = this;
        var _config = that.config;

        if (_call == undefined) {
            $.extend(
                true,
                that.config,
                checkParams(_config, '修改')
            );
		} else {
           $.extend(
           		true,
			   	that.config,{
           			success: _call
			   	}
		   );
		}
        request('put', that.config);
	}

	//删除
	xMerge.prototype.delete = function(){
		var that = this;
        var _config = that.config;
        $.extend(	
         	true, 
         	that.config, 
         	checkParams(_config, '删除')
         );
        request('delete', that.config);
	}

	//添加
	xMerge.prototype.post = function(){
		var that = this;
        var _config = that.config;
        $.extend(	
         	true, 
         	that.config, 
         	checkParams(_config, '添加')
         );
        request('post',that.config);
	}

	// 分页
	xMerge.prototype.page = function(options){
		pageList.set(options);
		pageList.render();
	}

	// 搜索
	xMerge.prototype.search = function (field) {
		pageList.search(field)
    };

	// 检查配置文件
	var checkParams = function(msg, config){
        if (config.success == undefined) {
        	// 我们自己一个
        	 $.extend(true, config, {
        	 	success: function(resp){
        	 		if(resp.code === 0) {
                        layer.msg(msg+'成功', {
                            icon: 1,//提示的样式
                            time: 3000
                        })
                    }else {
                    	throwError(msg+"失败")
                    }
        	 	} 
        	});
        }
        return config;
	}

	//ajax请求
	var request = function(method, _config) {
		$.ajax({
			url: _config.url + (_config.id > 0 ? '/'+ _config.id : '' ),
			type: method,
			data: _config.data,
			dataType: 'json',
			error: function(){
				alert('请求失败');
			},
			success:function(result, status, xhr){
				if (_config.success !== undefined) {
                    _config.success(result)
				}

			}
		})
	}

	function throwError(msg) {
        throw new Error(msg);
    };

    var xmerge = new xMerge();
    exports('xmerge', function(options) {
        return xmerge.set(options)
	});
});