<?php

namespace App\Http\Controllers;

use App\Book;
use App\Categorie;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

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

    public function search(Request $request) {

        if (strlen($request->search) >= 1) {
            $books = Book::where('book_title', 'like', "%$request->search%")->paginate(3);
            if ($books->total() > 1) {
                Flash::success('Result');
            } else {
                Flash::success('Not Found');
            }
        }else{
            $books = Book::where('book_title', 'like', "%aaaaaaaaaaaaaaaaaaaa%")->paginate(3);
        }



        return view('home', compact('books'));
    }

}
