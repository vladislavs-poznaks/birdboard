@extends('layouts.app')

@section('content')
    <div class="px-6 py-4">
        <div class="flex items-center mb-4">
            <a href="{{ route('projects.create') }}">New Project</a>
        </div>

        @foreach($projects as $project)
            <div>
                <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
            </div>
        @endforeach

    </div>
@endsection
