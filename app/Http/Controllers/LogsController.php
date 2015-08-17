<?php

namespace App\Http\Controllers;

use App\PayPalLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogsController extends Controller
{
    /**
     * @return $this
     */
    public function index() {
        if (Auth::check()) {
            $logs = PayPalLog::orderBy('created_at','DESC')->where('state', "!=", "unfinished!")->get();

            $this_month = Carbon::now();
            $this_month->day = 1; // first of the month

            // THIS DOES NOT WORK vvv
            $this_month_logs = PayPalLog::where('created_at', '>=', $this_month->toDateString());
            $month_total = 0;

            foreach ($this_month_logs as $log){
                $month_total += $log->total;
            }


            return View('admin.logs')
                ->with('title', 'Purchase logs')
                ->with('logs', $logs)
                ->with('month_total', $month_total)
                ->with('month_logs', $this_month_logs);

        } else {
            return Redirect::route('oils.index')
                ->with('message' , "Sorry you don't have rights to create a Category, please login");
        }

    }

}
