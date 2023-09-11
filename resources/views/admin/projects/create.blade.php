@extends('layouts.app')

@section('content')
    {{-- Section Header --}}
    <header class="d-flex justify-content-between align-items-center mt-5">
        <h2>Create new project</h2>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Back</a>
    </header>

    @include('includes.projects.form')
@endsection
