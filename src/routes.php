<?php

Route::bind('page', function($value) {
  return Pep\Element\Models\Manager\Page::where('name', $value)->first();
});

Route::group(['prefix' => Config::get('element::cms.prefix', 'cms'), 'namespace' => 'Pep\\Element\\Controllers'], function() {

  Route::group(['prefix' => 'pages', 'namespace' => 'Site'], function() {

    Route::group(['before' => 'element::cms'], function() {
      Route::get('/home', ['as' => 'element::pages.home', 'uses' => 'PagesController@home']);

      Route::group(['prefix' => 'manager', 'namespace' => 'Manager'], function() {

        Route::group(['prefix' => 'minimaps', 'namespace' => 'Minimap'], function() {
          Route::get('/load', ['as' => 'element::pages.manager.minimap.load', 'uses' => 'PagesController@load']);
          Route::get('/blocks/{page}', ['as' => 'element::pages.manager.minimap.blocks', 'uses' => 'PagesController@blocks']);
        });

      });
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

    Route::group(['before' => 'element::cms', 'prefix' => 'manager', 'namespace' => 'Manager'], function() {

      Route::group(['prefix' => 'minimap'], function() {
        Route::post('/load', ['as' => 'element::api.manager.minimap.load', 'uses' => 'MinimapsController@load']);
      });

    });

  });

});