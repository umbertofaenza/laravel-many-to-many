@extends('layouts.app')


@section('content')
    <div class="container my-5">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-primary mb-3">Back to list</a>

        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-outline-warning mb-3">Edit project</a>

        <h1 class="mb-5">{{ $project->name }}</h1>

        <div class="row g-5">
            <div class="col-6">
                <h4>id:</h4>
                {{ $project->id }}
            </div>
            <div class="col-6">
                <h4>Type:</h4>
                {{ $project->type ? $project->type->name : 'No type.' }}
            </div>
            <div class="col-6">
                <h4>Link:</h4>
                {{ $project->link }}
            </div>
            <div class="col-6">
                <h4>Slug:</h4>
                {{ $project->slug }}
            </div>
            <div class="col-12">
                <h4>Description:</h4>
                {{ $project->description }}
            </div>
        </div>

    </div>
@endsection
