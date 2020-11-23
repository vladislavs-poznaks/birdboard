<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects.index', [
            'projects' =>  Project::all()
        ]);
    }

    public function show(Project $project)
    {
        abort_unless(auth()->user()->is($project->owner), 403);

        return view('projects.show', [
            'project' => $project
        ]);
    }

    public function store(ProjectStoreRequest $request)
    {
        auth()->user()->projects()->create($request->all());

        return redirect(route('projects.index'));
    }
}
