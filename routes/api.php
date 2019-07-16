<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/posts', 'PostController')->except(['create', 'edit']);
Route::get('/my_posts', 'PostController@myPosts');
Route::get('/posts/avg_evaluation/{n}', 'PostController@avgEvaluation')->where('n','[0-9]+');

Route::get('/favorites', 'FavoritesController@index');
Route::delete('/favorites/delete/{n}', 'FavoritesController@delete')->where('n','[0-9]+');
Route::post('/favorites/add', 'FavoritesController@add');

Route::get('/users', 'UserController@get');

Route::post('/login', 'UserController@login');
Route::post('/register', 'UserController@register');
Route::post('/user', 'UserController@get');

Route::get('/posts/{n}/comments', 'CommentController@getPostComments');
Route::post('/posts/comments', 'CommentController@store');
Route::delete('/posts/comments/{n}', 'CommentController@destroy')->where('n','[0-9]+');
Route::get('/posts/comments/count_responses/{n}', 'CommentController@countResponses')->where('n','[0-9]+');
Route::get('/posts/comments/count_positive_reaction/{n}', 'CommentController@countPositiveReactions')->where('n','[0-9]+');
Route::get('/posts/comments/count_negative_reaction/{n}', 'CommentController@countNegativeReactions')->where('n','[0-9]+');

Route::post('/responses','ResponseController@store');
Route::get('/responses/{commentId}','ResponseController@getCommentResponses')->where('commentId', '[0-9]+');

Route::post('/reactions', 'ReactionController@store');