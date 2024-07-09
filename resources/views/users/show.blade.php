@extends('layout.index')

@section('content')
    <div class="container">
        <div class="card card-profile">
            <img src="{{$user->photo}}" class="card-img-top" alt="User Photo">
            <div class="card-body">
                <h5 class="card-title"><strong>Name: </strong>{{$user->name}}</h5>
                <p class="card-text"><strong>Email: </strong>{{$user->email}}</p>
                <p class="card-text"><strong>Phone: </strong>{{$user->phone}}</p>
                <p class="card-text"><strong>Position: </strong>{{$user->position->name}}</p>
            </div>
        </div>
    </div>
@endsection
