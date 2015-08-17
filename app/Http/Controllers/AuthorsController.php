<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use Illuminate\Http\Request;
use App\Http\Requests\CreateAuthorsRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;

class AuthorsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

        $authors = Author::orderBy('author_name', 'asc')->get();
        return view('author.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('author.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateAuthorsRequest $request
     * @return Response
     */
    public function store(CreateAuthorsRequest $request) {
        $input = $request->all();
        Author::create($input);
        Flash::success('Author is create ');
        return redirect('authors');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        return view('author/show');
    }

    public function showAuthorsBooks($id) {
        $books = Author::findorFail($id)->books;

        return view('home', compact('books'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
