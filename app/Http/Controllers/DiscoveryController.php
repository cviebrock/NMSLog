<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStarSystemRequest;
use App\StarSystem;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;


class DiscoveryController extends Controller
{

    /**
     * @var User
     */
    protected $user;

    /**
     * StarSystemController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $starSystems = $user->discoveredStarSystems;

        return view('discoveries.index', compact('starSystems', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $timezone = $request->user()->timezone;

        $currentTime = Carbon::now($timezone);

        return view('discoveries.create', compact('currentTime'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CreateStarSystemRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateStarSystemRequest $request)
    {
        $user = $request->user();
        $data = $request->all();

        $data['discovered_on'] = new Carbon($data['discovered_on'], $user->timezone);
        $data['discovered_on']->setTimezone('UTC');

        $starSystem = new StarSystem($data);
        $starSystem->user_id = $user->getKey();

        $starSystem->updateDistance();

        $starSystem->save();


        // @todo add visit relation

        return redirect()
            ->route('discoveries.index')
            ->with('status', "Star system \"{$starSystem->name}\" added.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StarSystem $starSystem
     * @return \Illuminate\Http\Response
     */
    public function show(StarSystem $starSystem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StarSystem $starSystem
     * @return \Illuminate\Http\Response
     */
    public function edit(StarSystem $starSystem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\StarSystem $starSystem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StarSystem $starSystem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StarSystem $starSystem
     * @return \Illuminate\Http\Response
     */
    public function destroy(StarSystem $starSystem)
    {
        //
    }
}
