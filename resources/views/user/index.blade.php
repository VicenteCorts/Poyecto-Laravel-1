@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Gente</h1>
            <hr/>
            @foreach ($users as $user)
            <div class="profile-user">
                @if($user->image)
                <div class='container-avatar'>
                    <img src="<?= env('APP_URL') ?>/avatares/{{$user->image}}" class="avatar"/>
                </div>
                @endif

                <div class="user-info">
                    <h2>{{'@'.$user->nick}}</h2>
                    <h3>{{$user->name.' '.$user->surname}}</h3>
                    <p><span class="nickname date">{{'Se unió: '. \FormatTime::LongTimeFilter($user->created_at)}}</span></p>
                    <a href="{{route('profile' , ['id' => $user->id])}}" class="btn btn-success">Ver Perfil</a>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr/>
            @endforeach

            <!--PAGINACION-->
            <div class="clearfix"></div>
            {{$users->links()}}

        </div>        
    </div>
</div>
@endsection
