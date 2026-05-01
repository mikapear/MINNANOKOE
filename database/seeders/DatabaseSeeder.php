<?php

namespace Database\Seeders;

use App\Models\LearnColumn;
use App\Models\LearnSection;
use App\Models\Tag;
use App\Models\TagGroup;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminEmail = env('ADMIN_SEED_EMAIL', 'admin@minnanokoe.test');
        $adminPassword = env('ADMIN_SEED_PASSWORD', 'password');

        User::query()->updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => '管理者',
                'password' => Hash::make($adminPassword),
                'is_admin' => true,
                'birth_date' => '1980-01-01',
                'diagnosed_at' => '2015-06-01',
                'treatment_types' => ['surgery', 'chemotherapy'],
                'privacy_consented_at' => now(),
            ],
        );

        $worry = TagGroup::query()->updateOrCreate(
            ['slug' => 'worry'],
            ['name' => '悩みで選ぶ', 'sort_order' => 1],
        );
        $age = TagGroup::query()->updateOrCreate(
            ['slug' => 'age'],
            ['name' => '年齢で選ぶ', 'sort_order' => 2],
        );
        $situation = TagGroup::query()->updateOrCreate(
            ['slug' => 'situation'],
            ['name' => '状況で選ぶ', 'sort_order' => 3],
        );

        $worryTags = [
            ['slug' => 'worry-chemo', 'name' => '抗がん剤について', 'sort_order' => 1],
            ['slug' => 'worry-surgery', 'name' => '手術について', 'sort_order' => 2],
            ['slug' => 'worry-hormone', 'name' => 'ホルモン治療について', 'sort_order' => 3],
        ];
        foreach ($worryTags as $t) {
            Tag::query()->updateOrCreate(
                ['slug' => $t['slug']],
                [
                    'name' => $t['name'],
                    'tag_kind' => 'worry',
                    'tag_group_id' => $worry->id,
                    'sort_order' => $t['sort_order'],
                ],
            );
        }

        $ageTags = [
            ['slug' => 'age-30s', 'name' => '30代', 'sort_order' => 1],
            ['slug' => 'age-40s', 'name' => '40代', 'sort_order' => 2],
            ['slug' => 'age-50s', 'name' => '50代', 'sort_order' => 3],
            ['slug' => 'age-60s', 'name' => '60代', 'sort_order' => 4],
            ['slug' => 'age-70s', 'name' => '70代', 'sort_order' => 5],
            ['slug' => 'age-80plus', 'name' => '80代以上', 'sort_order' => 6],
        ];
        foreach ($ageTags as $t) {
            Tag::query()->updateOrCreate(
                ['slug' => $t['slug']],
                [
                    'name' => $t['name'],
                    'tag_kind' => 'age_band',
                    'tag_group_id' => $age->id,
                    'sort_order' => $t['sort_order'],
                ],
            );
        }

        $situationTags = [
            ['slug' => 'life-childcare', 'name' => '子育て', 'sort_order' => 1],
            ['slug' => 'life-work', 'name' => '仕事', 'sort_order' => 2],
            ['slug' => 'life-care', 'name' => '介護', 'sort_order' => 3],
        ];
        foreach ($situationTags as $t) {
            Tag::query()->updateOrCreate(
                ['slug' => $t['slug']],
                [
                    'name' => $t['name'],
                    'tag_kind' => 'situation',
                    'tag_group_id' => $situation->id,
                    'sort_order' => $t['sort_order'],
                ],
            );
        }

        $freeTags = [
            ['slug' => 'nausea', 'name' => '吐き気', 'sort_order' => 1],
            ['slug' => 'fatigue', 'name' => '疲労', 'sort_order' => 2],
        ];
        foreach ($freeTags as $t) {
            Tag::query()->updateOrCreate(
                ['slug' => $t['slug']],
                [
                    'name' => $t['name'],
                    'tag_kind' => 'free',
                    'tag_group_id' => null,
                    'sort_order' => $t['sort_order'],
                ],
            );
        }

        $exercise = LearnSection::query()->updateOrCreate(
            ['slug' => 'exercise'],
            ['name' => '運動について', 'sort_order' => 1],
        );
        $diet = LearnSection::query()->updateOrCreate(
            ['slug' => 'diet'],
            ['name' => '食事について', 'sort_order' => 2],
        );
        $side = LearnSection::query()->updateOrCreate(
            ['slug' => 'side-effects'],
            ['name' => '副作用について', 'sort_order' => 3],
        );

        $colNausea = Tag::query()->where('slug', 'nausea')->first();

        $col1 = LearnColumn::query()->updateOrCreate(
            ['slug' => 'gentle-walk'],
            [
                'learn_section_id' => $exercise->id,
                'title' => '軽い歩行から始める',
                'body' => '<p>無理のない範囲で体を動かすことは、副作用への対処にもつながります。</p>',
                'is_published' => true,
                'sort_order' => 1,
            ],
        );
        if ($colNausea) {
            $col1->tags()->syncWithoutDetaching([$colNausea->id]);
        }

        $col2 = LearnColumn::query()->updateOrCreate(
            ['slug' => 'balanced-meal'],
            [
                'learn_section_id' => $diet->id,
                'title' => 'バランスの取れた食事',
                'body' => '<p>食欲が落ちたときは、少しずつでも栄養を摂る工夫をしてみましょう。</p>',
                'is_published' => true,
                'sort_order' => 1,
            ],
        );
        if ($colNausea) {
            $col2->tags()->syncWithoutDetaching([$colNausea->id]);
        }

        LearnColumn::query()->updateOrCreate(
            ['slug' => 'communicate-side-effects'],
            [
                'learn_section_id' => $side->id,
                'title' => '副作用は早めに医療チームへ',
                'body' => '<p>つらさが続くときは、一人で抱え込まず相談窓口を使いましょう。</p>',
                'is_published' => true,
                'sort_order' => 1,
            ],
        );
    }
}
