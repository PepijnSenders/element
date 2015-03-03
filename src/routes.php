<?php

Route::group([
  'prefix' => Config::get('element-cms::cms.uri'),
], function() {

  Route::group(['prefix' => Config::get('element-cms::cms.prefix'), 'namespace' => 'Pep\\Element\\Controllers'], function() {

    Route::get('/', function() {
      return Router::redirect('Cms', 'pages.home');
    });

    Route::group(['prefix' => 'pages', 'namespace' => 'Site'], function() {

      Route::group(['prefix' => 'users', 'namespace' => 'User'], function() {
        Route::get('/login', ['as' => 'element-cms.pages.users.login', 'uses' => 'PagesController@login']);
      });

      Route::group(['before' => 'admin'], function() {
        Route::get('/home', ['as' => 'element-cms.pages.home', 'uses' => 'PagesController@home']);
        Route::get('/minimap/{minimap}', ['as' => 'element-cms.pages.minimap', 'uses' => 'PagesController@minimap'])
          ->where('minimap', '(.*)');

        Route::group(['prefix' => 'users', 'namespace' => 'User'], function() {
          Route::get('/{username}', ['as' => 'element-cms.pages.users.show', 'uses' => 'PagesController@show']);
        });
      });

    });

    Route::group(['prefix' => 'api', 'namespace' => 'Api'], function() {

      Route::group(['before' => 'admin'], function() {

        Route::group(['prefix' => 'histories'], function() {
          Route::get('/key', ['as' => 'element-cms.api.histories.get.key', 'uses' => 'HistoriesController@getByKey']);
        });

        Route::group(['prefix' => 'fields'], function() {
          Route::get('/', ['as' => 'element-cms.api.fields.get', 'uses' => 'FieldsController@get']);
          Route::post('/', ['as' => 'element-cms.api.fields.save', 'uses' => 'FieldsController@save']);
          Route::get('/translation', ['as' => 'element-cms.api.fields.translation', 'uses' => 'FieldsController@translation']);
          Route::get('/editables', ['as' => 'element-cms.api.fields.editables', 'uses' => 'FieldsController@editables']);
        });

      });

      Route::group(['prefix' => 'users'], function() {
        Route::post('/login', ['as' => 'element-cms.api.users.login', 'uses' => 'UsersController@login']);
        Route::get('/logout', ['as' => 'element-cms.api.users.logout', 'uses' => 'UsersController@logout']);
      });

    });

  });

});