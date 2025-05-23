<?php

namespace Modules\Recruitment\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Recruitment\Models\JobOpening;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Modules\Recruitment\Models\JobOpening>
 */
class JobOpeningFactory extends Factory
{
    protected $model = JobOpening::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph,
            'experience_required' => $this->faker->randomElement(['0-1', '2-5', '5+']),
            'required_skills' => json_encode($this->faker->words(5)),
            'education_level' => $this->faker->randomElement(['Bachelor', 'Master', 'PhD']),
            'degree' => $this->faker->word,
            'status' => $this->faker->randomElement(['open', 'closed', 'pending']),
            'application_deadline' => $this->faker->dateTimeBetween('+1 week', '+2 months'),
            'user_id' => 1,
        ];
    }
}
