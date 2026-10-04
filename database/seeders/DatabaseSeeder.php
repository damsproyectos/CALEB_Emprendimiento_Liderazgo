<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Category::firstOrCreate(['name' => 'Tecnología y Software'], ['slug' => 'tecnologia-y-software', 'icon' => 'mdi-laptop']);
        \App\Models\Category::firstOrCreate(['name' => 'Servicios Profesionales'], ['slug' => 'servicios-profesionales', 'icon' => 'mdi-briefcase']);
        \App\Models\Category::firstOrCreate(['name' => 'Gastronomía y Alimentos'], ['slug' => 'gastronomia-y-alimentos', 'icon' => 'mdi-food-fork-drink']);
        \App\Models\Category::firstOrCreate(['name' => 'Moda y Accesorios'], ['slug' => 'moda-y-accesorios', 'icon' => 'mdi-tshirt-v']);
        \App\Models\Category::firstOrCreate(['name' => 'Salud y Bienestar'], ['slug' => 'salud-y-bienestar', 'icon' => 'mdi-heart-pulse']);
        \App\Models\Category::firstOrCreate(['name' => 'Educación y Formación'], ['slug' => 'educacion-y-formacion', 'icon' => 'mdi-school']);

        $this->call(DemoProductsSeeder::class);
    }
}
