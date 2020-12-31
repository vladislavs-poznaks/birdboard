<div>
    {{ auth()->user()->is($activity->user) ? 'You' : $activity->user->name }} created a project
</div>
