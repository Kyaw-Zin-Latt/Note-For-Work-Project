<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\issue>
 */
class IssueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $projectId = Project::inRandomOrder()->pluck("id")->first();
        $teamId = Team::inRandomOrder()->pluck("id")->first();

        return [
            "name" => $this->faker->name,
            "description" => $this->faker->text(500),
            "project_id" => $projectId,
            "come_from_id" => $teamId,
            "added_user_id" => 1,
            "created_at" => $this->faker->dateTimeBetween("2018-01-01", "2022-12-30", "Asia/Yangon")
        ];
    }
}
