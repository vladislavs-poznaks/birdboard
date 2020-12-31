<div>
    {{ auth()->user()->is($activity->user) ? 'You' : $activity->user->name }} completed a task
</div>
