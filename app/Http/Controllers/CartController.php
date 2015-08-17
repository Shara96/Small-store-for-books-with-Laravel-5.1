<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\CreateCartRequest;
use Cart;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    private $cart;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cart=$this->getCartsContent();
        return view('cart.index',compact('cart'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCartRequest|Request $request
     * @return Response
     */
    public function store(CreateCartRequest $request)
    {
        $book=Book::find($request->bookId);
        $Quantity=$request->Quantity;
        Cart::add([
            'id' => $book->id,
            'name' => $book->book_title,
            'qty' => $Quantity,
            'price' => $book->price,
            'options' => array('size' => 'large')
        ]);
        $cart=$this->getCartsContent();
        return  view('cart.index',compact('cart'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Cart::remove($id);
        $cart=$this->getCartsContent();
        return view('cart.index',compact('cart'));
    }
    public function getCartsContent()
    {
        $cart=Cart::content();
        return $cart;
    }
}
