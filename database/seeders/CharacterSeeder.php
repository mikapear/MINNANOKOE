<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Character;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Character::firstOrCreate(
            ['name' => '看護師の鳥'],
            [
                'profession' => '看護師',
                'icon_path' => 'images/characters/nurse-bird.png',
            ]
        );

        Character::firstOrCreate(
            ['name' => '医師の鳥'],
            [
                'profession' => '医師',
                'icon_path' => 'images/characters/doctor-bird.png',
            ]
        );
    }
}