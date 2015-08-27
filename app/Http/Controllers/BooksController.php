<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Categorie;
use App\Http\Requests\CreateBookRequest;
use App\Message;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Laracasts\Flash\Flash;

class BooksController extends Controller {

    public function __construct() {
        $this->middleware('auth', ['only' => 'create']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $books = Book::orderBy('book_title', 'desc')->get();
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $authors = Author::lists('author_name', 'id');

        return view('books.create', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateBookRequest|Request $request
     * @return Response
     */
    public function store(CreateBookRequest $request) {

        $request = $this->imagesInsert($request);
        $Book = Auth::user()->Books()->create($request->all());
        $Book->authors()->attach($this->scroller($request, $model = '\App\Author', $requestInput = 'authors', $tableRow = 'author_name'));
        $Book->categorie()->attach($this->scroller($request, $model = '\App\Categorie', $requestInput = 'categories', $tableRow = 'category'));
        Flash::success('The book is added');
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $book = Book::findorFail($id);
        $message = Message::where('book_id', '=', $id)->take(10)->get();

        if (!Auth::check()) {
            $user_id = 1;
        } else {
            $user_id = Auth::user()->id;
        }

        if (is_null($book)) {
            abort(404);
        }

        return view('books.show', compact('book', 'user_id', 'message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $authors = Author::lists('author_name', 'id');
        $book = Book::findOrFail($id);
        return view('books.edit', compact('book', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateBookRequest|Request $request
     * @param CreateIdRequest|int $id
     * @return Response
     */
    public function update(CreateBookRequest $request, CreateIdRequest $id) {

        $request = $this->imagesInsert($request);

        $book = Book::findOrFail($id);

        $book->update($request->all());
        $this->Sync($book, $request->input('authors'), $request->input('categories'));

        return redirect('books');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $Book = Book::findOrFail($id);
        $Book->delete();
        return redirect('books');
    }


    /**
     * Synchronisation aller neuen Autoren und Kategorien
     *
     * @param Book $book
     * @param array $Authors
     * @param array $Category
     */
    private function Sync(Book $book, array $Authors, array $Category) {
        $book->authors()->sync($Authors);
        $book->categorie()->sync($Category);
    }

    /**
     * save all nonexistent Authors and categories
     *
     * @param $request
     * @param $model
     * @param $requestInput
     * @param $tableRow
     * @return mixed
     */
    public function Scroller($request, $model, $requestInput, $tableRow) {
        if ($model::first() == NULL) {
            $AuthorLastIdRow = 0;
        } else {
            $AuthorLastIdRow = $model::orderBy('id', 'desc')->first()->id;
        }

        $authorRequest = $request->input($requestInput);
        $const = null;
        $br = null;


        foreach ($authorRequest as $key => $inputAuthor) {
            if (!is_numeric($inputAuthor)) {
                $const++;
                $model::create([$tableRow => $inputAuthor]);
                unset($authorRequest[$key]);
                $br[] = $AuthorLastIdRow + $const;
            }
        }

        if (!$br == Null) {
            foreach ($br as $brs) {
                array_push($authorRequest, $brs);
            }
        }
        var_dump($authorRequest);
        return $authorRequest;
    }

    /**
     * store and sized photo
     *
     * @param $request
     * @return mixed
     */
    public function imagesInsert($request) {
        $smallImage = Input::file('image');
        $largeImage = Input::file('image');
        $smallImagePath = '';
        $largeImagePath = '';

        if (Input::file('image')) {
            $smallImagePath = 'images/smallImages/' . Auth::id() . '_' . date("Y-m-d_-_H_i_s") . '____' . $smallImage->getClientOriginalName();
            $largeImagePath = 'images/largeImages/' . Auth::id() . '_' . date("Y-m-d_-_H_i_s") . '____' . $largeImage->getClientOriginalName();
            Image::make($smallImage)->resize(330, 220)->save($smallImagePath);
            Image::make($largeImage)->resize(400, 370)->save($largeImagePath);
        }
        $request['smallImage_path'] = $smallImagePath;
        $request['largeImage_path'] = $largeImagePath;
        return $request;
    }

}
