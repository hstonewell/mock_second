<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Flynsarmy\CsvSeeder\CsvSeeder;

class ShopsTableSeeder extends csvSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function __construct()
    {
        $this->table = 'shops';
        $this->filename = base_path() . '/database/seeders/csvs/shops.csv';
    }

    public function run()
    {
        // Recommended when importing larger CSVs
        DB::disableQueryLog();

        // Uncomment the below to wipe the table clean before populating
        DB::table($this->table)->truncate();

        $csv = array_map('str_getcsv', file($this->filename));
        $header = array_shift($csv);

        foreach ($csv as $row) {
            $data = array_combine($header, $row);

            $area = DB::table('areas')->where('area_name',$data['area'])->first();
            $area_id = $area ? $area->id : null;

            $genre = DB::table('genres')->where('genre_name', $data['genre'])->first();
            $genre_id = $genre ? $genre->id : null;

            DB::table($this->table)->insert([
                'shop_name' => $data['shop_name'],
                'area_id' => $area_id,
                'genre_id' => $genre_id,
                'detail' => $data['detail'],
                'image' => $data['image'],
            ]);
        }
    }
}
