@extends('layouts.app')

@section('content')
    <div class="lg:flex space-x-10">

        <div class="w-full lg:w-3/4 px-10 py-6">
            <div class="flex items-center justify-between py-4 mb-4">
                <h2 class="text-xl text-gray-400" >My Projects</h2>
                <a
                    href="{{ route('projects.create') }}"
                    class="bg-blue-400 text-white rounded-lg shadow hover:bg-blue-500 px-4 py-2"
                >New Project</a>
            </div>

            <div class="flex grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse($projects as $project)
                    <x-project-card :project="$project" />
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
