<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function index()
{
    $campaigns = Campaign::active()
        ->with(['donations' => function ($query) {
            $query->successful(); // ← pakai 'successful', BUKAN 'success'
        }])
        ->orderBy('created_at', 'desc')
        ->get();

    return view('home', compact('campaigns'));
}

public function showCampaign($id)
{
    $campaign = Campaign::with(['donations' => function ($query) {
        $query->successful()->orderBy('created_at', 'desc');
    }])
    ->findOrFail($id);

    $recentDonors = $campaign->donations()
        ->successful()
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();

    return view('campaign.detail', compact('campaign', 'recentDonors'));
}
}