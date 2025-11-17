<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Pet;
use App\Models\Checkup;

class DashboardController extends Controller
{
    public function index()
    {
        $ownerCount   = Owner::count();
        $petCount     = Pet::count();
        $checkupCount = Checkup::count();

        $recentCheckups = Checkup::with(['pet.owner', 'treatment'])
            ->orderByDesc('checkup_date')
            ->limit(10)
            ->get();

        return view('dashboard.index', compact(
            'ownerCount',
            'petCount',
            'checkupCount',
            'recentCheckups'
        ));
    }
}
