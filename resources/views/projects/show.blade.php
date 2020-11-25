@extends('layouts.app')

@section('content')
    <div class="lg:flex space-x-10">

        <div class="w-full lg:w-3/4 px-10 py-6">
            <div class="flex items-center justify-between py-4 mb-4">
                <div class="flex items-center space-x-5">
                    <h2 class="text-xl text-gray-400" >My Projects/Project</h2>
                    <a
                        href="{{ route('projects.create') }}"
                        class="bg-blue-400 text-white rounded-lg shadow hover:bg-blue-500 px-4 py-2"
                    >Add Task</a>
                </div>
                <div class="flex items-center space-x-5">
                    <img
                        src="/images/avatar.jpeg"
                        alt="avatar"
                        class="w-10 rounded-full"
                    >
                    <img
                        src="/images/avatar.jpeg"
                        alt="avatar"
                        class="w-10 rounded-full"
                    >
                    <img
                        src="/images/avatar.jpeg"
                        alt="avatar"
                        class="w-10 rounded-full"
                    >
                    <a
                        href="{{ route('projects.create') }}"
                        class="bg-blue-400 text-white rounded-lg shadow hover:bg-blue-500 px-4 py-2"
                    >Invite to Project</a>
                </div>

            </div> {{-- End header --}}

            <h2 class="text-lg text-gray-400 mb-3" >My Tasks</h2>

            <div class="flex">
                <div class="w-2/3 pr-10">
                    <div class="space-y-5 mb-6">
                        @forelse($project->tasks as $task)
                            <div class="flex items-center justify-between bg-white rounded-lg shadow-lg py-3">
                                <div class="border-l-8 border-blue-300 text-lg py-1">
                                    <a
                                        href="#"
                                        class="hover:underline"
                                    >
                                        <h3 class="text-xl ml-3">{{ $task->body }}</h3>
                                    </a>
                                </div>

                                <div class="flex items-center space-x-6 mr-6">
                                    <div>
                                        bin
                                    </div>
                                    <div>
                                        due date
                                    </div>
                                    <div>
                                       check
                                    </div>
                                </div>

                            </div>
                        @empty
                            <div>
                                No tasks yet...
                            </div>
                        @endforelse
                    </div>

                    <h2 class="text-lg text-gray-400 mb-3">General notes</h2>
                    <textarea
                        class="h-40 w-full shadow-lg bg-white rounded-lg px-3 py-3"
                    >general notes</textarea>
                </div>

                <div class="w-1/3">
                    <x-project-card :project="$project" />
                </div>
            </div>

        </div>

        <div class="w-full lg:w-1/4 bg-gray-200 pl-4 pr-10 py-6 h-screen">
            Latest Updates
        </div>

    </div>
@endsection

