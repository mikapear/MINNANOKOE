<?php

return [
    'character_message' => env('CHARACTER_MESSAGE', 'あなたの日常が、誰かの力になります。'),

    'treatment_types' => [

        'surgery' => '手術',
        'chemotherapy' => '抗がん剤治療',
        'hormone' => 'ホルモン治療',
        'radiation' => '放射線治療',
        'immunotherapy' => '免疫療法',
        'targeted' => '分子標的薬',
        'watchful' => '経過観察',
        'other' => 'その他',

        'surgery_partial' => '乳房部分切除',
        'surgery_mastectomy' => '乳房全切除',
        'slnb' => 'センチネルリンパ節生検',
        'alnd' => '腋窩郭清',
        'recon' => '乳房再建術',

        'chemo_neoadjuvant' => '術前化学療法',
        'chemo_adjuvant' => '術後化学療法',
        'chemo_ac/ec' => 'AC/EC療法',
        'chemo_tc' => 'TC療法',
        'chemo_taxan' => 'タキサン系抗がん剤',

        'trastuzumab/pertuzumab' => 'トラスツズマブ/ペルツズマブ',
        'CDK4/6' => 'CDK4/6阻害薬',

        'hormone_tamoxifen' => 'タモキシフェン',
        'hormone_ai' => 'アロマターゼ阻害薬',
        'hormone_lhrh' => 'LH-RHアゴニスト',

    ],
];
