<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project();
        $types = Type::select('id', 'label')->get();
        $technologies = Technology::select('id', 'label')->get();

        return view('admin.projects.create', compact('project', 'types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'title' => 'required|string|max:50',
                'description' => 'nullable|string',
                'cover' => 'nullable|image:jpeg,jpg,png',
                'type_id' => 'nullable|exists:types,id',
                'technologies' => 'nullable|exists:technologies,id'
            ]
        );

        //$data = $request->all();

        $project = new Project();

        if (array_key_exists('cover', $data)) {

            $img_url = Storage::putFile('project_covers', $data['cover']);
            $data['cover'] = $img_url;
        }

        $project->fill($data);
        $project->save();

        if (array_key_exists('technologies', $data)) $project->technologies()->attach($data['technologies']);

        return to_route('admin.projects.index')
            ->with('alert-type', 'success')
            ->with('alert-message', "$project->title created with success");
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::select('id', 'label')->get();
        $technologies = Technology::select('id', 'label')->get();
        $project_technology_ids = $project->technologies->pluck('id')->toArray();

        return view('admin.projects.edit', compact('project', 'types', 'technologies', 'project_technology_ids'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->validate(
            [
                'title' => 'required|string|max:50',
                'description' => 'nullable|string',
                'cover' => 'nullable|image:jpeg,jpg,png',
                'type_id' => 'nullable|exists:types,id',
                'technologies' => 'nullable|exists:technologies,id'
            ]
        );

        // $data = $request->all();

        if (array_key_exists('cover', $data)) {
            if ($project->cover) Storage::delete($project->cover);
            $img_url = Storage::putFile('project_covers', $data['cover']);
            $data['cover'] = $img_url;
        }

        $project->update($data);

        if (!Arr::exists($data, 'technologies') && count($project->technologies)) $project->technologies()->detach();
        elseif (Arr::exists($data, 'technologies')) $project->technologies()->sync($data['technologies']);

        return to_route('admin.projects.show', $project)
            ->with('alert-type', 'success')
            ->with('alert-message', "$project->title updated with success");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return to_route('admin.projects.index')
            ->with('alert-type', 'success')
            ->with('alert-message', "$project->title deleted with success");
    }
}
