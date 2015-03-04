<?php

Route::group([
  'prefix' => Config::get('element::cms.uri'),
], function() {

  Route::group(['prefix' => Config::get('element::cms.prefix'), 'namespace' => 'Pep\\Element\\Controllers'], function() {

    Route::group(['prefix' => 'pages', 'namespace' => 'Site'], function() {

      Route::group(['before' => 'element::cms'], function() {
        Route::get('/home', ['as' => 'element::pages.home', 'uses' => 'PagesController@home']);
      });

      Route::group(['prefix' => 'users', 'namespace' => 'User'], function() {
        Route::get('/login', ['as' => 'element::pages.users.login', 'uses' => 'PagesController@login']);
      });

    });

    Route::group(['prefix' => 'api', 'namespace' => 'Api'], function() {

      Route::group(['prefix' => 'users'], function() {
        Route::post('/login', ['as' => 'element::api.users.login', 'uses' => 'UsersController@login']);
        Route::get('/logout', ['as' => 'element::api.users.logout', 'uses' => 'UsersController@logout']);
      });

    });

  });

});