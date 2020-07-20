<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTable::class);
        $this->call(IconTableSeeder::class);
        $this->call(DistrictTableSeeder::class);
        $this->call(HotelTable::class);
        $this->call(ProjectTable::class);
        $this->call(WxUsersTableSeeder::class);
    }
}
