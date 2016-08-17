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
        $users = DB::table('users')->select('id', 'name')->where('isadmin', '!=', 1)->get();
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
        $validator = null;
        $customer_id = $request->get('customer');
        if(isset($customer_id) && $customer_id != "") {
            $validator = Validator::make($request->toArray(), array(
                'customer' => 'required|max:255|numeric',

                'stylist' => 'required|max:255|numeric',
                'start_date' => 'required|date_format:Y-m-d',
                'start_time' => 'required|date_format:H:i',
            ));
        } else {
            $validator = Validator::make($request->toArray(), array(
                'name' => 'required|max:255',
                'email_address' => 'required|email|max:255|unique:customers',
                'phone_number' => 'required|max:255',
                'next_reminder' => 'required|date_format:Y-m-d H:i:s',

                'stylist' => 'required|max:255|numeric',
                'start_date' => 'required|date_format:Y-m-d',
                'start_time' => 'required|date_format:H:i',
            ));
        }

        $services = DB::table('services')->select('id', 'name')->get();
        $services_request = array();
        foreach($services as $service) {
            if($request->get('service_'.$service->id)){
                $services_request[] = $service->id;
            }
        }

        if (count($services_request) <=  0) {
            $validator->after(function ($validator) {
                $validator->getMessageBag()->add('services', 'The services field is required.');
            });
        }

        if($validator->fails()) {
            return redirect('booking/create')
                ->withErrors($validator)
                ->withInput();
        }

        $booking = new Booking();
        if(isset($customer_id) && $customer_id != "") {
            $booking->customer_id = $request->get('customer');
        } else {
            $customer = new CustomerController();
            $booking->customer_id = $customer->store($request, true);
        }
        $booking->user_id = $request->get('stylist');
        $booking->status = "Finalised";
        $booking->send_reminders = 1;
        $booking->save();

        foreach($services_request as $service) {
            $booking->services()->attach(
                $service,
                array('start_date_time'=>$request->get("start_date")." ".$request->get("start_time").":00")
            );
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
        $validator = null;
        $customer_id = $request->get('customer');
        if(isset($customer_id) && $customer_id != "") {
            $validator = Validator::make($request->toArray(), array(
                'customer' => 'required|max:255|numeric',

                'stylist' => 'required|max:255|numeric',
                'start_date' => 'required|date_format:Y-m-d',
                'start_time' => 'required|date_format:H:i',
            ));
        } else {
            $validator = Validator::make($request->toArray(), array(
                'name' => 'required|max:255',
                'email_address' => 'required|email|max:255|unique:customers',
                'phone_number' => 'required|max:255',
                'next_reminder' => 'required|date_format:Y-m-d H:i:s',

                'stylist' => 'required|max:255|numeric',
                'start_date' => 'required|date_format:Y-m-d',
                'start_time' => 'required|date_format:H:i',
            ));
        }

        $services = DB::table('services')->select('id', 'name')->get();
        $services_request = array();
        foreach($services as $service) {
            if($request->get('service_'.$service->id)){
                $services_request[] = $service->id;
            }
        }

        if (count($services_request) <=  0) {
            $validator->after(function ($validator) {
                $validator->getMessageBag()->add('services', 'The services field is required.');
            });
        }

        if($validator->fails()) {
            return redirect('booking/'.$id.'/edit')
                ->withErrors($validator)
                ->withInput();
        }

        $booking = Booking::find($id);
        if(isset($customer_id) && $customer_id != "") {
            $booking->customer_id = $request->get('customer');
        } else {
            $customer = new CustomerController();
            $booking->customer_id = $customer->store($request, true);
        }
        $booking->user_id = $request->get('stylist');
        $booking->status = "Finalised";
        $booking->send_reminders = 1;
        $booking->save();

        $booking->services()->detach();

        foreach($services_request as $service) {
            $booking->services()->attach(
                $service,
                array('start_date_time'=>$request->get("start_date")." ".$request->get("start_time").":00")
            );
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

    public function cancel($id)
    {
        $booking = Booking::find($id);
        $booking->status = "Canceled";
        $booking->save();
        return array("response"=>true);
    }

    public function process()
    {
        //
        $processes = DB::table('booking_service')
            ->select('bookings.customer_id', 'bookings.user_id', 'bookings.status', 'bookings.created_at',
            'services.name','services.cost','services.duration',
            'booking_service.start_date_time', 'booking_service.booking_id', 'booking_service.service_id')
            ->join('bookings', 'bookings.id', '=', 'booking_service.booking_id')
            ->join('services', 'services.id', '=', 'booking_service.service_id')
            ->whereRaw('DATE(booking_service.start_date_time) < "'.date("Y-m-d H:i:s").'"')
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

    public function getProcess($id)
    {
        $processor = DB::table('booking_service')
            ->select('bookings.customer_id', 'bookings.user_id', 'bookings.status', 'bookings.created_at',
                'services.name','services.cost','services.duration',
                'booking_service.start_date_time', 'booking_service.booking_id', 'booking_service.service_id')
            ->join('bookings', 'bookings.id', '=', 'booking_service.booking_id')
            ->join('services', 'services.id', '=', 'booking_service.service_id')
            //->join('products', 'products.id', '=', 'booking_product.product_id')
            ->whereRaw('DATE(booking_service.start_date_time) < "'.date("Y-m-d H:i:s").'"')
            ->where('bookings.status', '=', "Finalised")
            ->where('bookings.id', '=', $id)
            ->get();

        $temp_process = array();
        foreach($processor as $process) {
            $temp_process[$process->booking_id]['start_date_time'] = $process->start_date_time;
            $temp_process[$process->booking_id]['start_date'] = date('D M j Y', strtotime($process->start_date_time));
            $temp_process[$process->booking_id]['start_time'] = date('g:i a', strtotime($process->start_date_time));
            $temp_process[$process->booking_id]['services'][$process->service_id]['name'] = $process->name;
            $temp_process[$process->booking_id]['services'][$process->service_id]['cost'] = $process->cost;
            $temp_process[$process->booking_id]['services'][$process->service_id]['duration'] = $process->duration;
            $temp_process[$process->booking_id]['customer'] = Customer::find($process->customer_id);
            $temp_process[$process->booking_id]['user'] = User::find($process->user_id);;
            $temp_process[$process->booking_id]['status'] = $process->status;
            $temp_process[$process->booking_id]['created_at'] = $process->created_at;
        }

        if(count($temp_process) <= 0) {
            return "It Seams like this booking is not available or that its already been processed.";
        }

        return view('booking.processor', [
            'process' => $temp_process,
            'products' => $products = DB::table('products')->get(),
            'id' => $id,
            'active' => 'process_booking'
        ]);
    }

    public function postProcess(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            //'email_address' => 'required|email|max:255|unique:customers',
            'phone_number' => 'required|max:255',
        ]);
        $reminder = $request->get('send_reminders');
        if(isset($reminder))
            $reminder = 1;
        else
            $reminder = 0;
        $next_reminder = date("Y-m-d");
        $days = (int)$request->get('next_reminder')*7;
        $next_reminder = date('Y-m-d', strtotime($next_reminder. ' + '.$days.' days'));
        DB::table('customers')
            ->where('id', $request->get('customer_id'))
            ->update([
                'name' => $request->get('name'),
                //'email_address' => $request->get('email_address'),
                'phone_number' => $request->get('phone_number'),
                'send_reminders' => $reminder,
                'is_student' => $request->get('is_student'),
                'is_child' => $request->get('is_child'),
                'is_military' => $request->get('is_military'),
                'is_beard' => $request->get('is_beard'),
                'next_reminder' =>  date("Y-m-d H:i:s", strtotime($next_reminder)),
            ]);


        $booking = Booking::find($id);
        $booking->status = "Processed";
        if($request->get('other_checked')){
            $booking->other_service = $request->get('other_service');
            $booking->other_cost = $request->get('other_cost');
        }
        $booking->save();

        $booking->products()->detach();
        if(count($request->get('product')) > 0) {
            foreach($request->get('product') as $key => $value) {
                $booking->products()->attach($key, array('quantity'=>$value['quantity'], 'actual_cost'=>$value['actual_cost']));
            }
        }

        $booking->services()->detach();
        if(count($request->get('service')) > 0){
            foreach($request->get('service') as $key => $value) {
                if($value['checked'])
                    $booking->services()->attach($key, array('start_date_time'=>$request->get('start_date_time'), 'actual_cost'=>$value['actual_cost']));
            }

        }

        return redirect('booking');
    }

    public function events(request $request)
    {
        //class : event-success event-warning event-info event-inverse event-important event-special

        $temp_events = DB::table('booking_service')
            ->join('bookings', 'bookings.id', '=', 'booking_service.booking_id')
            ->join('services', 'services.id', '=', 'booking_service.service_id')
            ->get();

        $events = array();
        foreach($temp_events as $event) {
            $events[$event->booking_id]['start'] = $event->start_date_time;
            $events[$event->booking_id]['service_durations'][] = $event->duration;
            $events[$event->booking_id]['status'] = $event->status;
            $events[$event->booking_id]['title'] = "<i class='fa fa-scissors'></i> ".User::find($event->user_id)->name." | <i class='fa fa-user'></i> ".Customer::find($event->customer_id)->name." : ".$event->status;
            $events[$event->booking_id]['heading'] = "Stylist ".User::find($event->user_id)->name." with customer ".Customer::find($event->customer_id)->name." has status ".$event->status;
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

    public function availability($user_id, $customer_id, $start_date_time, $service_ids, $booking_id = null)
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
            if($booking_id != null && $booking_id != $availability->booking_id) {
                $temp_availabilities[$availability->booking_id]['start_date_time'] = $availability->start_date_time;
                $temp_availabilities[$availability->booking_id]['service_ids'][] = $availability->service_id;
                $temp_availabilities[$availability->booking_id]['service_names'][] = $availability->name;
                $temp_availabilities[$availability->booking_id]['service_costs'][] = $availability->cost;
                $temp_availabilities[$availability->booking_id]['service_durations'][] = $availability->duration;
                $temp_availabilities[$availability->booking_id]['customer'] = Customer::find($availability->customer_id);
                $temp_availabilities[$availability->booking_id]['user'] = User::find($availability->user_id);;
                $temp_availabilities[$availability->booking_id]['status'] = $availability->status;
            }
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

        $stylist_availabilities_this = DB::table('booking_service')
            ->join('bookings', 'bookings.id', '=', 'booking_service.booking_id')
            ->join('services', 'services.id', '=', 'booking_service.service_id')
            ->whereRaw('DATE(booking_service.start_date_time) = "'.date('Y-m-d', $start_date_time->getTimestamp()).'"')
            ->where('bookings.user_id', '=', $user_id)
            ->where('bookings.status', '=', "Finalised")
            ->get();

        $temp_stylist_availabilities_this = array();
        foreach($stylist_availabilities_this as $stylist_availability_this) {
            $temp_stylist_availabilities_this[$stylist_availability_this->booking_id]['start_date_time'] = $stylist_availability_this->start_date_time;
            $temp_stylist_availabilities_this[$stylist_availability_this->booking_id]['service_ids'][] = $stylist_availability_this->service_id;
            $temp_stylist_availabilities_this[$stylist_availability_this->booking_id]['service_names'][] = $stylist_availability_this->name;
            $temp_stylist_availabilities_this[$stylist_availability_this->booking_id]['service_costs'][] = $stylist_availability_this->cost;
            $temp_stylist_availabilities_this[$stylist_availability_this->booking_id]['service_durations'][] = $stylist_availability_this->duration;
            $temp_stylist_availabilities_this[$stylist_availability_this->booking_id]['customer'] = Customer::find($stylist_availability_this->customer_id);
            $temp_stylist_availabilities_this[$stylist_availability_this->booking_id]['user'] = User::find($stylist_availability_this->user_id);;
            $temp_stylist_availabilities_this[$stylist_availability_this->booking_id]['status'] = $stylist_availability_this->status;
        }

        $stylist_availabilities_all = DB::table('booking_service')
            ->join('bookings', 'bookings.id', '=', 'booking_service.booking_id')
            ->join('services', 'services.id', '=', 'booking_service.service_id')
            ->whereRaw('DATE(booking_service.start_date_time) = "'.date('Y-m-d', $start_date_time->getTimestamp()).'"')
            ->where('bookings.status', '=', "Finalised")
            ->get();

        $temp_stylist_availabilities_all = array();
        foreach($stylist_availabilities_all as $stylist_availability_all) {
            $temp_stylist_availabilities_all[$stylist_availability_all->booking_id]['start_date_time'] = $stylist_availability_all->start_date_time;
            $temp_stylist_availabilities_all[$stylist_availability_all->booking_id]['service_ids'][] = $stylist_availability_all->service_id;
            $temp_stylist_availabilities_all[$stylist_availability_all->booking_id]['service_names'][] = $stylist_availability_all->name;
            $temp_stylist_availabilities_all[$stylist_availability_all->booking_id]['service_costs'][] = $stylist_availability_all->cost;
            $temp_stylist_availabilities_all[$stylist_availability_all->booking_id]['service_durations'][] = $stylist_availability_all->duration;
            $temp_stylist_availabilities_all[$stylist_availability_all->booking_id]['customer'] = Customer::find($stylist_availability_all->customer_id);
            $temp_stylist_availabilities_all[$stylist_availability_all->booking_id]['user'] = User::find($stylist_availability_all->user_id);;
            $temp_stylist_availabilities_all[$stylist_availability_all->booking_id]['status'] = $stylist_availability_all->status;
        }

        return array(
            'availabilities' => $availabilities,
            'end_date_time' => date('Y-m-d H:i:s',$end_date_time->getTimestamp()),
            'duration' => $total_duration,
            'available' => $available,
            'stylist_availabilities_this' => $temp_stylist_availabilities_this,
            'stylist_availabilities_all' => $temp_stylist_availabilities_all
        );
    }

    public function stylist_availability($date_time, $user_id=0) {
        $result = array();
        if($user_id) {
            $result[$user_id] = $this->stylist_availability_user($date_time, $user_id);
        } else {
            $users = DB::table('users')->select('id')->where('isadmin', '!=', 1)->get();
            foreach($users as $user) {
                $result[$user->id] = $this->stylist_availability_user($date_time, $user->id);
            }
        }
        return $result;
    }

    public function stylist_availability_user($date_time, $user_id)
    {
        $date_time = new \DateTime($date_time);

        $stylist_availabilities = null;
        $stylist_availabilities = DB::table('booking_service')
            ->join('bookings', 'bookings.id', '=', 'booking_service.booking_id')
            ->join('services', 'services.id', '=', 'booking_service.service_id')
            ->whereRaw('DATE(booking_service.start_date_time) = "'.date('Y-m-d', $date_time->getTimestamp()).'"')
            ->where('bookings.user_id', '=', $user_id)
            ->where('bookings.status', '=', "Finalised")
            ->orderBy('booking_service.start_date_time')
            ->get();

        $raw_stylist_availabilities = array();
        foreach($stylist_availabilities as $stylist_availability) {
            $raw_stylist_availabilities[$stylist_availability->booking_id]['start_date_time'] = $stylist_availability->start_date_time;
            $raw_stylist_availabilities[$stylist_availability->booking_id]['service_ids'][] = $stylist_availability->service_id;
            $raw_stylist_availabilities[$stylist_availability->booking_id]['service_names'][] = $stylist_availability->name;
            $raw_stylist_availabilities[$stylist_availability->booking_id]['service_costs'][] = $stylist_availability->cost;
            $raw_stylist_availabilities[$stylist_availability->booking_id]['service_durations'][] = $stylist_availability->duration;
            $raw_stylist_availabilities[$stylist_availability->booking_id]['customer'] = Customer::find($stylist_availability->customer_id);
            $raw_stylist_availabilities[$stylist_availability->booking_id]['user'] = User::find($stylist_availability->user_id);;
            $raw_stylist_availabilities[$stylist_availability->booking_id]['status'] = $stylist_availability->status;
        }

        $format_stylist_availabilities = array();
        $setting = DB::table('settings')->whereIn('id', [2, 3, 4])->get();
        $start_date_time = $open_date_time = new \DateTime(date('Y-m-d', $date_time->getTimestamp())." ".$setting[1]->value.":00");
        $end_date_time = $close_date_time = new \DateTime(date('Y-m-d', $date_time->getTimestamp())." ".$setting[2]->value.":00");

        if(count($raw_stylist_availabilities) <= 0) {
            $format_stylist_availabilities[User::find($user_id)->name][] =
                date('H:i:s', $open_date_time->getTimestamp())." - ".date('H:i:s', $close_date_time->getTimestamp());
        } else {
            foreach($raw_stylist_availabilities as $raw_stylist_availability) {
                $total_duration = "00:00:00";
                foreach($raw_stylist_availability['service_durations'] as $duration) {
                    $temp_time = array();
                    $time1 = explode(':', $duration);
                    $time2 = explode(':', $total_duration);
                    $temp_time[0] = $time1[0] + $time2[0];
                    $temp_time[1] = $time1[1] + $time2[1];
                    $temp_time[2] = $time1[2] + $time2[2];
                    $total_duration = implode(':', $temp_time);
                }

                $end_date_time = new \DateTime($raw_stylist_availability['start_date_time']);
                $start_date_time = new \DateTime($raw_stylist_availability['start_date_time']);
                $duration = explode(':', $total_duration);
                $end_date_time->modify("+{$duration[0]} hours");
                $end_date_time->modify("+{$duration[1]} minutes");
                $end_date_time->modify("+{$duration[2]} seconds");

                if($start_date_time > $open_date_time) {
                    $format_stylist_availabilities[$raw_stylist_availability['user']['name']][] =
                        date('H:i:s', $open_date_time->getTimestamp())." - ".date('H:i:s', $start_date_time->getTimestamp());
                    $open_date_time = $end_date_time;
                } else {
                    $open_date_time = $end_date_time;
                }
            }
            if($end_date_time < $close_date_time) {
                $format_stylist_availabilities[$raw_stylist_availability['user']['name']][] =
                    date('H:i:s', $end_date_time->getTimestamp())." - ".date('H:i:s', $close_date_time->getTimestamp());
            }
        }

        $default_stylist_availabilities = array();

        if(count($raw_stylist_availabilities) <= 0) {
            $default_stylist_availabilities[User::find($user_id)->name][] = "No Bookings Found";
        } else {
            foreach($raw_stylist_availabilities as $raw_stylist_availability) {
                $total_duration = "00:00:00";
                foreach($raw_stylist_availability['service_durations'] as $duration) {
                    $temp_time = array();
                    $time1 = explode(':', $duration);
                    $time2 = explode(':', $total_duration);
                    $temp_time[0] = $time1[0] + $time2[0];
                    $temp_time[1] = $time1[1] + $time2[1];
                    $temp_time[2] = $time1[2] + $time2[2];
                    $total_duration = implode(':', $temp_time);
                }

                $end_date_time = new \DateTime($raw_stylist_availability['start_date_time']);
                $start_date_time = new \DateTime($raw_stylist_availability['start_date_time']);
                $duration = explode(':', $total_duration);
                $end_date_time->modify("+{$duration[0]} hours");
                $end_date_time->modify("+{$duration[1]} minutes");
                $end_date_time->modify("+{$duration[2]} seconds");

                $default_stylist_availabilities[$raw_stylist_availability['user']['name']][] =
                    date('H:i:s', $start_date_time->getTimestamp())." - ".date('H:i:s', $end_date_time->getTimestamp());
            }
        }

        return array(
            'stylist_availabilities_raw' => $raw_stylist_availabilities,
            'stylist_availabilities_format_default' =>
                ($setting[0]->value == "1")?$default_stylist_availabilities:$format_stylist_availabilities,
        );
    }
}
