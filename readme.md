## 项目简述

>客户端推荐使用微信小程序开发工具，仓库: yujian-wechat

>重写了用户提供器和看守器用于实现微信用户验证。

>红原项目是基于laravel&layui后台框架实现，Model层中没有model.php结尾的都是原有框架Model层

>控制器业务渲染在admin中，接口在api中

>图片上传使用OSS模块


## 未完功能.

- 1、直通车需要做接口测试

- 2、重做系统消息通知，目前已经移除功能

- 3、banner广告图需要利用指定具体项目商品

- 4、部分Bug请参照Tower文档


## 队列

>采用的redis做队列处理，也支持database队列调用。队列主要功能如下

**AppActive**  
- 作用: 用于检查商品是否活动价
- 调用分发: App\Listeners\SysOrder.php

**Flux**  
- 作用:  流量统计，
- 调用分发: App\Http\Middleware\DailyPv.php

**Profit**
- 作用: 收益计算，
- 调用分发: App\Listeners\SysOrder.php

**SearchRecord**
- 作用: 搜索记录
- 调用分发: 

**TalentPrice**
- 作用: 计算达人价格
- 调用分发: service/talentList.php

**TravelOrder**
- 作用: 异步检查直通车订单状态
- 调用分发: WxApi 微信回调支付结果

**TravelOrderVerify**
- 作用: 利用队列延迟检查直通车订单状态
- 调用分发: TravelOrder


## 监听器

- AppOrder: 实现项目订单与系统订单数据同步
- MerchantMoneyLog: 商家资金日志，用于联动更改商家账户
- MoneyLogListener: 用户资金日志，用于联动更改用户账户
- SysOrder: 系统订单状态监听，收益和支付检查在这里实现


## BootService

***[App\Services\BootService]()*** 是自定义简单的类，实现基础增删查改，并配合__call完成额外的逻辑处理。

对象配置在 **service** 文件夹中，由 **BootServiceProvider** 启动

- model: 关联的model模型
- closure: 通过BootService的__call方法调用回调函数
- query: 控制器检索的查询条件
- verify: 中间件检查方法下字段是否存在等关系
- errorCode: 每个Service对象应有唯一一个异常code

获取实例方法:  app('filename.abstract')


## 路由与控制器 

>接口地址共享一个Api控制器。RequestBody通过Verify和Query进行组合获取

***[admim.php]()***  后台路由管理

***[wxApi.php]()***  微信小程序接口访问地址

***[WebApi.php]()*** PC端接口访问地址
