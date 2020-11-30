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
        $this->authorize('update', $project);

        $project->tasks()->create($request->all());

        return redirect(route('projects.show', [
            'project' => $project
        ]));
    }

    public function update(TaskUpdateRequest $request, Project $project, Task $task)
    {
        $this->authorize('update', $task->project);

        $task->update($request->all());

        return redirect(route('projects.show', $project));
    }
}
