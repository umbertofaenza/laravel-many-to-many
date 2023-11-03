@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-3">Editing: {{ $project->name }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                Error(s):

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-6">
                Image
                @if ($project->image)
                    <div>
                        <img src="{{ asset('/storage/' . $project->image) }}" alt="" class="img-fluid">
                    </div>

                    {{-- delete image form --}}
                    @if ($project->image)
                        <form method="POST" action="{{ route('admin.projects.delete-image', $project) }}"
                            id="delete-image-form">
                            @method('DELETE')
                            @csrf

                            <button class="btn btn-outline-danger mt-1 p-1" id="delete-image-btn">Remove image</button>
                        </form>
                    @endif
                @else
                    <div>
                        No image uploaded.
                    </div>
                @endif
            </div>

            <div class="col-6"></div>
        </div>

        <form action="{{ route('admin.projects.update', $project) }}" method="POST" class="row g-3 my-3"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="col-6">
                <label for="name">Project name</label>
                <input type="text" id="name" name="name" class="form-control"
                    value="{{ old('name', $project->name) }}">
            </div>

            <div class="col-6">
                <label for="link">Link</label>
                <input type="text" id="link" name="link" class="form-control"
                    value="{{ old('link', $project->link) }}">
            </div>

            <div class="col-6">
                <label for="type_id" class="form-label">Type</label>
                <select name="type_id" id="type_id" class="form-select">
                    <option value="">No type</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}" @if (old('type_id') ?? $project->type_id == $type->id) selected @endif>
                            {{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-6">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control">{{ old('description', $project->description) }}</textarea>
            </div>

            <div class="col-6">
                <div class="form-check">
                    <div>Technologies</div>
                    @foreach ($technologies as $technology)
                        <input type="checkbox" name="technologies[]" id="technology-{{ $technology->id }}"
                            value="{{ $technology->id }}" @if (in_array($technology->id, old('technologies') ?? $project_technologies)) checked @endif>
                        <label for="technology-{{ $technology->id }}" class="me-3">{{ $technology->name }}</label>
                    @endforeach
                </div>
            </div>

            <div class="col-6">
                <label for="image">Upload / Change image</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <div class="col">
                <button class="btn btn-success">Edit</button>
            </div>
        </form>

        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-primary">Go back to list</a>
    </div>

    @if ($project->image)
        <script>
            const deleteImageBtn = document.getElementById('delete-image-btn')
            const deleteImageForm = document.getElementById('delete-image-form')

            deleteImageBtn.addEventListener('click', function() {
                deleteImageForm.submit()
            })
        </script>
    @endif
@endsection
