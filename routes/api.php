<?php

use Illuminate\Support\Facades\Route;
use App\Models\Payment;

Route::get('/payments/summary', function(){
    $payments = Payment::orderBy('created_at','desc')->take(20)->get();
    $labels = $payments->map(fn($p)=>$p->created_at->format('Y-m-d H:i'))->reverse()->values();
    $values = $payments->pluck('amount')->reverse()->values();
    return response()->json(['labels'=>$labels,'values'=>$values]);
});
