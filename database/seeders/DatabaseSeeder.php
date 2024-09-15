<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

     public function run(): void
     {
      
         // Create admin user
         \App\Models\User::factory()->create([
             'name' => 'Admin User',
             'email' => 'admin@example.com',
             'password' => bcrypt('password'),
             
         ]);
 
         // Create customer user
         \App\Models\User::factory()->create([
             'name' => 'Customer User',
             'email' => 'customer@example.com',
             'password' => bcrypt('password'),
           
         ]);
 

    {
        $this->call([
            CategoryProductSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
}