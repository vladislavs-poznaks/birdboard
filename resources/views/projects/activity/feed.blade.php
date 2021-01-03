<div class="w-full space-y-2 lg:w-1/4 bg-gray-200 pl-4 pr-10 py-6 h-screen dark:bg-gray-900">
    <h3>Latest Updates</h3>
    @foreach($project->activity as $activity)
        <div class="text-sm">
            @include('projects.activity.' . $activity->description)
            <span class="text-gray-700 dark:text-gray-100 text-xs">{{ $activity->created_at->diffForHumans() }}</span>
        </div>
    @endforeach
</div>
