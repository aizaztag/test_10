<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembersTableSeeder extends Seeder
{
    public function run()
    {


        //$this->call(AdminUserSeeder::class);
//        ini_set('memory_limit', '1024M');
//        Member::factory()->count(500000)->create();

        $totalRecords = 500000; // Total number of records to insert
        $batchSize = 1000; // Number of records to insert in each batch

        $batches = $totalRecords / $batchSize;

        for ($i = 0; $i < $batches; $i++) {
            Member::factory()->count($batchSize)->create();
        }

    }
}
