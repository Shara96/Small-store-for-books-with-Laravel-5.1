<?php
// Authentication
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController']);

//Show Home
Route::get('/', 'HomeController@index');

//Show Search
Route::post('/search', 'SearchController@search');


//Categories
Route::get('categorie/{id}', 'HomeController@showCategorieBooks');

//Authors
Route::get('authors', 'AuthorsController@index');
Route::get('authors/create', 'AuthorsController@create');
Route::get('authors/{id}', 'AuthorsController@show');
Route::post('authors/create', 'AuthorsController@store');
Route::get('authors/books/{id}', 'AuthorsController@showAuthorsBooks');

//Books
Route::get('books', ['middleware' => 'admin', 'uses' => 'BooksController@index']);
Route::get('books/create', 'BooksController@create');
Route::post('books/create', 'BooksController@store');
Route::get('books/{id}', 'BooksController@show');
Route::get('books/{id}/edit', 'BooksController@edit');
Route::patch('books/{id}', 'BooksController@update');
Route::delete('books/{id}', 'BooksController@destroy');

//messages
Route::post('messages', 'messagesController@setMessages');

//######## PayPal ###########
//Route::resource('payment', 'PaypalPaymentController');
Route::post('payment', 'PaypalPaymentController@store');
Route::get('payment/ExecutePayment','PaypalPaymentController@ExecutePayment');

//PayPal Logs
Route::get('admin/logs',['middleware' => 'admin', 'uses' =>  'LogsController@index']);

//Carts
Route::post('carts', 'CartController@store');
Route::get('carts', 'CartController@index');
Route::delete('carts/{id}', 'CartController@destroy');

//Rating
Route::get('rating/{id}', 'RatingController@show');
Route::POST('rating', 'RatingController@store');


















