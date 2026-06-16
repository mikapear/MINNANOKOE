<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearnColumnBlock extends Model
{
    protected $fillable = [
        'learn_column_id',
        'subtitle',
        'body',
        'image_path',
        'sort_order',
    ];

    public function column()
    {
        return $this->belongsTo(LearnColumn::class, 'learn_column_id');
    }
}
