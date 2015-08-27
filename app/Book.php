<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Book extends Model {

    protected $table = 'books';
    protected $fillable = ['book_title', 'smallImage_path', 'largeImage_path', 'url', 'description','price'];

    /**
     * Get the Authors associated with the given Book.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function authors() {
        return $this->belongsToMany('App\Author')->withTimestamps();
    }

    /**
     * many Books may have a many  "Category" (Relationships)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categorie() {
        return $this->belongsToMany('App\Categorie')->withTimestamps();
    }

    /**
     * An Book is owned by a user (Relationships)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users() {
        return $this->belongsTo('App\User');
    }

    /**
     * a user has a lot of Ratings (Relationships)
     * @return mixed
     */
    public function ratings(){
        return $this->hasMany('App\Rating');
    }

    /**
     * gives all categories that belong to a book
     *
     * @return mixed
     */
    public function CategorieList() {
        return $this->categorie->lists('id')->toArray();
    }

    /**
     * gives all Authors that belong to a book
     *
     * @return mixed
     */
    public function AuthorsList() {
        return $this->authors->lists('id')->toArray();
    }

    /**
     * gives little description of 10 words
     *
     * @param $id
     * @return string
     */
    public function smallDescription($id) {
        // $newtext = wordwrap($text, 20, "<br />\n");
        $SmallDescription = str_word_count(Book::findOrFail($id)->description, 1);
        $returnSmallDescription = [];
        foreach ($SmallDescription as $key => $SmallDescriptions) {
            if ($key <= 10) {
                $returnSmallDescription[] = $SmallDescriptions;
            } else {
                break;
            }
        }
        return implode(" ", $returnSmallDescription);
    }

    public function getCountRating(){
        $CountRating=$this->ratings()->count();
        return $CountRating;
    }

    public function getBookRating(){
        $bookRatingg=round($this->ratings()->avg('rating'));
        return $bookRatingg;
    }
}
