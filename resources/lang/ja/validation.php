<?php

return [

    'required' => ':attribute は必須です。',
    'email' => ':attribute の形式が正しくありません。',
    'unique' => 'この :attribute は既に使用されています。',

    'confirmed' => ':attribute が一致しません。',

    'min' => [
        'string' => ':attribute は :min 文字以上で入力してください。',
    ],

    'attributes' => [
        'email' => 'メールアドレス',
        'name' => 'ニックネーム',
        'password' => 'パスワード', 
        'password_confirmation' => '確認用パスワード',
        'birth_year' => '生年',
        'birth_month' => '生月',
        'diagnosed_year' => '診断年',
        'diagnosed_month' => '診断月',
        'roles' => 'あなたの立場',
        'treatment_status' => '現在の治療状況',
    ],

];