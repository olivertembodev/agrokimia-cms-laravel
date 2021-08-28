<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(TipeTaskSeeder::class);
        $this->call(TipeUserSeeder::class);
        $this->call(Aktifitasseeder::class);
        // $this->call(TransaksiSeed::class);
        $this->call(RunningTextSeeder::class);
        $this->call(MetodePembayaranSeeder::class);
        $this->call(KiosSeeder::class);
        $this->call(DetailTransaksiTableSeeder::class);
        // $this->call(ProductSeeder::class);
        // $this->call(StatusRewardSeed::class);
        // $this->call(TipePengirimanSeeder::class);
        // $this->call(StatusTransaksiSeeder::class);
    }
}
