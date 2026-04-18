<?php

class BloodRequestFactory extends Factory
{
    public function definition(): array
    {
        return [
            'urgent' => $this->faker->boolean(20), 
            'bloodgroup' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'location' => $this->faker->address(),
            'datetime' => $this->faker->dateTimeBetween('now', '+1 week'),
            'noofbags' => $this->faker->numberBetween(1, 5),
            'patienttype' => $this->faker->randomElement(['Critical', 'Stable', 'Post-Surgery']),
            'patientage' => $this->faker->numberBetween(1, 90),
            'patientgender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'contactno' => $this->faker->phoneNumber(),
        ];
    }
}
