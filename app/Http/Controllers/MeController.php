<?php

namespace App\Http\Controllers;

use App\StarSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


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

        $sprite = File::get(resource_path('assets/img/sprite.svg'));

        return view('me', compact('user', 'recentDiscoveries', 'sprite'));
    }
}
