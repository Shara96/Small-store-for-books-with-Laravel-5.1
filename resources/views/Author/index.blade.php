@extends('app')
@section('content')
<h1>Authors</h1>
<hr>

<div class="list-group">
    @foreach($authors as $author)
    <li class="list-group-item">
        <a href="{{url('authors',$author->id)}}">{{$author->author_name}}</a>
    </li>
    @endforeach
</div>

@stop