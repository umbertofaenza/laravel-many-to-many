<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Front-end', 'Back-end', 'Full-stack'];

        foreach ($names as $name) {
            $type = new Type();
            $type->name = $name;
            $type->save();
        }
    }
}
