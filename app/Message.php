<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {

    protected $table = 'messages';
    protected $fillable = [
        'message',
        'book_id',
        'user_id',
        'published_at'
    ];

    /**
     * An Message is owned by a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /** returns the name of the first user "Quest"
     * @return mixed
     */
    public function getPosterUsername() {
        return User::where('id', 1)->first()->username;
    }

    /**
     * get Date format
     *
     * @return mixed
     */
    public function dateFormat() {
        return $this->created_at->diffForHumans();
    }

}
