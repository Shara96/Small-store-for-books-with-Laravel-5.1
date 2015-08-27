<?php

namespace App\Http\Controllers;

use App\Book;
use App\Rating;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{


    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        if(Auth::check())
        {
            $request['user_id']=Auth::id();
            if(!Rating::where('book_id','=',$request->book_id)->where('user_id','=',$request->user_id)->exists()){
                Rating::create($request->all());
                return  1; // Added
            }
                return 2; // You have already voted on this Books
        } else{
                return 3; // You are not Logged
        }

        return $input;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $BookRating=Book::findOrFail($id);
        $bookRating=$BookRating->getBookRating();
        return $bookRating;

    }


}
