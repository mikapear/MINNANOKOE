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
                'type' => 'learn',
                'icon_path' => 'images/characters/nurse-bird.png',
            ]
        );

        Character::firstOrCreate(
            ['name' => '医師の鳥'],
            [
                'profession' => '医師',
                'type' => 'learn',
                'icon_path' => 'images/characters/doctor-bird.png',
            ]
        );

        Character::firstOrCreate(
            ['name' => 'やさしい'],
            [
                'type' => 'story',
                'icon_path' => 'images/characters/bird-kind.png',
            ]
        );

        Character::firstOrCreate(
            ['name' => '元気'],
            [
                'type' => 'story',
                'icon_path' => 'images/characters/bird-cheerful.png',
            ]
        );

        Character::firstOrCreate(
            ['name' => 'おだやか'],
            [
                'type' => 'story',
                'icon_path' => 'images/characters/bird-calm.png',
            ]
        );

        Character::firstOrCreate(
            ['name' => '学び'],
            [
                'type' => 'story',
                'icon_path' => 'images/characters/bird-thoughtful.png',
            ]
        );

        Character::firstOrCreate(
            ['name' => 'のんびり'],
            [
                'type' => 'story',
                'icon_path' => 'images/characters/bird-relaxed.png',
            ]
        );


    }
}