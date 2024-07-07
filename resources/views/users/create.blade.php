@extends('layout.index')
@section('content')
    <div id="user-form-container" class="mt-5">
        <x-form id="add-user-form" enctype="multipart/form-data"></x-form>
    </div>
    @vite("resources/js/user/addUser.js")

@endsection

