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
        DB::table('settings')->insert([
            'isadmin' => 1,
            'key' => 'Pre-booking Reminders',
            'help' => 'Number of days before reminder date to send the reminder',
            'value' => '2',
            'type' => 'number',
        ]);
    }
}
