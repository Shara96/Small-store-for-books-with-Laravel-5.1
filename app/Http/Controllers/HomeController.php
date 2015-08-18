<?php

namespace App\Http\Controllers;

use App\Book;
use App\Categorie;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        $books = Book::orderBy('created_at', 'desc')->paginate(3);
        return view('home', compact('books'));
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function showCategorieBooks($id) {
        $books = Categorie::findOrFail($id)->books()->paginate(3);


        return view('home', compact('books'));
    }

}
