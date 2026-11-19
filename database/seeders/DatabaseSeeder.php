<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\College;
use App\Models\Course;
use App\Models\State;
use App\Models\ServicePackage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. States
        $states = [
            ['name' => 'Kerala'],
            ['name' => 'Karnataka'],
            ['name' => 'Tamil Nadu'],
            ['name' => 'Andhra Pradesh'],
            ['name' => 'Goa'],
        ];
        foreach ($states as $s) State::create($s);

        // 2. Courses
        $courses = [
            [
                'name' => 'MBBS',
                'slug' => 'mbbs',
                'description' => 'Bachelor of Medicine and Bachelor of Surgery',
                'level' => 'UG',
                'duration' => '5.5 Years'
            ],
            [
                'name' => 'BDS',
                'slug' => 'bds',
                'description' => 'Bachelor of Dental Surgery',
                'level' => 'UG',
                'duration' => '5 Years'
            ],
            [
                'name' => 'MD/MS',
                'slug' => 'md-ms',
                'description' => 'Doctor of Medicine / Master of Surgery',
                'level' => 'PG',
                'duration' => '3 Years'
            ]
        ];
        foreach ($courses as $c) Course::create($c);

        // 3. Colleges
        $colleges = [
            [
                'state_id' => 1,
                'college_type' => 0, // Govt
                'college_name' => 'Government Medical College, Thiruvananthapuram',
                'place' => 'Thiruvananthapuram, Kerala',
                'about_us' => 'Oldest medical college in Kerala, established in 1951.',
                'college_description' => 'A premier institute for medical education and research.',
                'courses' => 'MBBS, MD, MS',
                'year_of_inspection' => '2023',
                'is_active' => 0,
            ],
            [
                'state_id' => 2,
                'college_type' => 1, // Private
                'college_name' => 'St. John\'s Medical College',
                'place' => 'Bangalore, Karnataka',
                'about_us' => 'Top ranked private medical college in India.',
                'college_description' => 'Known for its excellent infrastructure and faculty.',
                'courses' => 'MBBS, MD, MS, Diploma',
                'year_of_inspection' => '2023',
                'is_active' => 0,
            ],
            [
                'state_id' => 3,
                'college_type' => 0, // Govt
                'college_name' => 'Madras Medical College',
                'place' => 'Chennai, Tamil Nadu',
                'about_us' => 'One of the oldest medical colleges in India.',
                'college_description' => 'Providing quality healthcare and education since 1835.',
                'courses' => 'MBBS, BDS, MD, MS',
                'year_of_inspection' => '2024',
                'is_active' => 0,
            ],
            [
                'state_id' => 1,
                'college_type' => 1, // Private
                'college_name' => 'Amrita School of Medicine',
                'place' => 'Kochi, Kerala',
                'about_us' => 'A fully integrated healthcare and educational institution.',
                'college_description' => 'Equipped with state-of-the-art facilities.',
                'courses' => 'MBBS, MD, MS, Super Specialty',
                'year_of_inspection' => '2022',
                'is_active' => 0,
            ],
            [
                'state_id' => 2,
                'college_type' => 0, // Govt
                'college_name' => 'Bangalore Medical College and Research Institute',
                'place' => 'Bangalore, Karnataka',
                'about_us' => 'Premier government institute in Karnataka.',
                'college_description' => 'Offers highly sought-after medical programs.',
                'courses' => 'MBBS, MD, MS',
                'year_of_inspection' => '2023',
                'is_active' => 0,
            ],
            [
                'state_id' => 3,
                'college_type' => 1, // Private
                'college_name' => 'Christian Medical College (CMC)',
                'place' => 'Vellore, Tamil Nadu',
                'about_us' => 'Globally renowned for healthcare and education.',
                'college_description' => 'A top choice for medical aspirants worldwide.',
                'courses' => 'MBBS, MD, MS, Allied Health',
                'year_of_inspection' => '2024',
                'is_active' => 0,
            ]
        ];
        foreach ($colleges as $c) College::create($c);
        
        // 4. Service Packages
        $packages = [
            [
                'name' => 'Silver Plan',
                'amount' => 50000,
                'description' => '<ul><li>Basic Counselling</li><li>Document Verification</li></ul>',
                'payment_button_link' => '#'
            ],
            [
                'name' => 'Gold Plan',
                'amount' => 75000,
                'description' => '<ul><li>Premium Counselling</li><li>Dedicated Agent</li><li>Choice Filling Assistance</li></ul>',
                'payment_button_link' => '#'
            ]
        ];
        foreach ($packages as $p) ServicePackage::create($p);
        
        echo "Database seeded successfully!\n";
    }
}
