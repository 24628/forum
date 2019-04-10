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

Route::get('/', function () {
    $threads = App\Thread::paginate(10);
    return view('welcome' ,compact('threads'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user/profile/{user}', 'UserProfileController@index')->name('user_profile')->middleware('auth');

Route::resource('/thread','ThreadController');
Route::resource('/map','MapController');

Route::post('/thread/mark-as-solution','ThreadController@markAsSolution')->name('markAsSolution');

Route::put('/comment/{comment}','CommentController@update')->name('comment.update');
Route::delete('/comment/{comment}','CommentController@destroy')->name('comment.destroy');

Route::post('/comment/create/{thread}','CommentController@addThreadComment')->name('threadcomment.store');
Route::post('/reply/create/{comment}','CommentController@addReplyComment')->name('replycomment.store');
Route::post('/comment/like','LikeController@toggleLike')->name('toggleLike');

Route::get('/markAsRead',function (){
    auth()->user()->unreadNotifications->markAsRead();
});
//https://www.youtube.com/watch?v=d0AUPSMofP0&list=PLzz9vf6075V3O1PEk_c0b-I6UPkleJFSc&index=5
//wanneer online voeg dit toe