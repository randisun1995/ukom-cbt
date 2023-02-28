<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Level;
use App\Models\Instansi;
use App\Models\Position;
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
        Instansi::create([
            'title'      => 'BKN',
        ]);
        Instansi::create([
            'title'      => 'Menpan',
        ]);
        Position::create([
            'title'      => 'ASDMA',
        ]);
        Position::create([
            'title'      => 'Asesor',
        ]);
        Level::create([
            'title'      => 'Pertama',
        ]);
        Level::create([
            'title'      => 'Muda',
        ]);
        User::create([
            'name'      => 'Administrator',
            'email'     => 'admin@gmail.com',
            'password'  => bcrypt('password'),
        ]);
    }
}
