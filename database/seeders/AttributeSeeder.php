<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attributes')->insert([
            [
                'name' => 'Warna',
                'code' => 'color',
                'type' => 'select',
                'is_unique' => true,
                'is_filterable' => true,
                'is_configurable' => true,
            ],
            [
                'name' => 'Ukuran',
                'code' => 'size',
                'type' => 'select',
                'is_unique' => true,
                'is_filterable' => true,
                'is_configurable' => true,
            ],
        ]);
    }
}
