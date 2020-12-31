<div>
    {{ auth()->user()->is($activity->user) ? 'You' : $activity->user->name }} marked a task as incomplete
</div>
