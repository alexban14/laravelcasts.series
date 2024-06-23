<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class Dashboard extends Controller
{
    public function show(): View
    {
        if (! auth()->check()) {
            return view('welcome');
        } else {
            if(session()->has('tenant_id')) {
                return view('team');
            }
            $subscribersCount = Tenant::count();
            $usersCount = User::count();
            $loginsCount = Login::count();
            return view('dashboard', [
                'subscribersCount' => $subscribersCount,
                'usersCount' => $usersCount,
                'loginsCount' => $loginsCount,
            ]);
        }
    }
}
