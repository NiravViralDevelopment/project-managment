<?php

namespace App\Http\Controllers;

use App\Http\Requests\Zone\StoreZoneRequest;
use App\Http\Requests\Zone\UpdateZoneRequest;
use App\Models\Zone;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ZoneController extends Controller
{
    public function index(): View
    {
        $zones = Zone::query()->orderBy('name')->get();

        return view('zones.index', compact('zones'));
    }

    public function create(): View
    {
        return view('zones.create');
    }

    public function store(StoreZoneRequest $request): RedirectResponse
    {
        Zone::create($request->validated());

        return redirect()->route('zones.index')->with('success', 'Zone created successfully.');
    }

    public function show(Zone $zone): View
    {
        return view('zones.show', compact('zone'));
    }

    public function edit(Zone $zone): View
    {
        return view('zones.edit', compact('zone'));
    }

    public function update(UpdateZoneRequest $request, Zone $zone): RedirectResponse
    {
        $zone->update($request->validated());

        return redirect()->route('zones.index')->with('success', 'Zone updated successfully.');
    }

    public function destroy(Zone $zone): RedirectResponse
    {
        $zone->delete();

        return redirect()->route('zones.index')->with('success', 'Zone deleted successfully.');
    }
}
