<?php

namespace Database\Seeders;

use App\Models\Teams;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sites = [
            [
                'name' => 'Draw',
                'name_ru' => 'Ничья',
                'alter_name' => 'Матч закончился с равным счётом',
                'logo' => '/logos/draw.png',
            ]

        ];

        foreach ($sites as $site) {
            Teams::updateOrCreate($site);
        }
    }
}
