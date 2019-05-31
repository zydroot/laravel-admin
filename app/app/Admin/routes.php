<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->get('/movies', 'MoviesController@index')->name('movies.index');
    $router->get('/movies/create', 'MoviesController@create')->name('movies.create');
    $router->post('/movies/create', 'MoviesController@create')->name('movies.create');
    $router->put('/movies/{movie}', 'MoviesController@edit')->name('movies.edit');


    $router->resource('categories', CategoriesController::class);

    $router->resource('products', ProductsController::class);
    //$router->get('/categories', 'CategoriesController@index')->name('categories.index');
    //$router->get('/categories/create', 'CategoriesController@create')->name('categories.create');
    //$router->post('/categories', 'CategoriesController@store')->name('categories.store');
});
