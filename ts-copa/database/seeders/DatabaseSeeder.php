<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(['name' => 'admin'], [
            'password' => Hash::make('123456789'),
            'pix_key'  => 'admin@ts.com',
            'role'     => 'admin',
        ]);

        $teams = [
            ['name' => 'Brasil',    'flag' => 'br'],
            ['name' => 'Argentina', 'flag' => 'ar'],
            ['name' => 'França',    'flag' => 'fr'],
            ['name' => 'Portugal',  'flag' => 'pt'],
            ['name' => 'Alemanha',  'flag' => 'de'],
            ['name' => 'Espanha',   'flag' => 'es'],
        ];

        foreach ($teams as $t) {
            Team::firstOrCreate(['name' => $t['name']], $t);
        }
    }
}
