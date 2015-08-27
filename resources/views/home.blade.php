@extends('app')
@section('content')


<div class="row">
    @foreach($books as $key=>$book)

    <div class="col-sm-4 col-lg-4 col-md-4">
        <div class="thumbnail">
            {{--<img src="http://placehold.it/320x150" alt=""> --}}
            <a href="/books/{{$book->id}}"><img src="/{{$book->smallImage_path}}" alt=""></a>
            <div class="caption">
                <h4 class="pull-right">&euro;{{$book->price}}</h4>

                    <h4><a href="/books/{{$book->id}}">{{$book->book_title}}</a>
                    </h4>
                    <p>{{$book->smallDescription($book->id)}}...</p>

            </div>
            <div class="ratings">
                <p class="pull-right">{{$book->getCountRating()}}&nbsp;votes</p>
                <p>
                    @for ($i=1; $i <= 5 ; $i++)
                     <span class="glyphicon glyphicon-star{{ ($i <= $book->getBookRating()) ? '' : '-empty'}}"></span>
                     @endfor
                </p>
            </div>
        </div>
    </div>
    @if(($key+1)%3==0)
</div>
<div class="row">
    @endif
    @endforeach
</div>
{!! $books->appends(['sort' => 'created_at'])->render() !!}
@stop