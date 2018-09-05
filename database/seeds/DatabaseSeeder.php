<?php

use Illuminate\Database\Seeder;
use App\Item;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Item::class, 15)->create();
        factory(User::class)->create();
    }
}
