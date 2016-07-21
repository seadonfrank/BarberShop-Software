<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use DB;

class UserController extends Controller
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
        $users = DB::table('users')->get();
        return view('user.index', ['users' => $users, 'active' => 'user']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('user.create', ['active' => 'user']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'isadmin' => 'required',
        ]);

        DB::table('users')->insert(
            [
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
                'isadmin' => $request->get('isadmin'),
            ]
        );

        return redirect('user');
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
        return User::findOrFail($id);
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
        $user = DB::table('users')->where('id', '=', $id)->get();
        return view('user.edit', ['user' => $user, 'active' => 'user']);
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
        if(!empty($request->get('password'))) {
            $this->validate($request, [
                'name' => 'required|max:255',
                //'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
                'isadmin' => 'required',
            ]);

            DB::table('users')
                ->where('id', $id)
                ->update([
                    'name' => $request->get('name'),
                    //'email' => $request->get('email'),
                    'password' => bcrypt($request->get('password')),
                    'isadmin' => $request->get('isadmin'),
                ]);

        } else {
            $this->validate($request, [
                'name' => 'required|max:255',
                //'email' => 'required|email|max:255|unique:users',
                'isadmin' => 'required',
            ]);

            DB::table('users')
                ->where('id', $id)
                ->update([
                    'name' => $request->get('name'),
                    //'email' => $request->get('email'),
                    'isadmin' => $request->get('isadmin'),
                ]);
        }

        return redirect('user');
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
        DB::table('users')->where('id', '=', $id)->delete();
        return array("response"=>true);
    }
}
