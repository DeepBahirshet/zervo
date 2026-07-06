<?php

namespace Database\Factories;

use App\Models\Requirement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Requirement>
 */
class RequirementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
  public function definition(): array
{
    $requirements = [
        [
            'title' => 'Need an Electrician',
            'description' => 'Looking for a licensed electrician to install new wiring in a 2 BHK apartment.',
        ],
        [
            'title' => 'House Cleaning Service',
            'description' => 'Need deep cleaning for a 3 BHK house this weekend.',
        ],
        [
            'title' => 'Plumber Required',
            'description' => 'Kitchen sink is leaking and needs immediate repair.',
        ],
        [
            'title' => 'AC Repair Service',
            'description' => 'Split AC is not cooling properly. Looking for an experienced technician.',
        ],
        [
            'title' => 'Painter Needed',
            'description' => 'Need interior painting for a newly purchased apartment.',
        ],
        [
            'title' => 'Carpenter Required',
            'description' => 'Need a carpenter to assemble wardrobes and fix kitchen cabinets.',
        ],
        [
            'title' => 'Home Shifting Service',
            'description' => 'Need movers and packers for shifting household items within the city.',
        ],
        [
            'title' => 'Pest Control Service',
            'description' => 'Looking for termite treatment for a residential property.',
        ],
    ];

    $requirement = fake()->randomElement($requirements);

    return [
        'user_id' => User::inRandomOrder()->value('id'),
        'title' => $requirement['title'],
        'description' => $requirement['description'],
        'budget' => fake()->numberBetween(1000, 25000),
        'location' => fake()->city(),
        'status' => 'open',
    ];
}
}
