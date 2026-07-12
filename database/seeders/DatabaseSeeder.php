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

        $age = TagGroup::query()->updateOrCreate(
            ['slug' => 'age'],
            ['name' => '年齢で選ぶ', 'sort_order' => 2],
        );

        $treatmentStage = TagGroup::query()->updateOrCreate(
            ['slug' => 'treatment-stage'],
            ['name' => '治療ステージで選ぶ', 'sort_order' => 1],
        );

        $treatment = TagGroup::query()->updateOrCreate(
            ['slug' => 'treatment'],
            ['name' => '治療法で選ぶ', 'sort_order' => 4],
        );

        $medicine = TagGroup::query()->updateOrCreate(
            ['slug' => 'medicine'],
            ['name' => '薬剤名で選ぶ', 'sort_order' => 5],
        );
        $sideEffect = TagGroup::query()->updateOrCreate(
            ['slug' => 'side-effect'],
            ['name' => '副作用で選ぶ', 'sort_order' => 5],
        );   

        $emotion = TagGroup::query()->updateOrCreate(
        ['slug' => 'emotion'],
        ['name' => '気持ちで選ぶ', 'sort_order' => 6],
        );

        $lifestyle = TagGroup::query()->updateOrCreate(
        ['slug' => 'lifestyle'],
        ['name' => '暮らしで選ぶ', 'sort_order' => 7],
        );


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
        $treatmentStageTags = [
            ['slug' => 'newly-diagnosed', 'name' => '診断されたばかり', 'sort_order' => 1],
            ['slug' => 'before-surgery', 'name' => '手術前', 'sort_order' => 2],
            ['slug' => 'after-surgery', 'name' => '手術後', 'sort_order' => 3],
            ['slug' => 'during-chemotherapy', 'name' => '化学療法中', 'sort_order' => 4],
            ['slug' => 'during-radiation', 'name' => '放射線治療中', 'sort_order' => 5],
            ['slug' => 'during-hormone', 'name' => 'ホルモン治療中', 'sort_order' => 6],
            ['slug' => 'follow-up', 'name' => '経過観察・治療終了後', 'sort_order' => 7],
            ['slug' => 'recurrence', 'name' => '再発・転移', 'sort_order' => 8],
        ];

        foreach ($treatmentStageTags as $t) {
            Tag::query()->updateOrCreate(
                ['slug' => $t['slug']],
                [
                    'name' => $t['name'],
                    'tag_kind' => 'treatment_stage',
                    'tag_group_id' => $treatmentStage->id,
                    'sort_order' => $t['sort_order'],
                ],
            );
        }

        $treatmentTags = [
            ['slug' => 'surgery', 'name' => '手術', 'sort_order' => 1],
            ['slug' => 'surgery_partial', 'name' => '乳房部分切除術', 'sort_order' => 2],
            ['slug' => 'surgery_mastectomy', 'name' => '乳房全摘術', 'sort_order' => 3],
            ['slug' => 'slnb', 'name' => 'センチネルリンパ節生検', 'sort_order' => 4],
            ['slug' => 'alnd', 'name' => '腋窩郭清', 'sort_order' => 5],
            ['slug' => 'recon', 'name' => '乳房再建術', 'sort_order' => 6],

            ['slug' => 'chemotherapy', 'name' => '化学療法', 'sort_order' => 7],
            ['slug' => 'chemo_neoadjuvant', 'name' => '術前化学療法', 'sort_order' => 8],
            ['slug' => 'chemo_adjuvant', 'name' => '術後化学療法', 'sort_order' => 9],

            ['slug' => 'targeted', 'name' => '分子標的薬', 'sort_order' => 10],
            ['slug' => 'immunotherapy', 'name' => '免疫チェックポイント阻害薬', 'sort_order' => 11],
            ['slug' => 'hormone', 'name' => 'ホルモン治療', 'sort_order' => 12],
            ['slug' => 'radiation', 'name' => '放射線治療', 'sort_order' => 13],    
        ];

        foreach ($treatmentTags as $t) {
            Tag::query()->updateOrCreate(
                ['slug' => $t['slug']],
                [
                    'name' => $t['name'],
                    'tag_kind' => 'treatment',
                    'tag_group_id' => $treatment->id,
                    'sort_order' => $t['sort_order'],
                ],
            );
        }
        $medicineTags = [
            ['slug' => 'tamoxifen', 'name' => 'タモキシフェン', 'sort_order' => 1],
            ['slug' => 'aromatase_inhibitor', 'name' => 'アロマターゼ阻害薬', 'sort_order' => 2],
            ['slug' => 'lhrh_agonist', 'name' => 'LH-RHアゴニスト', 'sort_order' => 3],
            ['slug' => 'fulvestrant', 'name' => 'フェソロデックス（フルベストラント）', 'sort_order' => 4],
            ['slug' => 'chemo_ac_ec', 'name' => 'AC/EC療法', 'sort_order' => 5],
            ['slug' => 'chemo_tc', 'name' => 'TC療法', 'sort_order' => 6],
            ['slug' => 'chemo_taxan', 'name' => 'タキサン系抗がん剤', 'sort_order' => 7],
            ['slug' => 'chemo_carboplatin', 'name' => 'カルボプラチン', 'sort_order' => 8],
            ['slug' => 'chemo_capecitabine', 'name' => 'カペシタビン（ゼローダ）', 'sort_order' => 9],
            ['slug' => 'ts1', 'name' => 'TS-1', 'sort_order' => 10],
            ['slug' => 'chemo_eribulin', 'name' => 'エリブリン', 'sort_order' => 11],

            ['slug' => 'trastuzumab_pertuzumab', 'name' => 'トラスツズマブ(ハーセプチン)', 'sort_order' => 12],
            ['slug' => 'trastuzumab_pertuzumab', 'name' => 'ペルツズマブ（パージェタ）', 'sort_order' => 13],
            ['slug' => 'tdm1', 'name' => 'T-DM1（カドサイラ）', 'sort_order' => 14],
            ['slug' => 't_dxd', 'name' => 'トラスツズマブ デルクステカン（エンハーツ）', 'sort_order' => 15],
            ['slug' => 'datopotamab', 'name' => 'ダトポタマブ デルクステカン（ダトロウェイ）', 'sort_order' => 16],
            ['slug' => 'sacituzumab', 'name' => 'サシツズマブ ゴビテカン（トロテルビ）', 'sort_order' => 17],
            ['slug' => 'bevacizumab', 'name' => 'ベバシズマブ（アバスチン）', 'sort_order' => 18],

            ['slug' => 'cdk4_6', 'name' => 'CDK4/6阻害薬', 'sort_order' => 19],
            ['slug' => 'olaparib', 'name' => 'オラパリブ（リムパーザ）', 'sort_order' => 20],
            ['slug' => 'olaparib', 'name' => 'オラパリブ（リムパーザ）', 'sort_order' => 20],

        ];
        foreach ($medicineTags as $t) {
            Tag::query()->updateOrCreate(
                ['slug' => $t['slug']],
                [
                    'name' => $t['name'],
                    'tag_kind' => 'medicine',
                    'tag_group_id' => $medicine->id,
                    'sort_order' => $t['sort_order'],
                ],
            );
        }

        $sideEffectTags = [
        ['slug' => 'nausea', 'name' => '吐き気/嘔吐', 'sort_order' => 1],
        ['slug' => 'fatigue', 'name' => '疲労', 'sort_order' => 2],
        ['slug' => 'hair-loss', 'name' => '脱毛', 'sort_order' => 3],
        ['slug' => 'body-weightgain', 'name' => '体重増加', 'sort_order' => 4],
        ['slug' => 'appetite-loss', 'name' => '食欲低下', 'sort_order' => 5],
        ['slug' => 'taste-disorder', 'name' => '味覚障害', 'sort_order' => 6],
        ['slug' => 'stomatitis', 'name' => '口内炎', 'sort_order' => 7],
        ['slug' => 'diarrhea', 'name' => '下痢', 'sort_order' => 8],
        ['slug' => 'constipation', 'name' => '便秘', 'sort_order' => 9],
        ['slug' => 'peripheral-neuropathy', 'name' => 'しびれ・末梢神経障害', 'sort_order' => 10],
        ['slug' => 'hand-foot-syndrome', 'name' => '手足症候群', 'sort_order' => 11],
        ['slug' => 'skin-nail', 'name' => '皮膚・爪の変化', 'sort_order' => 12],
        ['slug' => 'dry-skin', 'name' => '皮膚の乾燥', 'sort_order' => 13],
        ['slug' => 'rash', 'name' => '発疹', 'sort_order' => 14],
        ['slug' => 'nail-disorder', 'name' => '爪の変化', 'sort_order' => 15],
        ['slug' => 'hot-flash', 'name' => 'ホットフラッシュ', 'sort_order' => 16],
        ['slug' => 'joint-pain', 'name' => '関節痛', 'sort_order' => 17],
        ['slug' => 'muscle-pain', 'name' => '肩が上がらない', 'sort_order' => 18],
        ['slug' => 'lymphedema', 'name' => 'リンパ浮腫', 'sort_order' => 19],
        ['slug' => 'pain', 'name' => '痛み', 'sort_order' => 20],
        ['slug' => 'sleep-problem', 'name' => '睡眠の悩み', 'sort_order' => 21],
        ['slug' => 'cognitive-problem', 'name' => 'もの忘れ・集中力低下', 'sort_order' => 22],
        ['slug' => 'menstrual-change', 'name' => '月経の変化', 'sort_order' => 23],
        ['slug' => 'fertility-menopause', 'name' => '妊よう性・閉経に関する変化', 'sort_order' => 24],
        ['slug' => 'sexuality', 'name' => '性生活・デリケートゾーンの悩み', 'sort_order' => 25],
        ['slug' => 'infection-risk', 'name' => '感染しやすさ', 'sort_order' => 26],
        ['slug' => 'fever', 'name' => '発熱', 'sort_order' => 27],
        ['slug' => 'anemia', 'name' => '貧血', 'sort_order' => 28],
        ['slug' => 'bleeding', 'name' => '出血しやすさ', 'sort_order' => 29],
        ['slug' => 'infusion-reaction', 'name' => '点滴時の反応', 'sort_order' => 30],
        ['slug' => 'pneumonitis', 'name' => '間質性肺炎・息切れ', 'sort_order' => 31],
    ];

        foreach ($sideEffectTags as $t) {
        Tag::query()->updateOrCreate(
            ['slug' => $t['slug']],
            [
                'name' => $t['name'],
                'tag_kind' => 'side_effect',
                'tag_group_id' => $sideEffect->id,
                'sort_order' => $t['sort_order'],
            ],
        );
        }
        
        $emotionTags = [
            ['slug' => 'relieved', 'name' => '安心したい', 'sort_order' => 1],
            ['slug' => 'encouraged', 'name' => '元気をもらいたい', 'sort_order' => 2],
            ['slug' => 'courage', 'name' => '勇気をもらいたい', 'sort_order' => 3],
            ['slug' => 'hope', 'name' => '希望を持ちたい', 'sort_order' => 4],
            ['slug' => 'empathy', 'name' => '共感したい', 'sort_order' => 5],
            ['slug' => 'calm', 'name' => 'ほっとしたい', 'sort_order' => 6],
            ['slug' => 'positive', 'name' => '前向きになりたい', 'sort_order' => 7],
            ['slug' => 'not-alone', 'name' => '一人じゃないと感じたい', 'sort_order' => 8],
        ];  
        
        foreach ($emotionTags as $t) {
            Tag::query()->updateOrCreate(
                ['slug' => $t['slug']],
                [
                    'name' => $t['name'],
                    'tag_kind' => 'emotion',
                    'tag_group_id' => $emotion->id,
                    'sort_order' => $t['sort_order'],
                    'is_admin_only' => true, 
                ],
            );
        }
        
        $lifestyleTags = [
            ['slug' => 'work', 'name' => '仕事', 'sort_order' => 1],
            ['slug' => 'childcare', 'name' => '子育て', 'sort_order' => 2],
            ['slug' => 'family', 'name' => '家族とのこと', 'sort_order' => 3],
            ['slug' => 'relationship', 'name' => '恋愛・結婚', 'sort_order' => 4],
            ['slug' => 'fertility', 'name' => '妊娠・妊よう性', 'sort_order' => 5],
            ['slug' => 'money', 'name' => 'お金・制度', 'sort_order' => 6],
            ['slug' => 'hospital-life', 'name' => '通院・入院', 'sort_order' => 7],
            ['slug' => 'driving', 'name' => '運転', 'sort_order' => 8],
            ['slug' => 'travel', 'name' => '旅行', 'sort_order' => 9],
            ['slug' => 'meal', 'name' => '食事', 'sort_order' => 10],
            ['slug' => 'exercise', 'name' => '運動', 'sort_order' => 11],
            ['slug' => 'sleep', 'name' => '睡眠', 'sort_order' => 12],
            ['slug' => 'bathing', 'name' => '温泉・入浴', 'sort_order' => 13],
            ['slug' => 'fashion', 'name' => '下着・ブラジャー', 'sort_order' => 14],
            ['slug' => 'wig', 'name' => 'ウィッグ・帽子', 'sort_order' => 15],
            ['slug' => 'makeup', 'name' => 'メイク', 'sort_order' => 16],
            ['slug' => 'hobby', 'name' => '趣味', 'sort_order' => 17],
        ];
        
        foreach ($lifestyleTags as $t) {
            Tag::query()->updateOrCreate(
                ['slug' => $t['slug']],
                [
                    'name' => $t['name'],
                    'tag_kind' => 'lifestyle',
                    'tag_group_id' => $lifestyle->id,
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
