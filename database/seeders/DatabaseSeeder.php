<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        DB::table('governorates')->insert([
            'name' => 'تجريبى',
        ]);

         \App\Models\User::factory()->create([
             'name' => 'Admin',
             'mobile' => '01098646136',
         ]);

        DB::table('clients')->insert([
            'name' => 'تجريبى',
            'mobile' => '01098646130',
            'governorate_id' => 1,
        ]);

        DB::table('vendors')->insert([
            'name' => 'تجريبى',
            'mobile' => '01098646130',
        ]);

        DB::table('categories')->insert([
            'name' => 'تجريبى',
        ]);

        DB::table('brands')->insert([
            'name' => 'تجريبى',
        ]);

        DB::table('stocks')->insert([
            'name' => 'تجريبى',
        ]);

        DB::table('banks')->insert([
            'name' => 'تجريبى',
        ]);

        DB::table('expenses')->insert([
            'name' => 'تجريبى',
        ]);

        DB::table('methods')->insert([
            'name' => 'تجريبى',
        ]);

    }
}
