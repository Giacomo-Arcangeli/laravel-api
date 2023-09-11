{{-- Session Alert --}}
@if (session('alert-message'))
    <div class="alert alert-{{ session('alert-type') }} alert-dismissible fade show my-2" role="alert">
        {{ session('alert-message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
