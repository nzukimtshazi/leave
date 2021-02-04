<?php

use Illuminate\Database\Seeder;

class hoursWorkedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return;
        DB::table('hoursWorked')->delete();
        HoursWorked::create(array(
            'monday'         => '2020-01-04',
            'mondayHours'    => 8,
            'tuesday'        => '2020-01-04',
            'tuesdayHours'   => 8,
            'wednesday'      => '2020-01-04',
            'wednesdayHours' => 8,
            'thursday'       => '2020-01-04',
            'thursdayHours'  => 8,
            'friday'         => '2020-01-04',
            'fridayHours'    => 8,
            'saturday'       => '2020-01-04',
            'saturdayHours'  => 8,
            'sunday'         => '2020-01-04',
            'sundayHours'    => 8,
            'employee_id'    => '01',
        ));
    }
}
