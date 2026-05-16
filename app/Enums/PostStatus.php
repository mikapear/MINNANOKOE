<?php

namespace App\Enums;

enum PostStatus: string
{
    case Draft = 'draft';
    case Pending = 'pending';
    case Rejected = 'rejected';
    case Published = 'published';
    case Hidden = 'hidden';
    case Suggested = 'suggested';
}
