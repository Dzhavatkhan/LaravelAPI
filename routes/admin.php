<?php

use Illuminate\Support\Facades\Route;



Route::get('panel', function(){
    return view('admin.admin');
})->name('admin-panel');