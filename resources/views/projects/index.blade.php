@extends('layouts.app')

@section('content')
    <div class="flex space-x-10">
        <div class="w-3/4 px-10 py-6">
            <div class="flex items-center mb-4">
                <a href="{{ route('projects.create') }}">New Project</a>
            </div>

            <div class="flex grid grid-cols-3 gap-10">
                @forelse($projects as $project)
                    <div class="h-56 bg-white rounded-lg shadow-lg space-y-3 py-6">
                        <div class="border-l-8 border-blue-200 text-lg">
                            <h3 class="px-4 py-4">{{ $project->title }}</h3>
                        </div>
                        <div class="px-4 text-gray-400">
                            {{ $project->excerpt }}
                        </div>
                    </div>
                @empty
                    <div>
                        No projects yet...
                    </div>
                @endforelse
            </div>
        </div>
        <div class="w-1/4 bg-gray-200 pl-4 pr-10 py-6 h-screen">
            Latest Updates
        </div>
    </div>
@endsection
