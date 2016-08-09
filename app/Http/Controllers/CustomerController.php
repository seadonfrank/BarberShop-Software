<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use App\Customer;

use Log;

use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $customers = DB::table('customers')->get();
        return view('customer.index', ['customers' => $customers, 'active' => 'customer']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('customer.create', ['active' => 'customer']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $api=false)
    {
        //
        $this->validate($request, [
            'name' => 'required|max:255',
            'email_address' => 'required|email|max:255|unique:customers',
            'phone_number' => 'required|max:255',
            'next_reminder' => 'required|date_format:Y-m-d H:i:s',

        ]);
        $reminder = $request->get('send_reminders');
        if(isset($reminder))
            $reminder = 1;
        else
            $reminder = 0;
        $id = DB::table('customers')->insertGetId(
            [
                'name' => $request->get('name'),
                'email_address' => $request->get('email_address'),
                'phone_number' => $request->get('phone_number'),
                'send_reminders' => $reminder,
                'is_student' => $request->get('is_student'),
                'is_child' => $request->get('is_child'),
                'is_military' => $request->get('is_military'),
                'is_beard' => $request->get('is_beard'),
                'next_reminder' =>  date("Y-m-d H:i:s", strtotime($request->get('next_reminder'))),
            ]
        );
        if($api){
            return $id;
        } else {
            return redirect('customer');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return Customer::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $customer = DB::table('customers')->where('id', '=', $id)->get();
        return view('customer.edit', ['customer' => $customer, 'active' => 'customer']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'name' => 'required|max:255',
            //'email_address' => 'required|email|max:255|unique:customers',
            'phone_number' => 'required|max:255',
            'next_reminder' => 'required|date_format:Y-m-d H:i:s',

        ]);
        $reminder = $request->get('send_reminders');
        if(isset($reminder))
            $reminder = 1;
        else
            $reminder = 0;
        DB::table('customers')
            ->where('id', $id)
            ->update([
                'name' => $request->get('name'),
                //'email_address' => $request->get('email_address'),
                'phone_number' => $request->get('phone_number'),
                'send_reminders' => $reminder,
                'is_student' => $request->get('is_student'),
                'is_child' => $request->get('is_child'),
                'is_military' => $request->get('is_military'),
                'is_beard' => $request->get('is_beard'),
                'next_reminder' =>  date("Y-m-d H:i:s", strtotime($request->get('next_reminder'))),
            ]);
        return redirect('customer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        DB::table('customers')->where('id', '=', $id)->delete();
        return array("response"=>true);
    }

    public function set_reminder(Request $request, $id)
    {
        $validator = Validator::make($request->toArray(), array(
            'next_reminder' => 'required|date_format:Y-m-d H:i:s',
        ));

        if($validator->fails()) {
            return array("response"=>false);
        } else {
            DB::table('customers')
                ->where('id', $id)
                ->update([
                    'next_reminder' =>  date("Y-m-d H:i:s", strtotime($request->get('next_reminder'))),
                ]);
            return array("response"=>true);
        }
    }
}
