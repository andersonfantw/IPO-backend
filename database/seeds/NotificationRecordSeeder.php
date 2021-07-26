<?php

use Illuminate\Database\Seeder;
use App\NotificationRecord;

class NotificationRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NotificationRecord::unguard();
        factory(NotificationRecord::class, 100)->create();
        NotificationRecord::reguard();
    }
}
