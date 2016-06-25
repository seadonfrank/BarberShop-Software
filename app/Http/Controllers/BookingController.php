<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Log;

use App\Customer;

use App\User;

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
        $booking->status = "Finalised";
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
        $events = DB::table('booking_service')
            ->join('bookings', 'bookings.id', '=', 'booking_service.booking_id')
            ->join('services', 'services.id', '=', 'booking_service.service_id')
            ->where('bookings.id', '=', $id)
            ->get();

        $result = array();
        foreach($events as $event) {
            $result[$event->booking_id]['start_date_time'] = $event->start_date_time;
            $result[$event->booking_id]['service_ids'][] = $event->service_id;
            $result[$event->booking_id]['service_names'][] = $event->name;
            $result[$event->booking_id]['service_costs'][] = $event->cost;
            $result[$event->booking_id]['service_durations'][] = $event->duration;
            $result[$event->booking_id]['customer'] = Customer::find($event->customer_id);
            $result[$event->booking_id]['user'] = User::find($event->user_id);;
            $result[$event->booking_id]['status'] = $event->status;
        }
        foreach($result as $key=>$value) {
            $eve_end_date_time = new \DateTime($value['start_date_time']);
            foreach($value['service_durations'] as $duration) {
                $duration = explode(':', $duration);
                $eve_end_date_time->modify("+{$duration[0]} hours");
                $eve_end_date_time->modify("+{$duration[1]} minutes");
                $eve_end_date_time->modify("+{$duration[2]} seconds");
            }
            $result[$key]['id'] = $key;
            $result[$key]['end_date_time'] = date('Y-m-d H:i:s',$eve_end_date_time->getTimestamp());
        }

        return $result[$id];
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
        $customers = DB::table('customers')->select('id', 'name')->get();
        $users = DB::table('users')->select('id', 'name')->get();
        $services = DB::table('services')->select('id', 'name')->get();
        return view('booking.edit', [
            'customers' => $customers,
            'users' => $users,
            'services' => $services,
            'booking' => $this->show($id),
            'active' => 'booking'
        ]);
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

        $booking = Booking::find($id);
        $booking->customer_id = $request->get('customer');
        $booking->user_id = $request->get('stylist');
        $booking->status = "Finalised";
        $booking->save();

        $booking->services()->detach();

        foreach($request->get('services') as $service) {
            $booking->services()->attach($service, array('start_date_time'=>$request->get("start")));
        }

        return redirect('booking');
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
        Booking::find($id)->services()->detach();
        DB::table('bookings')->where('id', '=', $id)->delete();
        return array("response"=>true);
    }

    public function getProcess()
    {
        //
        $processes = DB::table('booking_service')
            ->select('bookings.customer_id', 'bookings.user_id', 'bookings.status', 'bookings.created_at',
            'services.name','services.cost','services.duration',
            'booking_service.start_date_time', 'booking_service.booking_id', 'booking_service.service_id')
            ->join('bookings', 'bookings.id', '=', 'booking_service.booking_id')
            ->join('services', 'services.id', '=', 'booking_service.service_id')
            ->where('bookings.status', '=', "Finalised")
            ->get();

        $temp_processes = array();
        foreach($processes as $process) {
            $temp_processes[$process->booking_id]['start_date_time'] = $process->start_date_time;
            $temp_processes[$process->booking_id]['service_ids'][] = $process->service_id;
            $temp_processes[$process->booking_id]['service_names'][] = $process->name;
            $temp_processes[$process->booking_id]['service_costs'][] = $process->cost;
            $temp_processes[$process->booking_id]['service_durations'][] = $process->duration;
            $temp_processes[$process->booking_id]['customer'] = Customer::find($process->customer_id);
            $temp_processes[$process->booking_id]['user'] = User::find($process->user_id);;
            $temp_processes[$process->booking_id]['status'] = $process->status;
            $temp_processes[$process->booking_id]['created_at'] = $process->created_at;
        }

        foreach($temp_processes as $key=>$value) {
            $pro_end_date_time = new \DateTime($value['start_date_time']);
            foreach($value['service_durations'] as $duration) {
                $duration = explode(':', $duration);
                $pro_end_date_time->modify("+{$duration[0]} hours");
                $pro_end_date_time->modify("+{$duration[1]} minutes");
                $pro_end_date_time->modify("+{$duration[2]} seconds");
            }
            $temp_processes[$key]['end_date_time'] = date('Y-m-d H:i:s',$pro_end_date_time->getTimestamp());
            $temp_processes[$key]['id'] = $key;
        }

        return view('booking.process', ['processes' => $temp_processes, 'active' => 'process_booking']);
    }

    public function postProcess($id)
    {
        $booking = Booking::find($id);
        $booking->status = "Processed";
        $booking->save();
        return array("response"=>true);
    }

    public function events(request $request)
    {
        //class : event-success event-warning event-info event-inverse event-important event-special

        $temp_events = DB::table('booking_service')
            ->join('bookings', 'bookings.id', '=', 'booking_service.booking_id')
            ->join('services', 'services.id', '=', 'booking_service.service_id')
            ->whereRaw('DATE(booking_service.start_date_time) < "'.date("Y-m-d H:i:s").'"')
            ->get();

        $events = array();
        foreach($temp_events as $event) {
            $events[$event->booking_id]['start'] = $event->start_date_time;
            $events[$event->booking_id]['service_durations'][] = $event->duration;
            $events[$event->booking_id]['status'] = $event->status;
            $events[$event->booking_id]['title'] = "<i class='fa fa-scissors'></i> ".User::find($event->user_id)->name." | <i class='fa fa-user'></i> ".Customer::find($event->customer_id)->name;
        }

        $result = array();
        foreach($events as $key=>$value) {
            $eve_end_date_time = new \DateTime($value['start']);
            $eve_start_date_time = new \DateTime($value['start']);
            foreach($value['service_durations'] as $duration) {
                $duration = explode(':', $duration);
                $eve_end_date_time->modify("+{$duration[0]} hours");
                $eve_end_date_time->modify("+{$duration[1]} minutes");
                $eve_end_date_time->modify("+{$duration[2]} seconds");
            }
            unset($events[$key]['service_durations']);
            $events[$key]['id']=$key."";
            $events[$key]['end'] = strtotime(date('Y-m-d H:i:s',$eve_end_date_time->getTimestamp()))."000";
            $events[$key]['start'] = strtotime(date('Y-m-d H:i:s',$eve_start_date_time->getTimestamp()))."000";
            if($value['status'] == "Finalised") {
                $events[$key]['class'] = "event-important";
            } elseif($value['status'] == "Processed") {
                $events[$key]['class'] = "event-success";
            } elseif($value['status'] == "Canceled") {
                $events[$key]['class'] = "event-warning";
            } else {
                $events[$key]['class'] = "event-info";
            }
            $result[] = $events[$key];
        }

        return array("success" => 1, "result" =>$result);
    }

    public function availability($user_id, $customer_id, $start_date_time, $service_ids)
    {
        $available = true;

        $durations = DB::table('services')->whereRaw('id in ('.$service_ids.')')->get();

        $total_duration = "00:00:00";
        foreach($durations as $duration) {
            $temp_time = array();
            $time1 = explode(':', $duration->duration);
            $time2 = explode(':', $total_duration);
            $temp_time[0] = $time1[0] + $time2[0];
            $temp_time[1] = $time1[1] + $time2[1];
            $temp_time[2] = $time1[2] + $time2[2];
            $total_duration = implode(':', $temp_time);
        }

        $end_date_time = new \DateTime($start_date_time);
        $start_date_time = new \DateTime($start_date_time);
        $duration = explode(':', $total_duration);
        $end_date_time->modify("+{$duration[0]} hours");
        $end_date_time->modify("+{$duration[1]} minutes");
        $end_date_time->modify("+{$duration[2]} seconds");

        $availabilities = DB::table('booking_service')
            ->join('bookings', 'bookings.id', '=', 'booking_service.booking_id')
            ->join('services', 'services.id', '=', 'booking_service.service_id')
            ->whereRaw('DATE(booking_service.start_date_time) = "'.date('Y-m-d', $start_date_time->getTimestamp()).'"')
            ->where(function ($query) use($user_id, $customer_id) {
                $query->where('bookings.user_id', '=', $user_id)
                    ->orWhere('bookings.customer_id', '=', $customer_id);
            })
            ->where('bookings.status', '=', "Finalised")
            ->get();

        $temp_availabilities = array();
        foreach($availabilities as $availability) {
            $temp_availabilities[$availability->booking_id]['start_date_time'] = $availability->start_date_time;
            $temp_availabilities[$availability->booking_id]['service_ids'][] = $availability->service_id;
            $temp_availabilities[$availability->booking_id]['service_names'][] = $availability->name;
            $temp_availabilities[$availability->booking_id]['service_costs'][] = $availability->cost;
            $temp_availabilities[$availability->booking_id]['service_durations'][] = $availability->duration;
            $temp_availabilities[$availability->booking_id]['customer'] = Customer::find($availability->customer_id);
            $temp_availabilities[$availability->booking_id]['user'] = User::find($availability->user_id);;
            $temp_availabilities[$availability->booking_id]['status'] = $availability->status;
        }
        $availabilities = $temp_availabilities;
        foreach($availabilities as $key=>$value) {
            $avail_end_date_time = new \DateTime($value['start_date_time']);
            $avail_start_date_time = new \DateTime($value['start_date_time']);
            foreach($value['service_durations'] as $duration) {
                $duration = explode(':', $duration);
                $avail_end_date_time->modify("+{$duration[0]} hours");
                $avail_end_date_time->modify("+{$duration[1]} minutes");
                $avail_end_date_time->modify("+{$duration[2]} seconds");
            }
            $availabilities[$key]['end_date_time'] = date('Y-m-d H:i:s',$avail_end_date_time->getTimestamp());

            if((($start_date_time->getTimestamp() >= $avail_start_date_time->getTimestamp()) &&
                    ($start_date_time->getTimestamp() <= $avail_end_date_time->getTimestamp())) ||
                (($end_date_time->getTimestamp() >= $avail_start_date_time->getTimestamp()) &&
                    ($end_date_time->getTimestamp() <= $avail_end_date_time->getTimestamp()))) {
                $available = false;
            }
        }

        return array(
            'availabilities' => $availabilities,
            'end_date_time' => date('Y-m-d H:i:s',$end_date_time->getTimestamp()),
            'duration' => $total_duration,
            'available' => $available
        );
    }
}
