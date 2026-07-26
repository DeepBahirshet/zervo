<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Requirement;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // customers

        $customers = [
            ['name' => 'Rahul Patil', 'email' => 'rahul@example.com'],
            ['name' => 'Priya Deshmukh', 'email' => 'priya@example.com'],
            ['name' => 'Amit Kulkarni', 'email' => 'amit@example.com'],
            ['name' => 'Sneha Jadhav', 'email' => 'sneha@example.com'],
            ['name' => 'Rohit Pawar', 'email' => 'rohit@example.com'],
            ['name' => 'Neha Shinde', 'email' => 'neha@example.com'],
            ['name' => 'Kiran Chavan', 'email' => 'kiran@example.com'],
            ['name' => 'Pooja Joshi', 'email' => 'pooja@example.com'],
            ['name' => 'Sagar Patil', 'email' => 'sagar@example.com'],
            ['name' => 'Anjali More', 'email' => 'anjali@example.com'],
        ];

        $customerUsers = collect();

        foreach ($customers as $customer) {

            $customerUsers->push(
                User::create([
                    'name' => $customer['name'],
                    'email' => $customer['email'],
                    'phone' => fake()->numerify('98########'),
                    'password' => Hash::make('password'),
                    'role' => 'customer',
                ])
            );
        }


        // Providers

        $providers = [
            ['Mahesh Jadhav', 'Plumber'],
            ['Ganesh Patil', 'Electrician'],
            ['Santosh Shinde', 'Carpenter'],
            ['Ramesh More', 'Painter'],
            ['Nilesh Chavan', 'AC Technician'],
            ['Vishal Khot', 'CCTV Installer'],
            ['Pravin Salunkhe', 'RO Technician'],
            ['Akash Kadam', 'Interior Designer'],
            ['Deepak Powar', 'Home Cleaning'],
            ['Sunil Mane', 'Welder'],
            ['Ajinkya Nalawade', 'Tile Installer'],
            ['Sachin Kamble', 'Appliance Repair'],
            ['Tejas Ghorpade', 'Pest Control'],
            ['Yogesh Patil', 'Gardener'],
            ['Shubham Jagtap', 'Furniture Expert'],
            ['Swapnil Patil', 'Electrician'],
            ['Amol Khot', 'Painter'],
            ['Rakesh Chougule', 'Plumber'],
            ['Vikas Kadam', 'AC Technician'],
            ['Sandeep More', 'Carpenter'],
            ['Abhishek Jadhav', 'Electrician'],
            ['Ashish Patil', 'Plumber'],
            ['Nitin Powar', 'Painter'],
            ['Omkar Chavan', 'Gardener'],
            ['Akshay Mane', 'CCTV Installer'],
        ];

        $providerUsers = collect();

        foreach ($providers as $index => $provider) {

            $providerUsers->push(
                User::create([
                    'name' => $provider[0],
                    'email' => 'provider' . ($index + 1) . '@example.com',
                    'phone' => fake()->numerify('97########'),
                    'password' => Hash::make('password'),
                    'role' => 'provider',
                ])
            );
        }

        // requirements

        $requirements = [

            [
                'title' => 'Kitchen Sink Leakage Repair',
                'description' => 'Need an experienced plumber to repair a leaking kitchen sink and replace damaged pipe if necessary.',
                'category' => 'Plumbing',
                'budget' => 1200,
            ],

            [
                'title' => '2 BHK Electrical Wiring',
                'description' => 'Complete electrical wiring for a newly renovated apartment.',
                'category' => 'Electrical',
                'budget' => 8500,
            ],

            [
                'title' => 'AC Annual Service',
                'description' => 'Need servicing for two split AC units before summer.',
                'category' => 'AC Repair',
                'budget' => 1800,
            ],

            [
                'title' => 'Modular Wardrobe',
                'description' => 'Need a carpenter to build a custom modular wardrobe.',
                'category' => 'Carpentry',
                'budget' => 28000,
            ],

            [
                'title' => 'Interior Painting',
                'description' => 'Paint complete interior of a 2 BHK apartment.',
                'category' => 'Painting',
                'budget' => 25000,
            ],

            [
                'title' => 'Install CCTV Cameras',
                'description' => 'Install 6 CCTV cameras in a retail shop.',
                'category' => 'Security',
                'budget' => 14000,
            ],

            [
                'title' => 'RO Installation',
                'description' => 'Install Kent RO purifier with plumbing connection.',
                'category' => 'RO Service',
                'budget' => 900,
            ],

            [
                'title' => 'Deep Home Cleaning',
                'description' => 'Deep cleaning service for a newly purchased flat.',
                'category' => 'Cleaning',
                'budget' => 3500,
            ],

            [
                'title' => 'Bathroom Renovation',
                'description' => 'Need renovation of bathroom including plumbing and tiles.',
                'category' => 'Renovation',
                'budget' => 45000,
            ],

            [
                'title' => 'Monthly Garden Maintenance',
                'description' => 'Looking for monthly gardening and lawn maintenance.',
                'category' => 'Gardening',
                'budget' => 2500,
            ],

        ];

        foreach ($requirements as $requirement) {

            Requirement::create([
                'user_id' => $customerUsers->random()->id,

                'title' => $requirement['title'],

                'description' => $requirement['description'],

                'budget' => $requirement['budget'],

                'location' => fake()->randomElement([
                    'Kolhapur',
                    'Pune',
                    'Sangli',
                    'Satara',
                    'Mumbai'
                ]),

                'status' => 'approved',

                'work_status' => 'open',
            ]);
        }

        // applications

        $coverMessages = [

            "I have over 8 years of experience in this field. I always focus on quality work, timely completion, and customer satisfaction.",

            "Professional service with quality materials and transparent pricing. I can start immediately and complete the work efficiently.",

            "I have completed similar projects for residential and commercial clients. Looking forward to working with you.",

            "Experienced technician with all required tools. I provide clean work and proper after-service support.",

            "Affordable pricing without compromising quality. Available this week and can complete the work within the estimated timeline.",

            "I specialize in this type of work and can provide durable and reliable solutions with workmanship warranty.",

            "Experienced professional with 6+ years of field experience. I believe in honest pricing and quality service.",

            "I have successfully completed many similar projects. Customer satisfaction and timely delivery are always my priorities.",

            "Certified technician with expertise in residential maintenance work. Happy to discuss your exact requirements before starting.",

            "I can inspect the site first and provide the best possible solution based on your requirements.",

        ];

        $requirements = Requirement::all();

        foreach ($requirements as $requirement) {

            $providers = $providerUsers->random(rand(4, 8));

            foreach ($providers as $provider) {

                Application::create([

                    'requirement_id' => $requirement->id,

                    'user_id' => $provider->id,

                    'quoted_price' => max(
                        500,
                        $requirement->budget + rand(-800, 1500)
                    ),

                    'estimated_days' => rand(1, 7),

                    'message' => fake()->randomElement($coverMessages),

                    'status' => 'pending',

                ]);

            }

        }
    }
}
