<?php

use Illuminate\Support\Facades\Route;


Route::middleware('auth:admin')->group(function() {
    Route::get('panel', function(){
        return view('admin.admin');
    })->name('admin-panel');
});