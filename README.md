这是一个基于layui，TP5.1的教学级个人博客系统，实现了一些功能。。

前台功能：

		登录、注册、导航、文章列表、文章详情、投稿功能（登录后）、搜索、评论（登录后）
后台功能：

		登录、注册、导航管理、文章管理、管理员管理、会员管理、评论管理、系统设置

设计数据库tp_blog:

	管理员表tp_admin
自增id、用户名username、密码password、昵称nickname、邮箱email、状态status、超级管理员is_super、添加时间create_time、更新时间update_time、软删除delete_time
	
	会员表tp_member
自增id、用户名username、密码password、昵称nickname、邮箱email、添加时间create_time、更新时间update_time、软删除delete_time

	导航表tp_cate
自增id、导航名称catename、排序sort、添加时间create_time、更新时间update_time、软删除delete_time

	文章表tp_article
自增id、文章标题title、作者author、概要desc、标签tags、内容content、推荐is_top、所属导航cate_id、浏览量click、评论量comm_num、添加时间create_time、修改时间update_time、软删除delete_time

	评论表tp_comment
自增id、评论内容content、评论文章article_id、评论用户member_id、评论时间create_time、修改时间update_time、软删除delete_time

	系统设置tp_system
自增id、网站名称webname、版权信息copyright、设置时间create_time、更新时间update_time、软删除delete_time

操作步骤：
Ajax访问控制器方法
控制器把数据移交给模型
模型里实例化一个验证器
验证器里规定一些验证规则
验证完后把验证信息交给模型
模型进行校验，校验结果返回给控制器
控制器再把结果返回给前端

