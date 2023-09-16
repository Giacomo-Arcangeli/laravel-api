<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator;
use Illuminate\Support\Facades\Storage;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker): void
    {
        Storage::makeDirectory('project_covers');

        for ($i = 0; $i < 8; $i++) {
            $project = new Project();

            $project->title = $faker->sentence(3);
            // $project->cover = Storage::putFile('project_covers', $faker->image(storage_path('app/public/project_covers'), 250, 250));
            $project->description = $faker->paragraphs(5, true);

            $project->save();
        }
    }
}
