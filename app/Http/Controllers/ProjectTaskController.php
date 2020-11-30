<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Project;
use App\Models\Task;

class ProjectTaskController extends Controller
{
    public function store(TaskStoreRequest $request, Project $project)
    {
        abort_unless(auth()->user()->is($project->owner), 403);

        $project->tasks()->create($request->all());

        return redirect(route('projects.show', [
            'project' => $project
        ]));
    }

    public function update(TaskUpdateRequest $request, Project $project, Task $task)
    {
        abort_unless(auth()->user()->is($project->owner), 403);

        $task->update($request->all());

        return redirect(route('projects.show', $project));
    }
}
