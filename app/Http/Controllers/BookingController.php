<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Log;

use App\Service;

use App\Booking;

class BookingController extends Controller
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
        $bookings = DB::table('bookings')->get();
        return view('booking.index', ['bookings' => $bookings, 'active' => 'booking']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $customers = DB::table('customers')->select('id', 'name')->get();
        $users = DB::table('users')->select('id', 'name')->get();
        $services = DB::table('services')->select('id', 'name')->get();
        return view('booking.create', [
            'customers' => $customers,
            'users' => $users,
            'services' => $services,
            'active' => 'booking'
        ]);
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
        $booking = new Booking();
        $booking->customer_id = $request->get('customer_id');
        $booking->user_id = $request->get('user_id');
        $booking->status = "Finalise";
        $booking->save();

        $booking->services()->attach(1, array('cost'=>10));
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
    }

    public function events() {
        return '{
            "success": 1,
            "result": [
                {
                    "id": "293",
                    "title": "This is warning class event with very long title to check how it fits to event in day view",
                    "class": "event-warning",
                    "start": "1465579633000",
                    "end":   "1465579633000"
                },
                {
                    "id": "276",
                    "title": "Short day event",
                    "class": "event-success",
                    "start": "1363245600000",
                    "end":   "1363252200000"
                },
                {
                    "id": "294",
                    "title": "This is information class ",
                    "class": "event-info",
                    "start": "1363111200000",
                    "end":   "1363284086400"
                },
                {
                    "id": "297",
                    "title": "This is success event",
                    "class": "event-success",
                    "start": "1363234500000",
                    "end":   "1363284062400"
                },
                {
                    "id": "54",
                    "title": "This is simple event",
                    "class": "",
                    "start": "1363712400000",
                    "end":   "1363716086400"
                },
                {
                    "id": "532",
                    "title": "This is inverse event",
                    "url": "http://www.example.com/",
                    "class": "event-inverse",
                    "start": "1364407200000",
                    "end":   "1364493686400"
                },
                {
                    "id": "548",
                    "title": "This is special event",
                    "class": "event-special",
                    "start": "1363197600000",
                    "end":   "1363629686400"
                },
                {
                    "id": "295",
                    "title": "Event 3",
                    "class": "event-important",
                    "start": "1364320800000",
                    "end":   "1364407286400"
                }
            ]
        }';
    }

    public function event($id) {
        return array('name'=>$id);
    }

    public function availability($stylist, $start, $services) {
        $availability = DB::table('booking')
            ->select(DB::raw('count(*) as user_count, status'))
            ->where('status', '<>', 1)
            ->groupBy('status')
            ->get();

    }
}
