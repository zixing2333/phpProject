<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

//前台路由
Route::rule('cate/:id', 'index/index/index');
Route::rule('/', 'index/index/index');
Route::rule('article-<id>', 'index/article/info');
Route::rule('register', 'index/index/register');
Route::rule('login', 'index/index/login');
Route::rule('loginout', 'index/index/loginout');
Route::rule('search', 'index/index/search', 'get');
Route::rule('comm', 'index/article/comm', 'post');
Route::rule('contriAdd', 'index/contribution/contriadd');

//后台路由
//设置路由
Route::group('admin', function () {
    Route::rule('/', 'admin/index/login');
    Route::rule('register', 'admin/index/register');
    Route::rule('forget', 'admin/index/forget');
    Route::rule('reset', 'admin/index/reset', 'post');
    Route::rule('index', 'admin/home/index');
    Route::rule('loginout', 'admin/home/loginout', 'post');
    Route::rule('cateList', 'admin/cate/list');
    Route::rule('cateAdd', 'admin/cate/add');
    Route::rule('sort', 'admin/cate/sort', 'post');
    Route::rule('cateEdit/[:id]', 'admin/cate/edit');
    Route::rule('cateDel', 'admin/cate/del', 'post');
    Route::rule('articleList', 'admin/article/list');
    Route::rule('articleAdd', 'admin/article/add');
    Route::rule('articleTop', 'admin/article/top', 'post');
    Route::rule('articleEdit/[:id]', 'admin/article/edit');
    Route::rule('articleDel', 'admin/article/del', 'post');
    Route::rule('memberList', 'admin/member/list');
    Route::rule('memberAdd', 'admin/member/add');
    Route::rule('memberEdit/[:id]', 'admin/member/edit');
    Route::rule('memberDel', 'admin/member/del');
    Route::rule('adminList', 'admin/admin/list');
    Route::rule('adminAdd', 'admin/admin/add');
    Route::rule('adminStatus', 'admin/admin/status');
    Route::rule('adminEdit/[:id]', 'admin/admin/edit');
    Route::rule('adminDel', 'admin/admin/del');
    Route::rule('commentList', 'admin/comment/list');
    Route::rule('commentDel', 'admin/comment/del');
    Route::rule('set', 'admin/system/set');

});
return [

];
