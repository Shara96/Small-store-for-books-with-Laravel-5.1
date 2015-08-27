<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';

    protected $fillable = [
        'rating',
        'book_id',
        'user_id',
    ];

    /**
     * Relationships whit Books
     * @return mixed
     */
    public function books(){
        return $this->belongTo('App\Book');
    }

    /**
     * Relationships whit User
     * @return mixed
     */
    public function users(){
        return $this->belongTo('App\User');
    }

    /**
     * Get Count Rating
     * @param $id
     * @return mixed
     */
    public function getCountRating($id){
        $CountRating=Rating::where('book_id','=',$id)->count();
        return $CountRating;
    }

    /**
     * Get Book Rating
     * @param $id
     * @return mixed
     */
    public function getBookRating($id){
        $bookRating=round(Rating::where('book_id','=',$id)->avg('rating'));
        return $bookRating;
    }

}
