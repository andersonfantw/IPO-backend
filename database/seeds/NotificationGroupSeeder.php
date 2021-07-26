<?php

use Illuminate\Database\Seeder;
use App\NotificationGroup;

class NotificationGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NotificationGroup::unguard();
        factory(NotificationGroup::class, 10)->create();
        NotificationGroup::reguard();
    }
}
