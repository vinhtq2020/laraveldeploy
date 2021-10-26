<?php

use App\Http\Controllers\ApiBookController;
use App\Http\Controllers\ApiBookReceivedController;
use App\Http\Controllers\ApiPostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/register', 'ApiUserController@register');
Route::post('/login', 'ApiUserController@login');
Route::get('/user','ApiUserController@userInfo')->middleware('auth:api'); // mỗi lần muốn lấy info thì phải login trc
Route::get('/user-count','ApiUserController@getNumberUsers');
Route::get('/user/action/getAll','ApiUserController@getAllUsers');
Route::get('user/{id}','ApiUserController@getUserInfoById');
Route::get('user/action/getAllEmail','ApiUserController@getAllEmail');
Route::post('/user/action/changeRole','ApiUserController@changeRoleUser');
Route::post('user/action/updateInfo/{id}','ApiUserController@updateInfo');

Route::resource('/post','ApiPostController')->only(['index','show','update','edit','store','destroy'])->middleware('auth:api');
Route::get('/post/getposts/{number}','ApiPostController@getPostFollowQuantity')->middleware('auth:api');

Route::resource('/category','ApiCategoryController')->only(['index','show','update','edit','store','destroy']);
Route::get('/category/action/getBookNumberByCategoryIds','ApiCategoryController@getBookNumberByCategoryIds');

// do bị vướng cái get category/id nên thêm cái action vào để tránh hiểu nhầm
Route::get('/category/action/getcategories','ApiCategoryController@getAllCategorys');

Route::resource('/book','ApiBookController');
Route::get('book/action/getNewBooks/{number}','ApiBookController@getNewBooks')->where(['number' => '[0-9]+']);
Route::get('book/action/getBookByCategoryId/{id}/{number}','ApiBookController@getBookByCategoryId')
->where(['number' => '[0-9]+','id'=> '[0-9]+']);
Route::get('/book/action/getBookBestSale/{number}','ApiBookController@getBookBestSale');
Route::get('/book/action/getBooksByAllCategories/{number}','ApiBookController@getBooksByAllCategories');
Route::get('/book/action/getBookToSearch','ApiBookController@getBookToSearch');
Route::get('/book/action/getAll','ApiBookController@getAll');
Route::get('/book/action/getBookBySeo/{bookSeo}','ApiBookController@getBookBySeo');
Route::get('/book/action/getBookBoughtByIdUser/{user_id}','ApiBookController@getBookBoughtByIdUser');

Route::resource('/book-received','ApiBookReceivedController');
Route::resource('/author','ApiAuthorController')->only(['index','show','update','edit','store','destroy']);

Route::get('/author/action/getauthors','ApiAuthorController@getAllAuthors');
ROute::get('/author/action/getAuthorsByNumber/{number}','ApiAuthorController@getAuthorsByNumber');
Route::resource('/image','ApiImageController')->except(['update']);
// nếu mà update ảnh thì ko dùng PUT,PATCH hãy tự custom POST
Route::post('/image/{id}','ApiImageController@update');

Route::resource('/bill','ApiBillController');
Route::get('/bill/action/count','ApiBillController@getNumberBills');
Route::get('/bill/action/getBillInDate','ApiBillController@getBillInDate');
Route::get('/bill/action/getBillInMonth','ApiBillController@getBillInMonth');
Route::get('/bill/action/getBillByIdUser/{idUser}','ApiBillController@getBillByIdUser');

Route::get('/billdetail/action/getBillDetailByIdBill/{id}','ApiBillDetailController@getBillDetailByIdBill');

Route::get('/revenue-month/action/getRevenue','ApiRevenueMonthController@getRevenue');
Route::get('/revenue-month/action/getRevenueEveryMonthInYear/{year}','ApiRevenueMonthController@getRevenueEveryMonthInYear');
Route::resource('/nxb','ApiNxbController');
Route::get('/nxb/action/getNxbs','ApiNxbController@getNxbs');

Route::resource('/review','ApiReviewController');
Route::get('/review/action/getReviewBookPaginateById/{id}','ApiReviewController@getReviewBookPaginateById');

Route::resource('/bookrate','ApiBookRateController');

Route::resource('/bookview','ApiBookViewController');
Route::get('/bookview/action/getTopBookViewInMonth/{number}/{month}/{year}','ApiBookViewController@getTopBookViewInMonth');
Route::get('/bookview/action/getBookViewById/{book_id}','ApiBookViewController@getBookViewById');

Route::resource('/bookuserview','ApiBookUserViewController');
Route::post('/bookuserview/action/updateBookUserView','ApiBookUserViewController@updateBookUserView');
Route::get('/bookuserview/action/getBookUserViewByUserId/{user_id}','ApiBookUserViewController@getBookUserViewByUserId');
// Route::get('/bill/action/get-new-bills/{number}','ApiBillController@getBillByNumber');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
