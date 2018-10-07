<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/webhook', 'Bot\WebHookController@verify');

Route::get('/chatbot', 'Bot\BotManController@handle');

Route::post('webhook', 'Bot\WebHookController@postMessage');

Route::get('/fbpage', 'Admin\FacebookPageController@get');

Route::get('/fbaction', 'Admin\FacebookActionController@get');

Route::get('/keyword', 'Admin\KeywordController@get');
Route::get('/keyword/update', 'Admin\KeywordController@update');
Route::post('/keyword/update', 'Admin\KeywordController@update');
Route::get('/keyword/delete', 'Admin\KeywordController@delete');

Route::get('/action', 'Admin\ActionController@get');
Route::get('/action/update', 'Admin\ActionController@update');
Route::post('/action/update', 'Admin\ActionController@update');
Route::get('/action/delete', 'Admin\ActionController@delete');

Route::get('actionvalue', 'Admin\ActionValueController@get');
Route::get('actionvalue/update', 'Admin\ActionValueController@update');
Route::post('actionvalue/update', 'Admin\ActionValueController@update');
Route::get('actionvalue/delete', 'Admin\ActionValueController@delete');

Route::get('persistent', 'Admin\PersistentMenuController@get');
Route::post('persistent', 'Admin\PersistentMenuController@update');

Route::get('persistent/menu/update', 'Admin\PersistentMenuController@updateMenu');
Route::post('persistent/menu/update', 'Admin\PersistentMenuController@updateMenu');
Route::post('persistent/menu/delete', 'Admin\PersistentMenuController@deleteMenu');
Route::get('active_persistent', 'Admin\PersistentMenuController@active_persistent');
Route::get('persistent_child', 'Admin\PersistentMenuController@list_persistent_child');
Route::get('add_persistent', 'Admin\PersistentMenuController@add_persistent');
Route::post('add_persistent', 'Admin\PersistentMenuController@add_persistent');
Route::get('menuchild/publish', 'Admin\PersistentMenuController@publish');

// can action
Route::get('login', [ 'as' => 'login', 'uses' => 'UserController@login']);
Route::post('login', [ 'as' => 'login', 'uses' => 'UserController@login']);
Route::get('creatUser','UserController@creatUser');
Route::group(['middleware' => ['auth']], function () {
	Route::get('/', 'FanpageController@index');
	Route::get('/choose/{id_page}', 'FanpageController@choose');
	Route::get('PushMessage/list_user','PushMessageController@list_user');
	Route::get('Fanpage/list', 'FanpageController@list');
	Route::get('Fanpage/add_pages', 'FanpageController@add_pages');
	Route::post('Fanpage/add_pages', 'FanpageController@add_pages');
	Route::get('Fanpage/delete/{id}','FanpageController@delete');
	Route::get('Fanpage/edit/{id}','FanpageController@edit');
	Route::post('Fanpage/edit/{id}','FanpageController@edit');
	Route::get('Fanpage/hello/{id}','FanpageController@hello');
Route::get('FanpageCommentReply/setup','FanpageCommentReplyController@setup');
	Route::get('FanpageCommentReply/view_setup','FanpageCommentReplyController@view_setup');
	Route::post('FanpageCommentReply/view_setup','FanpageCommentReplyController@view_setup');
	Route::get('FanpageCommentReply/setting_post/{id_post}','FanpageCommentReplyController@setting_post');
	Route::post('FanpageCommentReply/setting_post/{id_post}','FanpageCommentReplyController@setting_post');
	Route::get('FanpageCommentReply/edit/{id_post}','FanpageCommentReplyController@edit');
	Route::post('FanpageCommentReply/edit/{id_post}','FanpageCommentReplyController@edit');
	Route::get('FanpageCommentReply/delete/{id_post}','FanpageCommentReplyController@delete');
	Route::get('FanpageCommentReply/setup_comment','FanpageCommentReplyController@setup_comment');
	Route::post('FanpageCommentReply/setup_comment','FanpageCommentReplyController@setup_comment');
	Route::get('PushMessage/list','PushMessageController@list');
	Route::get('PushMessage/add','PushMessageController@add');
	Route::post('PushMessage/add','PushMessageController@add');
	Route::get('PushMessage/publish/{id}','PushMessageController@publish');
	Route::get('PushMessage/unpublish/{id}','PushMessageController@unpublish');
	Route::get('PushMessage/send/{id}','PushMessageController@send');
	Route::get('PushMessage/edit/{id}','PushMessageController@edit');
	Route::get('PushMessage/delete/{id}','PushMessageController@delete');
	Route::post('PushMessage/edit/{id}','PushMessageController@edit');
	Route::get('WordStocks/edit/{id}','WordStocksController@edit');
	Route::post('WordStocks/edit/{id}','WordStocksController@edit');
	Route::get('WordStocks/delete/{id}','WordStocksController@delete');
	Route::get('PushMessage/list_user','PushMessageController@list_user');
	Route::get('Categories/list','CategoriesController@list');
	Route::get('Categories/add','CategoriesController@add');
	Route::post('Categories/add','CategoriesController@add');
	Route::get('WordStocks/add','WordStocksController@add');
	Route::post('WordStocks/add','WordStocksController@add');
	Route::get('WordStocks/list','WordStocksController@list');
	Route::get('Categories/edit/{id}','CategoriesController@edit');
	Route::get('Categories/delete/{id}','CategoriesController@delete');
	Route::post('Categories/edit/{id}','CategoriesController@edit');
	Route::get('FanpageCommentReply/word/getWordByCategory','WordStocksController@getWordByCategory');
	Route::get('GiftcodeFanpages/list','GiftcodeFanpagesController@list');
	Route::get('GiftcodeFanpages/add','GiftcodeFanpagesController@add');	
	Route::post('GiftcodeFanpages/add','GiftcodeFanpagesController@add');	
	Route::get('GiftcodeFanpages/edit/{id}','GiftcodeFanpagesController@edit');	
	Route::post('GiftcodeFanpages/edit/{id}','GiftcodeFanpagesController@edit');	
	Route::get('GiftcodeFanpages/delete/{id}','GiftcodeFanpagesController@delete');	
	Route::get('logout', [ 'as' => 'logout', 'uses' => 'UserController@logout']);
});