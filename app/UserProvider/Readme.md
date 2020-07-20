## 用户提供器 ##
1、 继承 Illuminate\Contracts\Auth\UserProvider

2、 查看器通过api去验证。

3、 后期如果多用户验证的情况下，可以根据看守器配合完成多个登陆模式验证

---
### 已经实现用户提供其 ###

1、WxAPIUserProvider

- 配合Model层查询本地的用户数据
- 免注册，请求微信接口返回用户数据自动注册