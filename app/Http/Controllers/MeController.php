<?php

namespace App\Http\Controllers;

use App\StarSystem;
use Illuminate\Http\Request;


class MeController extends Controller
{

    /**
     * MeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $recentDiscoveries = StarSystem::with(['discovered_by'])
            ->orderBy('discovered_on', 'DESC')
            ->limit(10)
            ->get();

        return view('me', compact('user', 'recentDiscoveries'));
    }
}
