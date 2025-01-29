<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;
use App\Models\Shop;
use App\Models\Review;

use Faker\Factory as Faker;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = User::role('user')->get();
        $shops = Shop::all();

        foreach($users as $user) {
            $shops->random(5)->each(function ($shop) use ($user, $faker) {
                Review::create([
                    'user_id' => $user->id,
                    'shop_id' => $shop->id,
                    'rating' => $faker->numberBetween(1, 5),
                    'comment' => $faker->realText(),
                    'image' => asset('img/review_sample.jpg'),
                ]);
            });
        }
    }
}
