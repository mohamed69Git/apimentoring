<?php

namespace Database\Seeders;

use App\Models\Formation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormationSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $formations = [
      [
        "id" => 1,
        "label" => "Developpement mobile Flutter",
        "plan" => "paid",
        "length" => 45,
        "level" => "beginner",
        "user_id" => 1
      ],
      [
        "id" => 2,
        "label" => "React and Laravel",
        "plan" => "free",
        "length" => 12,
        "level" => "confirmed",
        "user_id" => 1
      ],
      [
        "id" => 3,
        "label" => "Cloud et virtualisation",
        "plan" => "paid",
        "length" => 17,
        "level" => "beginner",
        "user_id" => 1
      ],
      [
        "id" => 4,
        "label" => "Base de donnee nouvelle generation",
        "plan" => "free",
        "length" => 21,
        "level" => "beginner",
        "user_id" => 1
      ],
      [
        "id" => 5,
        "label" => "Fouille de donnee",
        "plan" => "free",
        "length" => 19,
        "level" => "beginner",
        "user_id" => 1
      ],
      [
        "id" => 6,
        "label" => "Artificiel intelligence",
        "plan" => "free",
        "length" => 23,
        "level" => "beginner",
        "user_id" => 1
      ],
      [
        "id" => 7,
        "label" => "Automate et compilation",
        "plan" => "paid",
        "length" => 11,
        "level" => "beginner",
        "user_id" => 1
      ],
      [
        "id" => 8,
        "label" => "Genie et Architecture logiciel",
        "plan" => "paid",
        "length" => 12,
        "level" => "beginner",
        "user_id" => 1
      ]
    ];

    foreach ($formations as $formation) {
      Formation::create($formation);
    }
  }
}
