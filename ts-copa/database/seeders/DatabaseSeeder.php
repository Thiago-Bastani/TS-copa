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
            ['name' => 'Brasil',    'flag' => '🇧🇷'],
            ['name' => 'Argentina', 'flag' => '🇦🇷'],
            ['name' => 'França',    'flag' => '🇫🇷'],
            ['name' => 'Portugal',  'flag' => '🇵🇹'],
            ['name' => 'Alemanha',  'flag' => '🇩🇪'],
            ['name' => 'Espanha',   'flag' => '🇪🇸'],
        ];

        foreach ($teams as $t) {
            Team::firstOrCreate(['name' => $t['name']], $t);
        }
    }
}
