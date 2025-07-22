<?php
use Illuminate\Support\Facades\Route;
use Mimachh\I18nertia\Http\Controller\LocaleController;

Route::middleware('web')->post('/change-locale', LocaleController::class)->name('change-locale');