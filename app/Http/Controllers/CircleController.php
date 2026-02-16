<?php

namespace App\Http\Controllers;

use App\Http\Requests\Circle\StoreCircleRequest;
use App\Http\Requests\Circle\UpdateCircleRequest;
use App\Models\Circle;
use App\Models\Zone;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CircleController extends Controller
{
    public function index(): View
    {
        $circles = Circle::query()->with('zone')->orderBy('name')->get();

        return view('circles.index', compact('circles'));
    }

    public function create(): View
    {
        $zones = Zone::query()->orderBy('name')->get();

        return view('circles.create', compact('zones'));
    }

    public function store(StoreCircleRequest $request): RedirectResponse
    {
        Circle::create($request->validated());

        return redirect()->route('circles.index')->with('success', 'Circle created successfully.');
    }

    public function show(Circle $circle): View
    {
        $circle->load('zone');

        return view('circles.show', compact('circle'));
    }

    public function edit(Circle $circle): View
    {
        $zones = Zone::query()->orderBy('name')->get();

        return view('circles.edit', compact('circle', 'zones'));
    }

    public function update(UpdateCircleRequest $request, Circle $circle): RedirectResponse
    {
        $circle->update($request->validated());

        return redirect()->route('circles.index')->with('success', 'Circle updated successfully.');
    }

    public function destroy(Circle $circle): RedirectResponse
    {
        $circle->delete();

        return redirect()->route('circles.index')->with('success', 'Circle deleted successfully.');
    }

    public function circlesByZone(Request $request): JsonResponse
    {
        $zoneId = $request->integer('zone_id');
        $circles = Circle::query()
            ->where('zone_id', $zoneId)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($circles);
    }
}
