@extends('layouts.app')

@section('content')
    <div class="lg:flex space-x-10">
        <div class="w-full lg:w-3/4 px-10 py-6">
            <div class="flex items-center justify-between py-4 mb-4">
                <h2 class="text-xl text-gray-400" >My Projects</h2>
                <a
                    href="{{ route('projects.create') }}"
                    class="bg-blue-400 text-white rounded-full shadow hover:bg-blue-500 px-6 py-3 mt-3"
                >New Project</a>
            </div>

            <div class="flex grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse($projects as $project)
                    <div class="h-56 bg-white rounded-lg shadow-lg space-y-3 py-6">
                        <div class="border-l-8 border-blue-300 text-lg">
                            <a
                                href="{{ route('projects.show', $project) }}"
                                class="hover:underline"
                            >
                                <h3 class="text-xl px-4 py-4">{{ $project->title }}</h3>
                            </a>
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
        <div class="w-full lg:w-1/4 bg-gray-200 pl-4 pr-10 py-6 h-screen">
            Latest Updates
        </div>
    </div>
@endsection
