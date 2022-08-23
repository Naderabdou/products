<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        User::create([
            'name'=>'user',
            'email'=>'user@gmail.com',
            'password'=>Hash::make('123456789'),

        ]);
        Product::create([
            'name'=>'product',
            'desc'=>'drdrtdrtdtrdtr',
            'price'=>'220',
            'img'=>'splash/Aei1bRQuPKWpXsQ0B5tDGbCPmh1JQ04sTXKzGWT0.png'
        ]);



    }

}
