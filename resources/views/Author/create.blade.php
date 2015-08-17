@extends('app')
@section('content')
<h1>Create a new Author</h1>
@include ('errors.list')

{!! Form::open(['url'=>'/authors/create']) !!}

{!! Form::label('text', 'Author Name');   !!}
{!! Form::text('author_name',null,['class'=>'form-control']);!!}

{!! Form::submit('Add new Author',['class'=>'btn btn-primary form-control']); !!}

{!! Form::close() !!}


@stop