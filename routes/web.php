<?php


Route::get('/', 'HomeController@index');
Route::get('test', function(){
  return Auth::user()->name;
});

Route::post('/private/{user}', 'ChatController@private');
Auth::routes();

