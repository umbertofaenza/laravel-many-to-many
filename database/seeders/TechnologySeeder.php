<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['html', 'css', 'bootstrap', 'js', 'vue', 'php', 'laravel'];

        foreach ($names as $name) {
            $technology = new Technology();
            $technology->name = $name;
            $technology->save();
        }
    }
}
