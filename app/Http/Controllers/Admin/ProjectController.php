<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Controllers\Controller;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     ** @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::paginate(10);

        return view("admin.projects.index", compact("projects"));

    }

    /**
     * Show the form for creating a new resource.
     *
     ** @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view("admin.projects.create", compact("types", "technologies"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     ** @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();

        $project = new Project();
        $project->fill($data);
        $project->slug = Str::slug($project->name);

        if ($request->hasFile("image")) {
            $image_path = Storage::put("uploads/projects/images", $data["image"]);
            $project->image = $image_path;
        }

        $project->save();

        if (Arr::exists($data, "technologies"))
            $project->technologies()->attach($data["technologies"]);

        return redirect()->route('admin.projects.show', compact('project'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     ** @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view("admin.projects.show", compact("project"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     ** @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        $project_technologies = $project->technologies->pluck('id')->toArray();
        return view("admin.projects.edit", compact("project", "types", "technologies", "project_technologies"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     ** @return \Illuminate\Http\Response
     */
    public function update(StoreProjectRequest $request, Project $project)
    {
        $data = $request->validated();

        $project->slug = Str::slug($data['name']);
        $project->update($data);

        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::delete($project->image);
            }

            $image_path = Storage::put("uploads/projects/images", $data["image"]);
            $project->image = $image_path;
        }

        $project->save();

        if (Arr::exists($data, "technologies"))
            $project->technologies()->sync($data["technologies"]);

        return redirect()->route("admin.projects.show", compact("project"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     ** @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if ($project->image) {
            Storage::delete($project->image);
        }

        $project->delete();

        return redirect()->route("admin.projects.index");
    }

    public function deleteImage(Project $project)
    {
        Storage::delete($project->image);
        $project->image = null;
        $project->save();

        return redirect()->back();
    }
}
