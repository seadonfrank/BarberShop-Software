<?php

namespace App\Http\Controllers;

use DB;
use Auth;
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

    public function getSetting()
    {
        $settings = DB::table('settings')->where('isadmin', '=', Auth::user()['isadmin'])->get();
        return view('setting', ['settings' => $settings, 'active' => 'setting']);
    }

    public function postSetting(Request $request, $id)
    {
        DB::table('settings')
            ->where('id', $id)
            ->update([
                'value' => $request->get('data'),
            ]);
        return array("response"=>true);
    }
}
