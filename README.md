基于laravel开的单点登录服务端，基本可用，更多功能正在开发中，有问题可在issue中提出，一起加油！
使用方式结合下方的文档和 https://gitee.com/hesunfly/passport_client，该项目包含一个最基本的demo。
使用前需要先添加客户端应用，生成app_name和secret。

应用管理 ： '/apps';
用户： '/users';

#### 获取access_token
access_token 是访问passport服务端时必须传递的参数，有效时间2小时，重新获取后，旧的token将不可用。

路由: `/getAccessToken`

参数:

参数 | 含义 | 备注
---|---|---
app_name | 应用名称 | 由后台服务管理自动生成
secret | 应用密钥 | 由后台服务管理自动生成

#### 用户注册

路由: `/register`

参数:

参数 | 含义 | 备注
---|---|---
access_token | 请求 token | 获取方式参考获取 access_token 章节
callback_url | 注册成功后的回调地址 | 系统将重定向到传入的回调地址，并携带注册用户的 uuid 值

#### 获取用户信息

路由: `/getUser`

参数:

参数 | 含义 | 备注
---|---|---
access_token | 请求 token | 获取方式参考获取 access_token 章节
uuid | 用户的uuid | 

响应：
参数 | 含义 | 备注
---|---|---
name | 用户名 | 
email | 邮箱 | 
status | 状态 | 
created_at | 注册时间 | 

#### 用户登录

路由: `/login`

参数:

参数 | 含义 | 备注
---|---|---
access_token | 请求 token | 获取方式参考获取 access_token 章节
callback_url | 登录成功后的回调地址 | 系统将跳转到传入的回调地址，并携带ticket值，应用需要使用ticket检验用户的登录状态，参考校验登录章节


#### 校验登录状态 ticket

路由: `/loginCheck`

参数:

参数 | 含义 | 备注
---|---|---
access_token | 请求 token | 获取方式参考获取 access_token 章节
ticket | 登录后的ticket | ticket仅可使用一次，并且需要在登录后5分钟内有效

响应：

参数 | 含义 | 备注
---|---|---
success | 是否成功 | 0=失败 1= 成功
msg | 错误信息 | 
uuid |成功时返回用户的uuid | 获取到uuid后，应用完成自己的登录逻辑，用户即登录成功 


#### 用户退出

路由: `/logout`

参数:

参数 | 含义 | 备注
---|---|---
access_token | 请求 token | 获取方式参考获取 access_token 章节
callback_url | 回调地址 | 

为了实现统一退出功能，服务端在登录成功后，会向redis中存入当前用户的登台态，key的值为 login_status_{uuid}（由于laravel框架在使用redis时，会在key前添加前缀，使用时请查看自己生成的key值）， uuid为登录用户的uuid，当该key存在时，说明用户在登录状态。否则为已注销，应用应该执行自己的注销逻辑，完成用户推出操作。
