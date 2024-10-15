@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Mi perfil</h1>
            <hr/>
            
            @foreach ($user->images as $image)
                @include('includes.image', ['image' => $image])           
            @endforeach

        </div>        
    </div>
</div>
@endsection