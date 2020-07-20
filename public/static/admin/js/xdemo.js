// 目的: xdelete，xcreate，xupdate，xview 融合在一起
// 1、声明框架
// 2、创建一个function函数并给名字
// 3、这个函数体config进行一个初始化，需要外部定义的都才用undefined
// 4、基于方法体分写GET，DELETE，PUT，POST，PAGAGE


// 1、参数统一化。
// URL: undefined
// id : undefined .  PUT,DELETE,GET 需要ID
// data : {}
// 

var demo = function function_name() {
	// body...
	this.config = {
		url: undefined,
		id: undefined,
		data: {},
		failed: undefined,
		success: undefined,
	}
} 			 

demo.properity.set = function(options){
	var that = this;
	_config = that.config;
	$.extend(true, _config, options);
	return that;
}

// 渲染
demo.properity.view = function()
{
	
}

demo.properity.get = function() {
	// id success
}

// 分页
demo.properity.page = function(options){
	
}

demo.properity.put = function(options){
	//
}

demo.properity.delete = function(options) {
	// 完善配置
	var that = this
	that.set(options)
	_config = that.config;

	// 结果请求
	that.request('delete');
}


demo.properity.request = function(method) {
	_config = this.config;
	$.ajax({
		url: _config.url + (_config.id > 0 ? '/'+ _config.id : '' ),
		type: method,
		data: _config.data,
		error: _config.failed,
		success:function(rest,status,xms){
			_config.success(rest)
		}
	})
}

// 外面调用
xdemo.delete({
	id:1,
	data: {
		force:true/
	}
})；