<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model {

    protected $table = 'categories';
    protected $fillable = ['category'];

    /**
     * many Books may have a many  "Category"
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function books() {
        return $this->belongsToMany('App\Book');
    }

}
