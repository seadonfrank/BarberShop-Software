<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use App\Service;

use Log;

class ServiceController extends Controller
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
        $services = DB::table('services')->get();
        return view('service.index', ['services' => $services, 'active' => 'service']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('service.create', ['active' => 'service']);
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
            'cost' => 'required|max:255|numeric',
            'duration' => 'required|date_format:H:i:s',

        ]);
        DB::table('services')->insert(
            [
                'name' => $request->get('name'),
                'cost' => $request->get('cost'),
                'duration' => $request->get('duration'),
            ]
        );
        return redirect('service');
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
        return Service::findOrFail($id);
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
        $services = DB::table('services')->where('id', '=', $id)->get();
        return view('service.edit', ['service' => $services, 'active' => 'service']);
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
            'cost' => 'required|max:255|numeric',
            'duration' => 'required|date_format:H:i:s',
        ]);
        DB::table('services')
            ->where('id', $id)
            ->update([
                'name' => $request->get('name'),
                'cost' => $request->get('cost'),
                'duration' => $request->get('duration'),
            ]);
        return redirect('service');
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
        DB::table('services')->where('id', '=', $id)->delete();
        return array("response"=>true);
    }
}
