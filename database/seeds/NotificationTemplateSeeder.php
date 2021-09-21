<?php

use Illuminate\Database\Seeder;
use App\Models\NotificationTemplate;

class NotificationTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NotificationTemplate::unguard();
        factory(NotificationTemplate::class, 2)->create();
        NotificationTemplate::reguard();
    }
}
