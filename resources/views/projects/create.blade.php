@extends('layouts.app')

@section('content')
    <form
        method="POST"
        action="{{ route('projects.store') }}"
        class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow mt-6"
    >
        @csrf

        <h1 class="text-2xl font-normal mb-10 text-center">
            Let’s start something new
        </h1>

        @include('projects.form')

        <div class="field">
            <div class="control">
                <button type="submit" class="button is-link mr-2">Create Project</button>
                <a href="/projects">Cancel</a>
            </div>
        </div>
    </form>
@endsection

