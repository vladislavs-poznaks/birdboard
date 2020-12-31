<div>
    @if(count($activity->changes['after']) === 1)
        {{ auth()->user()->is($activity->user) ? 'You' : $activity->user->name }} updated the {{ key($activity->changes['after']) }} of the project
    @else
        {{ auth()->user()->is($activity->user) ? 'You' : $activity->user->name }} updated the project
    @endif
</div>
