<div class="form-group">
    {!! Form::label('text', 'Book Name')    !!}
    {!! Form::text('book_title',null,['class'=>'form-control']) !!}
</div>

<div class="well form-group">
    {!! Form::label('Book Image') !!}
    {!! Form::file('image', null) !!}
</div>
<div class="form-group">
    {!! Form::label('Body','Description') !!}
    {!! Form::textarea('description',null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('labelAmount','Amount:') !!}
    <div class="input-group">
      <div class="input-group-addon">&euro;</div>
      {!! Form::text('price',null,['class'=>'form-control','placeholder'=>"Amount  exemple 9.99 &euro;"]) !!}
      <div class="input-group-addon">.00</div>
    </div>
  </div>
<div class="form-group">
    {!! Form::label('text', 'url')    !!}
    {!! Form::text('url',null,['class'=>'form-control','placeholder'=>'http://www.google.com']) !!}
</div>
<div class="form-group">
    {!! Form::label('categories', 'Categories:') !!}
    {!! Form::select('categories[]', $categories, $boosCategorieList , ['class'=>'form-control','id'=>'authors_list','multiple']) !!}
</div>

<div class="form-group">
    {!! Form::label('authors', 'Authors:') !!}
    {!! Form::select('authors[]', $authors, $BookAuthorsList, ['class'=>'form-control','id'=>'authors_list2','multiple']) !!}
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText,['class'=>'btn btn-primary form-control'])  !!}
</div>


