<?php

namespace Database\Seeders;

use App\Models\Cargo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            'In Transit...',
            'In Storage...',
            'Received'
        ];
        // Cargo::factory()->count(50)->make();
        // \QrCode::size(100)->format('svg')->generate('name','/'. 'name' .'.svg');
        $faker = Faker::create();
        foreach (range(1,10) as $value) {
            DB::table('cargos')->insert([
                'name' => $faker->name,
                'cargo_code' => strtoupper(Str::random(10)),
                'cargo_status'  => $status[rand(0,2)],
                'cargo_description'  => $faker->name,
                'official_address'  => $faker->city,
                'contact_person' => $faker->name
            ]);
        }
        User::create([
            'name' => 'admin',
            'address' => Str::random(20),
            'email' => 'admin@admin.com',
            'password' => bcrypt('password')
        ]);

    }
}
