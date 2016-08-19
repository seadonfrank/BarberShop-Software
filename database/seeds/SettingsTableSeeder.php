<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        /*DB::table('settings')->insert([
            'isadmin' => 1,
            'key' => 'Pre-booking Reminders',
            'help' => 'Number of days before reminder date to send the reminder. Default : 2',
            'value' => '2',
            'type' => 'number',
        ]);
        DB::table('settings')->insert([
            'isadmin' => 1,
            'key' => 'Show Stylist Booking details on the New Bookings',
            'help' => 'If checked, it would display the stylist list based on the booked slots else on the available slots. Default : checked',
            'value' => '1',
            'type' => 'checkbox',
        ]);
        DB::table('settings')->insert([
            'isadmin' => 1,
            'key' => 'Start Time on a Working Day',
            'help' => 'Time at which the Stylist would Start his/her work. It should be 24 hours format only. Default : 9:00',
            'value' => '9:00',
            'type' => 'text',
        ]);
        DB::table('settings')->insert([
            'isadmin' => 1,
            'key' => 'End Time on a Working Day',
            'help' => 'Time at which the Stylist would End his/her work It should be 24 hours format only. Default : 18:00',
            'value' => '18:00',
            'type' => 'text',
        ]);*/
        DB::table('settings')->insert([
            'isadmin' => 1,
            'key' => 'Business Name',
            'help' => 'Name of the Business. Default : BarberShop',
            'value' => 'BarberShop',
            'type' => 'text',
        ]);
        DB::table('settings')->insert([
            'isadmin' => 1,
            'key' => 'Business Contact number',
            'help' => 'Contact Number of the Business. Default : 0000000000',
            'value' => '0000000000',
            'type' => 'text',
        ]);
    }
}
