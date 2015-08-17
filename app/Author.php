<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model {

    protected $table = 'authors';
    protected $fillable = ['author_name'];

    /**
     * Get the Books associated with the given Author.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function books() {
        return $this->belongsToMany('App\Book');
    }

}
