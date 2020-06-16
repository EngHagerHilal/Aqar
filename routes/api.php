<?php

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::get('/index','postsController@indexPostsApi');
Route::get('/search','postsController@searchPostsAPI');
Route::get('postDetails','postsController@postDetailsAPI');

Route::post('register','api\RegisterController@register');
Route::post('login','api\LoginController@login');
Route::get('email/resend', 'api\RegisterController@resend');
Route::post('/password/reset','api\LoginController@sendEmail');
Route::post('/resendActivationLink','api\RegisterController@resendEmailActivation');

//my posts
Route::post('myActiveRent','postsController@myRentActiveAPI');
Route::post('myDisActiveRent','postsController@myRentDisActiveAPI');
Route::post('myActiveSell','postsController@mySellActiveAPI');
Route::post('myDisActiveSell','postsController@mySellDisActiveAPI');
//edit my posts\


Route::post('insertPost','postsController@insertPostAPI');
Route::post('editPost','postsController@editPostAPI');
Route::post('updatePost','postsController@updatePostAPI');
Route::post('deletePost','postsController@deletePostAPI');


Route::post('/editProfile','profileController@EditMyProfileAPI');
Route::post('/updateProfile','profileController@UpdateMyProfileAPI');


