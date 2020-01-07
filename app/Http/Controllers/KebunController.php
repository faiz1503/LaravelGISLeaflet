<?php

namespace App\Http\Controllers;

use App\Kebun;
use Illuminate\Http\Request;

class KebunController extends Controller
{
    /**
     * Display a listing of the outlet.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('manage_kebun');

        $kebunQuery = Kebun::query();
        $kebunQuery->where('name', 'like', '%'.request('q').'%');
        $kebuns = $kebunQuery->paginate(25);

        return view('kebuns.index', compact('kebuns'));
    }

    /**
     * Show the form for creating a new outlet.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', new Kebun);

        return view('kebuns.create');
    }

    /**
     * Store a newly created outlet in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->authorize('create', new Kebun);

        $newKebun = $request->validate([
            'name'      => 'required|max:60',
            'address'   => 'nullable|max:255',
            'latitude'  => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',
        ]);
        $newKebun['creator_id'] = auth()->id();

        $kebun = Kebun::create($newKebun);

        return redirect()->route('kebuns.show', $kebun);
    }

    /**
     * Display the specified outlet.
     *
     * @param  \App\Kebun  $outlet
     * @return \Illuminate\View\View
     */
    public function show(Kebun $kebun)
    {
        return view('kebuns.show', compact('kebun'));
    }

    /**
     * Show the form for editing the specified outlet.
     *
     * @param  \App\Kebun  $outlet
     * @return \Illuminate\View\View
     */
    public function edit(Kebun $kebun)
    {
        $this->authorize('update', $kebun);

        return view('kebuns.edit', compact('kebun'));
    }

    /**
     * Update the specified outlet in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kebun  $outlet
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, Kebun $kebun)
    {
        $this->authorize('update', $kebun);

        $kebunData = $request->validate([
            'name'      => 'required|max:60',
            'address'   => 'nullable|max:255',
            'latitude'  => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',
        ]);
        $kebun->update($kebunData);

        return redirect()->route('kebuns.show', $kebun);
    }

    /**
     * Remove the specified outlet from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kebun  $outlet
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Kebun $kebun)
    {
        $this->authorize('delete', $kebun);

        $request->validate(['kebun_id' => 'required']);

        if ($request->get('kebun_id') == $kebun->id && $kebun->delete()) {
            return redirect()->route('kebuns.index');
        }

        return back();
    }
}
