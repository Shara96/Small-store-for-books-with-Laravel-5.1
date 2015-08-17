@extends('app')
@section('content')
<div class="title"><h1>Books</h1></div>
<div class="col-md-9">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Book</th>
                <th>Authors</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td>{{$book->id}}</td>
                <td><a href="/books/{{$book->id}}">{{$book->book_title}}</a></td>
                <td>@foreach($book->Authors as $books)
                    <a href="#">{{$books->author_name }}</a>
                    @endforeach</td>
                <td><a href="/books/{{$book->id}}/edit">Edit</a></td>
                <td>{!! Form::open(['method' => 'DELETE','url' => ['books', $book->id]]) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-xs btn-danger']) !!}
                    {!! Form::close() !!}</td>

            </tr>
        </tbody>
        @endforeach
    </table>
</div>

@stop