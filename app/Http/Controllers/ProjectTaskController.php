<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Models\Project;

class ProjectTaskController extends Controller
{
    public function store(TaskStoreRequest $request, Project $project)
    {
        $project->tasks()->create($request->all());

        return redirect(route('projects.show', [
            'project' => $project
        ]));
    }
}
