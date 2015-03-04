<?php

Route::group([
  'prefix' => Config::get('element::cms.uri'),
], function() {

  Route::group(['prefix' => Config::get('element::cms.prefix'), 'namespace' => 'Pep\\Element\\Controllers'], function() {

    Route::group(['prefix' => 'pages', 'namespace' => 'Site'], function() {

      Route::group(['prefix' => 'users', 'namespace' => 'User'], function() {
        Route::get('/login', ['as' => 'element.pages.users.login', 'uses' => 'PagesController@login']);
      });

    });

  });

});