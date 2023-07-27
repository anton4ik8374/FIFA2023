<?php

namespace Database\Seeders;

use App\Models\JobImport;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class JobImportSeeder extends Seeder
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
                'site' => 'stavka.tv',
                'name' => 'Кубок России',
                'slug_league' => 'russia-russian-cup',
                'actual' => true,
            ],
            [
                'site' => 'olbg.com',
                'name' => 'Английская лига',
                'slug_league' => '/UK/1',
                'actual' => true,
            ],

        ];

        foreach ($sites as $site) {
            JobImport::updateOrCreate($site);
        }
    }
}
