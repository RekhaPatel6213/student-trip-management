<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        $fromMail = 'no-reply@scicon.com' ;//env('FROM_MAIL');
        
        DB::table('email_templates')->truncate();
        
        DB::table('email_templates')->insert([
            [
                'name' => 'Pre-Schedule Trip Request',
                'subject' => 'Pre-Schedule Trip Request send by SCICON',
                'from_email' => $fromMail,
                'message' => '<p>Dear {first_name} {last_name}, {schoolName},<br></p><p><b>PLEASE PRE-SCHEDULE YOUR TRIP/S ON OR BEFORE May 31</b></p><p><b>Sixth Grade Week Trips:</b> Please review your 6th grade enrollment for next year when scheduling. Schedule no more than three classes (or up to 77 students) for any given date for sixth grade week trips. Your district will be billed for 97% of the sixth grade students scheduled or the actual attendance (whichever is greater.)<br></p><p><b>Fifth Grade Day Trips:</b> Please review your 5th grade enrollment for next year when scheduling.<br>You may request your 1st, 2nd, 3rd and 4th choice for day trips.<br></p><p>We look forward to seeing your students next year!<br></p><p>Dianne Shew,<br>SCICON Director<br><a href="https://www.tularecountytreasures.org/scicon.html">tularecountytreasures.org/scicon.html</a><br></p><p>{dayLink}{weekLink}</p>',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Day Trip Confirmed',
                'subject' => 'Your day trips to SCICON are confirmed!',
                'from_email' => $fromMail,
                'message' => '<p>Dear {first_name} {last_name},</p><p>you are getting this notification because your day trip/s to SCICON were approved and the dates are assigned in our system.</p><p><br>Sincerely,<br>SCICON</p>',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Week Trip Confirmed',
                'subject' => 'Your week trips to SCICON are confirmed!',
                'from_email' => $fromMail,
                'message' => '<p>Dear {first_name} {last_name},</p><p>you are getting this notification because your day trip/s to SCICON were confirmed.<br></p><p>Next steps:</p><ol><li>Please review and process the bill.</li><li>Once the bill is paid, please send this link to the teachers so that they could fill out the information about the students:<br><br>{links}</li></ol><p><br>Sincerely,<br>SCICON</p>',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Student Information',
                'subject' => 'Please confirm the number of students',
                'from_email' => $fromMail,
                'message' => '<p>Dear {name},</p><p>you are getting this notification because your week trip/s to SCICON were approved and the dates are assigned in our system.</p><p>{clickHere} to open register student information.<p><p><br>Sincerely,<br>SCICON</p>',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Meal Information',
                'subject' => 'Please confirm the students meal information',
                'from_email' => $fromMail,
                'message' => '<p>Dear {name},</p><p>you are getting this notification because your week trip/s to SCICON were approved and the dates are assigned in our system.</p><p>{clickHere} to open register student meal information.<p><p><br>Sincerely,<br>SCICON</p>',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Meal Information Success',
                'subject' => 'Students meal information submitted successfully',
                'from_email' => $fromMail,
                'message' => '<p>Dear {name},</p><p>you are getting this notification because student meal information submitted successfully.</p><p><br>Sincerely,<br>SCICON</p>',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Bill Information',
                'subject' => 'Your bill for {days} day week trip, {classes} classes, {date}',
                'from_email' => $fromMail,
                'message' => '<p>Dear {first_name} {last_name},</p><p>you are getting this notification because your day trip/s to SCICON were approved and the dates are assigned in our system.</p><p><br>Sincerely,<br>SCICON</p>',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
