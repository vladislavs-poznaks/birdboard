<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function invite(User $user, Project $project)
    {
        return $project->owner->is($user);
    }

    public function update(User $user, Project $project)
    {
        return $project->owner->is($user) || $project->members->contains($user);
    }

    public function destroy(User $user, Project $project)
    {
        return $project->owner->is($user);
    }
}
