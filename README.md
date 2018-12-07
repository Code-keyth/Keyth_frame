Keyth_frame
=======================
> * APP
>> * Controllers        控制器采用模块化设计，下面包含模块<br>
>>> * Http              公共模块，包含生成验证码等一些固有化接口 <br>
>>> * Index             前台模块,包含前台控制器。
>> * Views              视图类文件，模块/文件  <br>
>> + Controllers.php    公共控制器，供模块控制器继承使用
>> + function.php       公共函数库，供用户自定义函数使用
> * Config              核心配置文件
> * Keyth               框架核心
>> + Db.php             数据库模型文件
>> + Image.php          验证码模型文件
>> + Loader.php         自动类加载文件
>> + Request.php        请求模型文件
>> + Route.php          路由模型文件
>> + View.php           Twig模板引擎模型文件
>> + run.php            框架启动文件
> + Public             静态文件目录
> + runtime            缓存文件目录
> + vendor             Composer扩展应用目录



