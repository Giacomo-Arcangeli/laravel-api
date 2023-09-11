@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center mt-5">
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-4">
                    <img src="{{ $project->cover ? asset('storage/' . $project->cover) : 'https://marcolanci.it/utils/placeholder.jpg' }}"
                        class="img-fluid h-100" alt="{{ $project->title }}">
                </div>
                <div class="col-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $project->title }}</h5>
                        <p class="card-text"><small class="text-body-secondary">{{ $project->year }}</small></p>
                        <p class="card-text">{{ $project->description }}</p>
                        <p class="card-text"><strong>Type:</strong>
                            {{ $project->type ? $project->type->label : 'Undefined' }}
                        </p>
                        <p class="card-text"><strong>Technologies:</strong>
                            @forelse ($project->technologies as $technology)
                                {{ $technology->label }}
                            @empty
                                Undefined
                            @endforelse
                        </p>
                        <p class="card-text"><strong>Created at:</strong> {{ $project->getCreatedAt() }}</p>
                        <p class="card-text"><strong>Updated at:</strong> {{ $project->getUpdatedAt() }}</p>
                        <div class="buttons d-flex gap-1">
                            <a class="btn btn-primary" href="{{ route('admin.projects.index') }}">Back</a>
                            <a class="btn btn-warning" href="{{ route('admin.projects.edit', $project) }}">Edit</a>
                            {{-- delete --}}
                            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
