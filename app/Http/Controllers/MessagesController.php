<?php

namespace App\Http\Controllers;

use App\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagesController extends Controller {

    /**
     * Save Messages in DATABASE
     *
     * @param Requests|Request $requests
     * @return string
     */
    public function setMessages(Request $requests) {
        $requests['published_at'] = Carbon::now();
        Message::create($requests->all());
        return redirect()->action('BooksController@show', [$requests->input('book_id')]);
    }

}
