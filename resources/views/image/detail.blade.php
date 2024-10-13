@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            @include('includes.message')

            <div class="card pub-image">

                <div class="card-header">
                    @if($image->user->image)
                    <div class='container-avatar'>
                        <img src="<?=env('APP_URL')?>/avatares/{{$image->user->image}}" class="avatar"/>
                    </div>
                    @endif
                    <div class="data-user">
                        {{ $image->user->name.' '.$image->user->surname}}
                        <span class='nickname'>{{' | @'.$image->user->nick }}</span>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="image-container">
                        <img src="<?=env('APP_URL')?>/imagenes/{{$image->image_path}}"/>
                    </div>

                    <div class="description">
                        <span class="nickname">{{'@'.$image->user->nick}}</span>
                        <span class="nickname date">{{' | '. \FormatTime::LongTimeFilter($image->created_at)}}</span>
                        <p>{{$image->description}}</p>
                    </div>

                    <div class="likes">
                        <img src="<?=env('APP_URL')?>/assets/heartgray.png" />
                    </div>

                    <div class="comments">
                        <a href="" class="btn btn-sm btn-warning btn-comments">
                            Comentarios ({{count($image->comments)}})
                        </a>
                    </div>
                </div>
                
            </div>
        </div>        
    </div>
</div>
@endsection