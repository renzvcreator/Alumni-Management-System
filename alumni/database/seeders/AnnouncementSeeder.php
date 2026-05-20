<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        if (! $admin) {
            $this->command->error('No admin user found. Run DatabaseSeeder first.');
            return;
        }

        $announcements = [
            [
                'title'   => 'Homecoming 2026 Registration Now Open',
                'content' => "Dear Alumni,\n\nWe are excited to announce that registration for the 2026 Homecoming Event is now officially open. This year's theme is 'Reconnect, Reminisce, Rejoice' and we are preparing a full day of activities, including a campus tour, a memorial mass for departed alumni, a class reunion lunch, and an evening gala.\n\nEarly-bird tickets are available until May 30. Please RSVP through the Events page of this portal to reserve your slot.\n\nWe look forward to welcoming you back home.",
                'created_at' => now()->subHours(2),
            ],
            [
                'title'   => 'New Alumni Portal — Tutorial Video Available',
                'content' => "We have published a short walkthrough video to help everyone navigate the new Alumni Portal. The video covers profile setup, sending messages, RSVPing to events, and using the directory to find batchmates.\n\nYou can access the video from the Help link in your profile dropdown. If you encounter any issues, please reach out to the Alumni Office.",
                'created_at' => now()->subDays(3),
            ],
            [
                'title'   => 'Job Fair 2026 — A Successful Turnout',
                'content' => "Thank you to everyone who participated in the recent Alumni Job Fair held last April 25. More than 40 companies took part, and 200+ alumni and graduating students attended.\n\nPhotos and a recap report will be uploaded soon. If your company is interested in sponsoring next year's fair, please contact the Career Development Office.",
                'created_at' => now()->subWeek(),
            ],
            [
                'title'   => 'Scholarship Endowment Drive — Pledge Your Support',
                'content' => "The Alumni Foundation is launching a new scholarship endowment drive to support deserving students from underprivileged communities. Our goal is to fund 50 full scholarships within the next two years.\n\nYou can pledge any amount through the Foundation's website. Every contribution, large or small, helps a future student attend our institution.",
                'created_at' => now()->subWeeks(2),
            ],
            [
                'title'   => 'Annual General Meeting — Save the Date',
                'content' => "The Annual General Meeting (AGM) of the Alumni Association will be held on June 15, 2026, at the University Auditorium from 2:00 PM to 5:00 PM. The agenda includes the year-in-review report, financial statements, election of new officers, and an open forum.\n\nAll active alumni are encouraged to attend. Proxies can be submitted through the Alumni Office until June 10.",
                'created_at' => now()->subWeeks(3),
            ],
            [
                'title'   => 'Mentorship Program — Mentors Needed',
                'content' => "Our Alumni Mentorship Program is looking for senior alumni who are willing to share their professional experience with graduating students and young alumni. Mentors are asked to commit to a minimum of one hour per month for six months.\n\nIf you are interested, please email the Alumni Office with your name, current position, and area of expertise.",
                'created_at' => now()->subMonth(),
            ],
            [
                'title'   => 'Library Access for Alumni — Now Available',
                'content' => "Good news! Alumni in good standing can now request library access cards that grant on-site borrowing and study privileges at the University Library. Cards are issued at the front desk upon presentation of a valid alumni ID.\n\nDigital journal access is also available — instructions are in the Help section of this portal.",
                'created_at' => now()->subMonths(2),
            ],
        ];

        foreach ($announcements as $a) {
            Announcement::updateOrCreate(
                ['title' => $a['title']],
                [
                    'admin_id'   => $admin->id,
                    'content'    => $a['content'],
                    'created_at' => $a['created_at'],
                    'updated_at' => $a['created_at'],
                ]
            );
        }

        $this->command->info('Seeded '.count($announcements).' announcements.');
    }
}
