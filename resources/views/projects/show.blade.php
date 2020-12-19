@extends('layouts.app')

@section('content')
    <div class="lg:flex space-x-10">

        <div class="w-full lg:w-3/4 px-10 py-6">
            <div class="flex items-center justify-between py-4 mb-4">
                <div class="flex items-center space-x-5">
                    <h2 class="text-xl text-gray-400">
                        <a
                            href="{{ route('projects.index') }}"
                            class="hover:underline"
                        >My Projects</a>
                        /
                        {{ $project->title  }}
                    </h2>
                    <a
                        href="{{ route('projects.create') }}"
                        class="bg-blue-400 text-white rounded-lg shadow hover:bg-blue-500 px-4 py-2"
                    >Add Task</a>
                    <a
                        href="{{ route('projects.edit', $project) }}"
                        class="bg-blue-400 text-white rounded-lg shadow hover:bg-blue-500 px-4 py-2"
                    >Edit Project</a>
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

            <h2 class="text-lg text-gray-400 mb-3">My Tasks</h2>

            <div class="flex">
                <div class="w-2/3 pr-10">
                    <div class="space-y-5 mb-6">
                        <div class="flex items-center justify-between bg-white rounded-lg shadow-lg py-3">
                            <form
                                action="{{ route('tasks.store', $project) }}"
                                method="POST"
                                class="w-full flex justify-between px-3"
                            >
                                @csrf
                                <input
                                    type="text"
                                    name="body"
                                    placeholder="Add a task ..."
                                    class="w-full rounded-lg py-1 px-3"
                                >
                                <button
                                    type="submit"
                                    class="bg-blue-400 text-white rounded-lg shadow hover:bg-blue-500 px-4 py-2"
                                >
                                    Add
                                </button>
                            </form>
                        </div>
                        @foreach($project->tasks as $task)
                            <div class="bg-white rounded-lg shadow-lg py-3 px-3">
                                <form
                                    action="{{ route('tasks.update', [$project, $task]) }}"
                                    method="POST"
                                    class="flex justify-between items-center text-xl"
                                >
                                    @method('PUT')
                                    @csrf
                                    <input type="text" name="body" value="{{ $task->body }}" class="w-full">
                                    <input
                                        type="checkbox"
                                        name="completed"
                                        onchange="this.form.submit()"
                                    >
                                </form>
                            </div>
                        @endforeach
                    </div>

                    <h2 class="text-lg text-gray-400 mb-3">General notes</h2>
                    <form action="{{ route('projects.update', $project) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <textarea
                            name="notes"
                            class="h-40 w-full shadow-lg bg-white rounded-lg px-3 py-3"
                            placeholder="Anything of note here?"
                        >{{ $project->notes }}</textarea>
                        @error('notes')
                        <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                        <button
                            type="submit"
                            class="bg-blue-400 text-white rounded-lg shadow hover:bg-blue-500 px-4 py-2"
                        >Save changes
                        </button>
                    </form>

                </div>

                <div class="w-1/3">
                    <x-project-card :project="$project"/>
                </div>
            </div>

        </div>

        <div class="w-full lg:w-1/4 bg-gray-200 pl-4 pr-10 py-6 h-screen">
            Latest Updates
        </div>

    </div>
@endsection

