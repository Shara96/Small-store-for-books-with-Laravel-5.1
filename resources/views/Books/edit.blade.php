@extends('app')
@section('content')
@include ('errors.list')
<h1>Edit:{{ $book->book_title  }}</h1>
 {!! Form::model($book,['method' => 'PATCH','url'=>['books',$book->id ]]) !!}

      @include('Books.form',[$BookAuthorsList=$book->AuthorsList(),$boosCategorieList=$book->CategorieList(),'submitButtonText'=>'Edit'])

    {!! Form::close() !!}


@stop