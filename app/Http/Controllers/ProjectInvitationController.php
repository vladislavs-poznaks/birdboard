<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationsStoreRequest;
use App\Models\Project;
use App\Models\User;

class ProjectInvitationController extends Controller
{
    public function store(InvitationsStoreRequest $request, Project $project)
    {
        $this->authorize('invite', $project);

        $user = User::whereEmail($request->email)->first();
        $project->invite($user);

        return redirect(route('projects.show', $project));
    }
}
