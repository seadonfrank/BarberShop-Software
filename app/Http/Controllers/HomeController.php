<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function opt_out_customer($id)
    {
        $customer = Customer::find($id);
        $customer->send_reminders = 0;
        $customer->save();

        return "You have been opt-out successfully";
    }
}
