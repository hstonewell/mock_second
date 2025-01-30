<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Flynsarmy\CsvSeeder\CsvSeeder;

class AreasTableSeeder extends CsvSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'area_name' => '東京都'
        ];
        DB::table('areas')->insert($param);
        $param = [
            'area_name' => '大阪府'
        ];
        DB::table('areas')->insert($param);
        $param = [
            'area_name' => '福岡県'
        ];
    }
}
