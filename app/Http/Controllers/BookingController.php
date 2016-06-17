<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Log;

use App\Service;

use App\Booking;

use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->toArray(), array(
            'customer' => 'required|max:255|numeric',
            'stylist' => 'required|max:255|numeric',
            'start' => 'required|date_format:Y-m-d H:i:s',
        ));

        if (count($request->get('services')) <=  0) {
            $validator->after(function ($validator) {
                $validator->getMessageBag()->add('services', 'The services field is required.');
            });
        }

        if($validator->fails()) {
            return redirect('booking/create')
                ->withErrors($validator);
        }

        $booking = new Booking();
        $booking->customer_id = $request->get('customer');
        $booking->user_id = $request->get('stylist');
        $booking->status = "Finalise";
        $booking->save();

        foreach($request->get('services') as $service) {
            $booking->services()->attach($service, array('start_date_time'=>$request->get("start")));
        }

        return redirect('booking');
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

    public function availability($user_id, $customer_id, $date_time, $duration) {
        $availability = DB::table('booking_service')
            ->join('bookings', 'bookings.id', '=', 'booking_service.booking_id')
            ->join('services', 'services.id', '=', 'booking_service.service_id')
            ->whereDate('booking_service.start_date_time', '=', \DateTime::createFromFormat('Y-m-d H:i:s', $date_time)->format('Y-m-d'))
            //->whereDate('booking_service.start_date_time', '<=', \DateTime::createFromFormat('Y-m-d H:i:s', $date_time)->format('Y-m-d'))
            ->where('bookings.user_id', '=', $user_id)
            ->orWhere('bookings.customer_id', '=', $customer_id)
            ->where('bookings.status', '!=', "Canceled")
            ->get();

        foreach($availability as $avail) {
            //if($date_time >= $avail['start_date_time'] || $date_time <= $avail['start_date_time'])
        }


        return $availability;

    }
}
