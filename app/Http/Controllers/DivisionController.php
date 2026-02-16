<?php

namespace App\Http\Controllers;

use App\Http\Requests\Division\StoreDivisionRequest;
use App\Http\Requests\Division\UpdateDivisionRequest;
use App\Models\Circle;
use App\Models\Division;
use App\Models\Zone;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DivisionController extends Controller
{
    public function index(): View
    {
        $divisions = Division::query()->with(['zone', 'circle'])->orderBy('name')->get();

        return view('divisions.index', compact('divisions'));
    }

    public function create(): View
    {
        $zones = Zone::query()->orderBy('name')->get();

        return view('divisions.create', compact('zones'));
    }

    public function store(StoreDivisionRequest $request): RedirectResponse
    {
        Division::create($request->validated());

        return redirect()->route('divisions.index')->with('success', 'Division created successfully.');
    }

    public function show(Division $division): View
    {
        $division->load(['zone', 'circle']);

        return view('divisions.show', compact('division'));
    }

    public function edit(Division $division): View
    {
        $zones = Zone::query()->orderBy('name')->get();
        $circles = Circle::query()->where('zone_id', $division->zone_id)->orderBy('name')->get();

        return view('divisions.edit', compact('division', 'zones', 'circles'));
    }

    public function update(UpdateDivisionRequest $request, Division $division): RedirectResponse
    {
        $division->update($request->validated());

        return redirect()->route('divisions.index')->with('success', 'Division updated successfully.');
    }

    public function destroy(Division $division): RedirectResponse
    {
        $division->delete();

        return redirect()->route('divisions.index')->with('success', 'Division deleted successfully.');
    }

    public function divisionsByCircle(Request $request): JsonResponse
    {
        $circleId = $request->integer('circle_id');
        $divisions = Division::query()
            ->where('circle_id', $circleId)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($divisions);
    }
}
