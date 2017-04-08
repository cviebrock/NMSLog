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

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function map(Request $request)
    {
        $user = $request->user();
        $tz = $user->timezone;

        $starSystems = StarSystem::with(['discovered_by'])
            ->orderBy('discovered_on', 'ASC')
            ->get();

        $path = $starSystems->where('discovered_by.user_id', $user->user_id);

        $starSystems = $starSystems->map(
            function(StarSystem $starSystem) use ($tz) {
                return [
                    'name'       => $starSystem->name,
                    'discoverer' => $starSystem->discovered_by->username,
                    'date'       => $starSystem->discoveredOnInTimezone($tz)->format('Y-m-d H:i'),
                    'position'   => $starSystem->XYZArray,
                    'color'      => $starSystem->color,
                    'brightness' => $starSystem->brightness,
                    'blackhole'  => $starSystem->blackhole,
                ];
            }
        );

        $path = $path->map(
            function(StarSystem $starSystem) {
                return $starSystem->XYZArray;
            }
        );

        return view('map', compact('starSystems', 'path'));
    }
}
