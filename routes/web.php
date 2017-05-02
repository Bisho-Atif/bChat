<?php


Route::get('/', 'HomeController@index');
Route::get('test', function(){
  return Auth::user()->name;
});

Route::get('/private/{user}', 'ChatController@private');
Auth::routes();

