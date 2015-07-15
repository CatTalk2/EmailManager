# EmailManager
企业邮件管理系统，包括管理员，邮件审核人员，邮件分发人员和邮件处理人员及其对应业务逻辑

详细介绍参见个人博客：[明桑战胜Android汪的黑历史](http://www.jycoder.com)

或者CSDN博客: [明桑Android](http://blog.csdn.net/qwm8777411)
        
你可以直接访问[EmailManager](http://123.56.46.9/basic/web/index.php?r=site/login)

注意不要使用360浏览器等IE内核浏览器打开，**请使用火狐或者Chrome浏览器**体验功能。

----------

####**如何在本地运行这个项目**


**如果你想研究源代码：**

1.将项目从github，clone到本地，也可以直接下载[emailmanager.zip](http://pan.baidu.com/s/1pJrBCXt)

2.将项目解压到wamp或其他php环境的`www`文件夹下(**如果这儿你不太明白，，，你就不用往后看了，先去研究下怎么部署php本地环境**)

3.建立数据库并导入emailmanager.sql，导入后你可以查看表结构，我对所有的表以及字段都做了注释，相信你会很容易看懂的。

>建立数据库


![](http://i.imgur.com/7U6NKU3.png)

>emailmanager.sql在解压后的`emailmanager/basic/sql/emailmanager.s

![](http://i.imgur.com/CmON6T3.png)

4.YII框架使用MVC模式，即Model-View-Controller，因此项目核心代码基本在models，views，controller三个文件夹下，根据需要自行研究，不过不得不承认6天时间赶出来的代码在可读性方面存在很多问题。

5.现在你可以直接在浏览器中打开这个项目了，如果没有php本地运行环境，连mysql没用过，上面的当我没说。

**注意url地址**

![](http://i.imgur.com/zZBc5Uw.png)




>如果你直接导入`emailmanager.sql`文件,user表中已经存在分配好的用户和密码

![](http://i.imgur.com/ClGCpIy.png)

**基本用户权限和功能：**

![](http://i.imgur.com/sKc474f.png)

>**首次登陆请使用admin账号登录进入后，先设置你自己的邮箱账号；**

![](http://i.imgur.com/3JcpBoL.png)

>**设置好自己的邮箱账号后，以distributer账号登录(你也可以在超级管理员界面设定其他的分发人员账号)，分发人员登录后可点击刷新按钮，下载你所设置的邮箱中的邮件。**

![](http://i.imgur.com/GehzSjd.png)

>邮件从服务器下载下来之后，你可以分发，处理，回复。。。等等，你也可以使用使用dealer，auditor等角色登录，这些功能很复杂，我就不一一讲解了，大家自行体验！

>下面是几个简单的示例截图


>![](http://i.imgur.com/zDPVMCx.gif)


----------

- 微信公众号：	[ITBird](http://www.jycoder.com)


	![](http://i.imgur.com/8CEGPgR.png)
