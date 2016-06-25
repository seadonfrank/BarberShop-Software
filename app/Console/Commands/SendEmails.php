<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Log;

use App\Customer;

use App\User;

use App\Booking;

use Mail;

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
        //Log::info("Sending Booking Reminder Emails");

        $customers = DB::table('customers')
            ->where('send_reminders', '=', 1)
            ->get();

        foreach($customers as $customer) {
            if(date("Y-m-d H:i:s") >= $customer->next_reminder) {
                $customer->body = "This is to remind you that, You have to book you next appointment at barbershop.";
                $customer->opt_out = "opt_out_customer/".$customer->id;

                Mail::send('emails.reminder', ['customer' => $customer], function ($m) use ($customer) {
                    $m->to($customer->email_address, $customer->name)->subject('Your Next Booking Reminder form Barbershop!');
                });

                $cust = Customer::find($customer->id);
                $cust->send_reminders = 0;
                $cust->save();
            }
        }

        //Log::info("Sending Appointment Reminder Emails");

        $earliest_date_time = new \DateTime(date("Y-m-d H:i:s"));
        $earliest_date_time->modify("-30 minutes");
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
            $value['customer']->body = "This is to remind that, you have an up-coming appointment at barbershop
            with ".$value['user']->name."(".$value['user']->email.") at ".$value['start_date_time']." which was booked
            on ".$value['created_at'].".";
            $value['customer']->opt_out = "";

            Mail::send('emails.reminder', ['customer' => $value['customer']], function ($m) use ($value) {
                $m->to($value['customer']->email_address, $value['customer']->name)->subject('Your Up-coming Appointment Reminder form Barbershop!');
            });

            $book = Booking::find($key);
            $book->send_reminders = 0;
            $book->save();
        }
    }
}