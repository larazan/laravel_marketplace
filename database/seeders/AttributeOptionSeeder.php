<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attribute_options')->insert([
            [
                'attribute_id' => 1,
                'name' => 'Hitam',
            ],
            [
                'attribute_id' => 1,
                'name' => 'Putih',
            ],
            [
                'attribute_id' => 2,
                'name' => 'Kecil',
            ],
            [
                'attribute_id' => 2,
                'name' => 'Sedang',
            ],
            [
                'attribute_id' => 2,
                'name' => 'Besar',
            ],
        ]);
    }
}
