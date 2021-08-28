<?php

use Illuminate\Database\Seeder;

class RunningTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('running_texts')->insertGetId(
            ['text' => 'Selamat Datang di Aplikasi CMS Agrokimia', 'created_at' => date('Y-m-d'), 'updated_at' => date('Y-m-d')]
        );
    }
}
