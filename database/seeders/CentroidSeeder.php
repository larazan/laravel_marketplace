<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CentroidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('centroids')->insert([
            [
                'distancecentroid1' => 2,
                'distancecentroid2' => 1,
                'distancecentroid3' => 1, 
                'distancecentroid4' => 2,
                'distancecentroid5' => 1,
                'cluster' => 'C1'
            ],
            [
                'distancecentroid1' => 2,
                'distancecentroid2' => 3,
                'distancecentroid3' => 1, 
                'distancecentroid4' => 4,
                'distancecentroid5' => 1,
                'cluster' => 'C2'
            ],
            [
                'distancecentroid1' => 4,
                'distancecentroid2' => 3,
                'distancecentroid3' => 2, 
                'distancecentroid4' => 3,
                'distancecentroid5' => 3,
                'cluster' => 'C3'
            ],
            [
                'distancecentroid1' => 4,
                'distancecentroid2' => 3,
                'distancecentroid3' => 1, 
                'distancecentroid4' => 4,
                'distancecentroid5' => 2,
                'cluster' => 'C4'
            ],
            [
                'distancecentroid1' => 1,
                'distancecentroid2' => 2,
                'distancecentroid3' => 1, 
                'distancecentroid4' => 2,
                'distancecentroid5' => 4,
                'cluster' => 'C5'
            ],
        ]);
    }
}
