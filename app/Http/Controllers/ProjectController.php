<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects->merge(auth()->user()->sharedProjects);

        return view('projects.index', [
            'projects' => $projects
        ]);
    }

    public function create()
    {
        return view('projects.create');
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', [
            'project' => $project
        ]);
    }

    public function store(ProjectStoreRequest $request)
    {
        $project = auth()->user()->projects()->create($request->all());

        return redirect(route('projects.show', $project));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', [
            'project' => $project
        ]);
    }

    public function update(ProjectUpdateRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $project->update($request->all());

        return redirect(route('projects.show', $project));
    }

    public function destroy(Project $project)
    {
        $this->authorize('destroy', $project);

        $project->delete();

        return redirect(route('projects.index'));
    }
}
