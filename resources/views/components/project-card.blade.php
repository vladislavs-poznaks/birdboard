<div class="bg-white dark:bg-gray-700 rounded-lg shadow-lg space-y-3 py-6 flex flex-col">
    <div class="border-l-8 border-blue-300 text-lg">
        <a
            href="{{ route('projects.show', $project) }}"
            class="hover:underline"
        >
            <h3 class="text-xl px-4 py-4">{{ $project->title }}</h3>
        </a>
    </div>
    <div class="px-4 text-gray-400 flex-1">
        {{ $project->excerpt }}
    </div>

    @can('destroy', $project)
    <div class="px-4 text-red-400 text-right text-sm">
        <form action="{{ route('projects.destroy', $project) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    </div>
    @endcan

</div>
