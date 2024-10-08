<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $this->call(GenresTableSeeder::class);
        $this->call(AreasTableSeeder::class);
        $this->call(ShopsTableSeeder::class);
        Schema::enableForeignKeyConstraints();
    }
}
