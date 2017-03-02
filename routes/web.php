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

Route::get('/', 'HomeController@index');

Route::group(['prefix' => 'admin'], function () {

    Auth::routes();

    Route::group(['middleware' => ['auth'], 'namecpace' => 'Admin'], function () {
        Route::get('/', 'Admin\DashboardController@index');

        try {
            foreach (\App\PostType::all() as $postType) {
                Route::resource($postType->slug, 'Admin\PostsController');
            }
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException("Custom routes hasn't been configured because: ".$e->getMessage(), 1);
        } catch (\Exception $e) {
            // do nothing, might just be because table not yet migrated.
        }

        Route::post('media/upload', 'Admin\MediaController@upload');
        Route::resource('categories', 'Admin\CategoriesController');

    });

});



Route::get('/insertdata', function() {
    $post = new \App\Post;
    $post->{'title:cn'} = '测试123';
    $post->{'title:en'} = 'test123';
    $post->{'content:cn'} = '测试测试测试';
    $post->{'content:en'} = 'testtesttest';
    $post->slug = 'test123';
    $post->category_id = 1;
    $post->post_type_id = 1;
    $post->author_id = 1;
    $post->save();

});

Route::get('testlocale', function () {
    //echo App::getLocale();
    $post = \App\Post::first();
    echo $post->title;
});
