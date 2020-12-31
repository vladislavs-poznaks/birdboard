<div>
    {{ auth()->user()->is($activity->user) ? 'You' : $activity->user->name }} created "{{ $activity->subject->body }}"
</div>
