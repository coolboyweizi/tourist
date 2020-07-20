form.verify({
	        chinese: function(value, item){ //value：表单的值、item：表单的DOM对象
			    if(!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(value)){
			      return '不能有特殊字符';
			    }
			    if(^[1-9]\d*|0$.test(value)){
			      return '不能输入负数';
			    }
			},
	        num:[
	        	^[0-9]*[1-9][0-9]*$, '请输入正整数'
	        ],
	        shuzi:[
	        	^([1-9][0-9]*)+(.[0-9]{1,2})?$, '请输入非零开头的最多带两位小数的数字'
	        ]

	   });
	



