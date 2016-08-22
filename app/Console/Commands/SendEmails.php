<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Customer;
use App\Booking;
use App\Setting;
use App\User;
use Mail;
use Log;
use DB;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending Booking & Appointment Reminder Emails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $business['name'] = Setting::find(5)->value;
        $business['contact_number'] = Setting::find(6)->value;

        //Log::info("Sending Booking Reminder Emails"); // Re-Booking

        $customers = DB::table('customers')
            ->where('send_reminders', '=', 1)
            ->get();

        foreach($customers as $customer) {
            if(date("Y-m-d H:i:s") >= $customer->next_reminder) {
                //$customer->opt_out = "opt_out_customer/".$customer->id;
                $customer->opt_out = "";

                $booking = DB::table('booking_service')
                    ->join('bookings', 'bookings.id', '=', 'booking_service.booking_id')
                    ->where('bookings.customer_id', '=', $customer->id)
                    ->orderBy('booking_service.start_date_time', 'desc')
                    ->first();

                $data['customer'] = $customer;
                $data['business'] = $business;
                if(isset($booking)) {
                    $data['booking'] = $booking;
                    $date = new \DateTime($booking->start_date_time);
                    $data['NoOfWeeks'] = $this->weeks_past(date('d/m/Y', $date->getTimestamp()));
                }

                Mail::send('emails.re_booking_reminder', ['data' => $data], function ($m) use ($customer, $business) {
                    $m->to($customer->email_address, $customer->name)->subject('Your Next Booking Reminder from '.$business['name']);
                });

                $cust = Customer::find($customer->id);
                $cust->send_reminders = 0;
                $cust->save();
            }
        }

        //Log::info("Sending Appointment Reminder Emails"); // Pre-Booking

        $setting = Setting::find(1);
        $earliest_date_time = new \DateTime(date("Y-m-d H:i:s"));
        $earliest_date_time->modify("-".$setting->value*(24*60)." minutes");
        $bookings = DB::table('booking_service')
            ->join('bookings', 'bookings.id', '=', 'booking_service.booking_id')
            ->where('bookings.send_reminders', '=', 1)
            ->where('bookings.status', '=', 'Finalised')
            ->whereRaw('DATE(booking_service.start_date_time) > "'.date('Y-m-d H:i:s', $earliest_date_time->getTimestamp()).'"')
            ->get();

        $temp_bookings = array();
        foreach($bookings as $booking) {
            $temp_bookings[$booking->booking_id]['created_at'] = $booking->created_at;
            $temp_bookings[$booking->booking_id]['start_date_time'] = $booking->start_date_time;
            $temp_bookings[$booking->booking_id]['user'] = User::find($booking->user_id);
            $temp_bookings[$booking->booking_id]['customer'] = Customer::find($booking->customer_id);
        }

        foreach($temp_bookings as $key=>$value) {
            $data['booking'] = $value;
            $data['business'] = $business;
            $data['NoOfDays'] = $setting->value;

            Mail::send('emails.pre_booking_reminder', ['data' => $data], function ($m) use ($business, $value) {
                $m->to($value['customer']->email_address, $value['customer']->name)->subject('Your Up-coming Appointment Reminder from '.$business['name']);
            });

            $book = Booking::find($key);
            $book->send_reminders = 0;
            $book->save();
        }
    }

    public function weeks_past($date){
        $start_date = strtotime($date);
        $end_date = strtotime(date("d/m/Y"));

        $start_week = date('W', $start_date);
        $end_week = date('W', $end_date);

        $start_year = date('Y', $start_date);
        $end_year = date('Y', $end_date);
        $years = $end_year-$start_year;

        $weeks_past = 0;
        if($years == 0){
            $weeks_past = $end_week-$start_week+1;
        }
        if($years == 1){
            $weeks_past = (52-$start_week+1)+$end_week;
        }
        if($years > 1){
            $weeks_past = (52-$start_week+1)+$end_week+($years*52);
        }

        return $weeks_past;
    }
}