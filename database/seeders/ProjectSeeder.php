<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Faker\Generator as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $types = Type::all()->pluck('id');
        $types[] = null;

        for ($i = 0; $i < 50; $i++) {
            $type_id = $faker->randomElement($types);

            $project = new Project;
            $project->type_id = $type_id;
            $project->name = $faker->sentence(3);
            $project->description = $faker->paragraph();
            $project->link = Str::random(10);
            $project->slug = Str::slug($project->name);

            $project->save();
        }
    }
}