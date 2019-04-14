@extends('layouts.app')
       
@section('content')  
       <div class="jumbortron text-center"> 
        <h1>Welcome to {{$title}}</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi alias assumenda hic deleniti id quod? Qui ullam, optio velit, pariatur fugiat molestiae exercitationem necessitatibus soluta tempora porro expedita veritatis nihil.</p>
        <p><a href="/login" role="button" class="btn btn-primary btn-lg">Login</a> <a href="/register" role="button" class="btn btn-success btn-lg">Register</a></p>
        </div>
@endsection