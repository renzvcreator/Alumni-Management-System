<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        // Create a shared sample verification document used by pending accounts.
        if (! Storage::disk('public')->exists('verification/sample-verification.txt')) {
            Storage::disk('public')->put(
                'verification/sample-verification.txt',
                "SAMPLE VERIFICATION DOCUMENT\n".
                "Issued by: ABC University\n".
                "Type: Certificate of Completion / School ID\n".
                "(This is a placeholder used by the demo seeder. to view )\n"
            );
        }
        $sampleDocPath = Storage::url('verification/sample-verification.txt');

        $alumni = [
            ['Juan',     'Santos',    'Cruz',      2018, 'Software Engineer',         'Technology',     'Male'],
            ['Maria',    'Reyes',     'Dela Cruz', 2019, 'Marketing Manager',         'Advertising',    'Female'],
            ['Jose',     'Garcia',    'Lim',       2017, 'Civil Engineer',            'Construction',   'Male'],
            ['Anna',     'Cruz',      'Tan',       2020, 'Registered Nurse',          'Healthcare',     'Female'],
            ['Mark',     'Bautista',  'Sy',        2016, 'Accountant',                'Finance',        'Male'],
            ['Liza',     'Mendoza',   'Gonzales',  2021, 'Graphic Designer',          'Creative Arts',  'Female'],
            ['Carlo',    'Aquino',    'Ramos',     2015, 'Project Manager',           'IT Services',    'Male'],
            ['Sofia',    'Torres',    'Castro',    2022, 'Teacher',                   'Education',      'Female'],
            ['Daniel',   'Lopez',     'Hernandez', 2019, 'Mechanical Engineer',       'Manufacturing',  'Male'],
            ['Kim',      'Villanueva','Ocampo',    2020, 'Data Analyst',              'Technology',     'Female'],
            ['Paolo',    'Navarro',   'Domingo',   2018, 'Web Developer',             'Technology',     'Male'],
            ['Rachel',   'Salazar',   'Pascual',   2017, 'Human Resource Officer',    'Corporate',      'Female'],
            ['Miguel',   'Fernandez', 'Aguilar',   2014, 'Architect',                 'Construction',   'Male'],
            ['Bea',      'Rivera',    'Manalo',    2023, 'Content Writer',            'Media',          'Female'],
            ['Allan',    'Soriano',   'Velasco',   2016, 'Network Engineer',          'Telecom',        'Male'],
            ['Trisha',   'Diaz',      'Esguerra',  2021, 'UI/UX Designer',            'Technology',     'Female'],
            ['Ryan',     'Castillo',  'Bernardo',  2015, 'Sales Manager',             'Retail',         'Male'],
            ['Camille',  'Pangilinan','Tolentino', 2022, 'Pharmacist',                'Healthcare',     'Female'],
            ['Jericho',  'Ramos',     'Reyes',     2020, 'Police Officer',            'Government',     'Male'],
            ['Patricia', 'Tan',       'Yu',        2019, 'Bank Officer',              'Banking',        'Female'],
        ];

        foreach ($alumni as [$first, $middle, $last, $year, $job, $industry, $gender]) {
            $email = strtolower(
                preg_replace('/[^a-z]/', '', strtolower($first)).'.'.
                preg_replace('/[^a-z]/', '', strtolower($last)).
                '@alumni.test'
            );

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name'              => $first.' '.$last,
                    'password'          => Hash::make('password'),
                    'role'              => 'alumni',
                    'status'            => 'approved',
                    'email_verified_at' => now(),
                ]
            );

            Profile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'first_name'      => $first,
                    'middle_name'     => $middle,
                    'last_name'       => $last,
                    'graduation_year' => $year,
                    'current_job'     => $job,
                    'industry'        => $industry,
                    'contact_number'  => '09'.random_int(100000000, 999999999),
                    'bio'             => "Class of {$year}. Currently working as a {$job} in the {$industry} industry.",
                ]
            );
        }

        // -----------------------------------------------------------------
        // Pending alumni (waiting for admin approval).
        // These appear on the admin dashboard "Pending Approvals" table.
        // -----------------------------------------------------------------
        $pending = [
            ['Andrei',  'Magno',     'Villar',    2023, 'Junior Developer',     'Technology'],
            ['Bianca',  'Cortez',    'Lazaro',    2024, 'Marketing Associate',  'Advertising'],
            ['Clarence','Padilla',   'Ortega',    2022, 'Operations Assistant', 'Logistics'],
            ['Diane',   'Robles',    'Magbanua',  2023, 'Junior Accountant',    'Finance'],
            ['Enrique', 'Salonga',   'Yulo',      2024, 'IT Support Staff',     'Technology'],
        ];

        foreach ($pending as [$first, $middle, $last, $year, $job, $industry]) {
            $email = strtolower(
                preg_replace('/[^a-z]/', '', strtolower($first)).'.'.
                preg_replace('/[^a-z]/', '', strtolower($last)).
                '@alumni.test'
            );

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name'                       => $first.' '.$last,
                    'password'                   => Hash::make('password'),
                    'role'                       => 'alumni',
                    'status'                     => 'pending',
                    'email_verified_at'          => now(),
                    'verification_document_path' => $sampleDocPath,
                ]
            );

            Profile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'first_name'      => $first,
                    'middle_name'     => $middle,
                    'last_name'       => $last,
                    'graduation_year' => $year,
                    'current_job'     => $job,
                    'industry'        => $industry,
                    'contact_number'  => '09'.random_int(100000000, 999999999),
                    'bio'             => "Class of {$year}. Pending verification.",
                ]
            );
        }

        // -----------------------------------------------------------------
        // Blocked alumni (previously approved but later blocked).
        // -----------------------------------------------------------------
        $blocked = [
            ['Franco',  'Aguinaldo','Reyes',     2018, 'Customer Service Rep', 'BPO'],
            ['Gianna',  'Macaraeg', 'De Leon',   2017, 'Freelance Designer',   'Creative Arts'],
            ['Hector',  'Buenaflor','Estrada',   2019, 'Driver',               'Transport'],
        ];

        foreach ($blocked as [$first, $middle, $last, $year, $job, $industry]) {
            $email = strtolower(
                preg_replace('/[^a-z]/', '', strtolower($first)).'.'.
                preg_replace('/[^a-z]/', '', strtolower($last)).
                '@alumni.test'
            );

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name'              => $first.' '.$last,
                    'password'          => Hash::make('password'),
                    'role'              => 'alumni',
                    'status'            => 'blocked',
                    'email_verified_at' => now(),
                ]
            );

            Profile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'first_name'      => $first,
                    'middle_name'     => $middle,
                    'last_name'       => $last,
                    'graduation_year' => $year,
                    'current_job'     => $job,
                    'industry'        => $industry,
                    'contact_number'  => '09'.random_int(100000000, 999999999),
                    'bio'             => "Class of {$year}. Account currently blocked.",
                ]
            );
        }

        $this->command->info('Seeded '.count($alumni).' approved, '.count($pending).' pending, '.count($blocked).' blocked alumni. Password for all accounts: password');
    }
}
