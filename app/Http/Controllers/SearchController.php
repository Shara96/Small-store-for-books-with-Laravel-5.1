<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search(Request $request) {

        if (strlen($request->search) >= 1) {
            $books = Book::where('book_title', 'like', "%$request->search%")->paginate(3);
            if ($books->total() >= 1) {
                Flash::success('Result');
            } else {
                Flash::success('Not Found');
            }
        }else{
            Flash::success('Field is empty');
            $books = Book::where('book_title', 'like', "%aaaaaaaaaaaaaaaaaaaa%")->paginate(3);
        }



        return view('home', compact('books'));
    }
}
