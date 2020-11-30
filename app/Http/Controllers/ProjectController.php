<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects.index', [
            'projects' =>  auth()->user()->projects
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

    public function update(ProjectUpdateRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $project->update($request->all());

        return redirect(route('projects.show', $project));
    }
}
