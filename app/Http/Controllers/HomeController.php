<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Theme;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $themes = Theme::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('home', compact('themes'));
    }
}