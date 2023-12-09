<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FrontendCategoryController;
use App\Http\Controllers\FrontendHomeController;
use Illuminate\Support\Facades\Route;

    Route::get('/',[FrontendHomeController::class, 'index'])->name('home');
    Route::get('/category/{slug}',[FrontendCategoryController::class, 'category'])->name('category');
    Route::get('/post/{slug}',[FrontendHomeController::class, 'showPost'])->name('showPost');

    Route::post('/comment-store',[CommentController::class, 'comment_store'])->name('comment_store');
