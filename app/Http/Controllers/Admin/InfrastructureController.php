<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreInfrastructureRequest;
use App\Http\Requests\UpdateInfrastructureRequest;
use App\Models\Day;
use App\Models\House;
use App\Models\Infrastructure;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InfrastructureController extends Controller
{
    use MediaUploadingTrait;
    public function index()
    {
        abort_if(Gate::denies('infrastructure_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $infrastructures = Infrastructure::with(['houses', 'days', 'created_by'])->get();

        return view('admin.infrastructures.index', compact('infrastructures'));
    }

    public function create()
    {
        abort_if(Gate::denies('infrastructure_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $houses = House::all()->pluck('title', 'id');

        $days = Day::all();

        return view('admin.infrastructures.create', compact('houses', 'days'));
    }

    public function store(StoreInfrastructureRequest $request)
    {
        $infrastructure = Infrastructure::create($request->all());
        $infrastructure->houses()->sync($request->input('houses', []));
        $hours = collect($request->input('from_hours'))->mapWithKeys(function($value, $id) use ($request) {
            return $value ? [
                $id => [
                    'from_hours'    => $value,
                    'from_minutes'  => $request->input('from_minutes.'.$id),
                    'to_hours'      => $request->input('to_hours.'.$id),
                    'to_minutes'    => $request->input('to_minutes.'.$id)
                ]
            ]
                : [];
        });
        $infrastructure->days()->sync($request->input('days', []));
        foreach ($request->input('photos', []) as $file) {
            $infrastructure->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
        }

        return redirect()->route('admin.infrastructures.index');
    }

    public function edit(Infrastructure $infrastructure)
    {
        abort_if(Gate::denies('infrastructure_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $houses = House::all()->pluck('title', 'id');

        $days = Day::all()->pluck('name', 'id');

        $infrastructure->load('houses', 'days', 'created_by');

        return view('admin.infrastructures.edit', compact('houses', 'days', 'infrastructure'));
    }

    public function update(UpdateInfrastructureRequest $request, Infrastructure $infrastructure)
    {
        $infrastructure->update($request->all());
        $infrastructure->houses()->sync($request->input('houses', []));
        $infrastructure->days()->sync($request->input('days', []));

        return redirect()->route('admin.infrastructures.index');
    }

    public function show(Infrastructure $infrastructure)
    {
        abort_if(Gate::denies('infrastructure_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $infrastructure->load('houses', 'days', 'created_by');

        return view('admin.infrastructures.show', compact('infrastructure'));
    }

    public function destroy(Infrastructure $infrastructure)
    {
        abort_if(Gate::denies('infrastructure_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $infrastructure->delete();

        return back();
    }


}
