@extends('app')
@section('content')
@include ('errors.list')

<div class="row">

    <div class="col-sm-6">
        <div class="content">
        <div class="bookId" style="display: none;">{{$book->id}}</div>
            <!-- Product information for small screens -->
            <div class="main-imgs clearfix">
                <a href="{{$book->largeImage_path}}" title="BeachFront Frog swimsuit: view 1"><img id="img1" src="/{{$book->largeImage_path}}" alt="BeachFront Frog swimsuit" class="main-img img-responsive"></a>
            </div>
            <div class="new row"></div>
                <div class="col-sm-2" id="RatingAddIcon">
                  <div class="input-group-addon" id="click-prevent"></div>
                  <div class="input-group-addon" id="addIcon">
                  <img class="slide-image"  id="ok" src="/lib/images/Ok.png"   style="display: none">
                  <img class="slide-image"  id="cancel"  src="/lib/images/Cancel.png" style="display: none">
                  </div><div class="votes">{{$book->getCountRating()}}&nbsp;votes</div></div>


            {!!Form::open(['id'=>'ratingForm'])!!}
            {!!Form::close()!!}
        </div>
    </div> <!-- // end span6 -->

    <div class="col-sm-6">
        <div class="content">

            <!-- Product information for large screens -->
            <div class="product-details-large">
                <!-- Product name and manufacturer -->
                <div class="title"><h1>{{$book->book_title}}</h1></div>
                <!-- Pricing and offer info -->
                <div class="pricing clearfix">
                    <p class="authors">
                        <span class="authorsClass">Authors:</span>
                        @unless($book->authors->isEmpty())
                        @foreach($book->authors as $key=>$author)
                        <span class="authorName"> <a href="/authors/books/{{  $author->id  }}">{{  $author->author_name  }}</a> </span>
                        @if(($key+1)<count($book->authors))
                        <span class="razdelitel">{{","}}</span>
                        @endif
                        @endforeach
                        </p>
                        @endunless

                        <div class="bookUrl"><a href="http://{{$book->url}}"> <p class="special">View!</p> </a></div>
                        @if(Auth::check() && Auth::isAdmin())
                             <div class="edit"> <a href="/books/{{$book->id}}/edit">Edit</a> </div>
                         @endif


                           {!! Form::open(['url'=>'/carts', 'method' => 'POST']) !!}
                                <div class="form-group ">
                               {!! Form::label('text', 'Quantity')    !!}
                               {!! Form::text('Quantity',1,['class'=>'form-control']) !!}
                                </div>
                                {!! Form::hidden('bookId', $book->id, array('id' => 'invisible_id')) !!}
                                <div class="form-group">
                                    {!! Form::submit('Sale',['class'=>'btn btn-primary form-control'])  !!}
                                </div>
                           {!! Form::close() !!}
                </div>
            </div>

            <!-- Product description etc -->
            <ul class="nav nav-tabs" id="product-tabs">
                <li class="active"><a href="#description">Description</a></li>
                <li class=""><a href="#care">INFO 2</a></li>
                <li class=""><a href="#sizing">INFO 3</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="description">
                    <p>{{$book->description}}</p>
                </div>
                <div class="tab-pane" id="care">
                <p>TODO</p>
                </div>
                <div class="tab-pane" id="sizing">
                <p>TODO</p>
                </div>
            </div>

            <!-- Share -->

        </div>
    </div> <!-- // end span6 -->

</div> <!-- //end row -->

<div class="row">
    <div class="col-sm-9">
        <h3>User Comment Example</h3>
    </div><!-- /col-sm-12 -->
</div><!-- /row -->
@foreach($message as $messages)
<div class="row">
    <div class="col-sm-1">
        <div class="thumbnail">
            <img src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="img-responsive user-photo">
        </div><!-- /thumbnail -->
    </div><!-- /col-sm-1 -->

    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>{{$messages->user->username}}</strong> <span class="text-muted">commented {{$messages->dateFormat()}}</span>
                <span id="ratingFloat">
                                    @if($book->getBookRating() && $messages->user->id!=1)
                                    @for ($i=1; $i <= 5 ; $i++)
                                     <span class="glyphicon glyphicon-star{{ ($i <= $book->getBookRating()) ? '' : '-empty'}}"></span>
                                     @endfor
                                     @endif
                                </span>
            </div>
            <div class="panel-body">
                {{$messages->message}}
            </div><!-- /panel-body -->
        </div><!-- /panel panel-default -->
    </div><!-- /col-sm-5 -->
</div><!-- /row -->
@endforeach


<div class="row" >
    <div class="col-md-1"></div>
    <div class="col-md-8">
        <div class="status-upload">
            {!! Form::open(['method' => 'POST','url'=>['messages']]) !!}
            {!! Form::textarea('message',null,['class'=>'form-control form-control ','placeholder'=>"What are you doing right now?",]) !!}
            {!! Form::label('')    !!}
            {!! Form::hidden('book_id', "$book->id") !!}
            {!! Form::hidden('user_id', "$user_id", array('id' => 'invisible_id')) !!}
            {!! Form::submit('Share',['class'=>'btn btn-success green '])  !!}
            {!! Form::close() !!}
        </div><!-- Status Upload  -->
    </div> <!-- //end span12 -->
</div> <!-- //end row -->
<script type="text/javascript" src="{{ URL::asset('lib/JavaScriptRaty.js') }}"></script>

@stop
