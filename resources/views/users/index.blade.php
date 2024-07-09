@extends('layout.index')

@section('content')
    @if(isset($_COOKIE['success']))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong>User  created!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div id="user-list"></div>
    <x-show-more-users id="pagination-controls" class="mt-3" >Show more</x-show-more-users>
    <div class="container" >
        <div class="positions">
        </div>
        <div class="row custom-row">
        </div>
        <div class="pagination">
        </div>
    </div>
@vite('resources/js/user/user.js')
@endsection



