<?php

namespace App\Http\Controllers;

use App\Http\Requests\Substation\StoreSubstationRequest;
use App\Http\Requests\Substation\UpdateSubstationRequest;
use App\Models\Circle;
use App\Models\Division;
use App\Models\Substation;
use App\Models\Zone;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubstationController extends Controller
{
    public function index(): View
    {
        $substations = Substation::query()->with(['zone', 'circle', 'division'])->orderBy('name')->get();

        return view('substations.index', compact('substations'));
    }

    public function create(): View
    {
        $zones = Zone::query()->orderBy('name')->get();

        return view('substations.create', compact('zones'));
    }

    public function store(StoreSubstationRequest $request): RedirectResponse
    {
        Substation::create($request->validated());

        return redirect()->route('substations.index')->with('success', 'Sub Station created successfully.');
    }

    public function show(Substation $substation): View
    {
        $substation->load(['zone', 'circle', 'division']);

        return view('substations.show', compact('substation'));
    }

    public function edit(Substation $substation): View
    {
        $zones = Zone::query()->orderBy('name')->get();
        $circles = Circle::query()->where('zone_id', $substation->zone_id)->orderBy('name')->get();
        $divisions = Division::query()->where('circle_id', $substation->circle_id)->orderBy('name')->get();

        return view('substations.edit', compact('substation', 'zones', 'circles', 'divisions'));
    }

    public function update(UpdateSubstationRequest $request, Substation $substation): RedirectResponse
    {
        $substation->update($request->validated());

        return redirect()->route('substations.index')->with('success', 'Sub Station updated successfully.');
    }

    public function destroy(Substation $substation): RedirectResponse
    {
        $substation->delete();

        return redirect()->route('substations.index')->with('success', 'Sub Station deleted successfully.');
    }

    public function substationsByDivision(Request $request): JsonResponse
    {
        $divisionId = $request->integer('division_id');
        $substations = Substation::query()
            ->where('division_id', $divisionId)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($substations);
    }
}
