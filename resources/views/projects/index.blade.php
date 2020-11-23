@foreach($projects as $project)
    <div>
        <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
    </div>
@endforeach
