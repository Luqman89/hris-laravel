<?php

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::inertia('/', 'welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('dashboard', [
        'stats' => [
            'total_employees' => User::count(),
            'on_leave' => 0, // Ganti dengan query asli nanti
            'pending_approval' => 0, // Ganti dengan query asli nanti
        ],
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
