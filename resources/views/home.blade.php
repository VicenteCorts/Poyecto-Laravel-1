@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @include('includes.message')
            @foreach ($images as $image)

            <div class="card pub-image">

                <div class="card-header">
                    @if($image->user->image)
                    <div class='container-avatar'>
                        <!--<img src="{{ route('user.avatar', ['filename' => $image->user->image])}}" class="avatar"/>-->
                        <img src="avatares/{{$image->user->image}}" class="avatar"/>
                        <?php // var_dump($image->user->image); ?>
                    </div>
                    @endif

                    <div class="data-user">
                        <a href="{{route('image.detail', ['id'=>$image->id])}}">
                            {{ $image->user->name.' '.$image->user->surname}}
                            <span class='nickname'>
                                {{' | @'.$image->user->nick }}
                            </span>
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="image-container">
                    <!--<img src="{{route('image.file', ['filename' => $image->image_path])}}"/>-->
                        <img src="imagenes/{{$image->image_path}}"/>
                        <?php // var_dump($image->image_path); ?>
                    </div>

                    <div class="description">
                        <span class="nickname">{{'@'.$image->user->nick}}</span>
                        <span class="nickname date">
                            <!--{{' | '.$image->created_at}}-->
                            <!--{{' | '. App\Helpers\FormatTime::LongTimeFilter($image->created_at)}}-->
                            {{' | '. \FormatTime::LongTimeFilter($image->created_at)}}
                            <!--{{' | '.\Carbon\Carbon::now()->diffForHumans($image->created_at)}}-->
                        </span>
                        <p>{{$image->description}}</p>
                    </div>

                    <div class="likes">
                        
                        <!--Detector de likes del usuario logeado-->
                        <?php $user_like = false; ?>
                        
                        @foreach($image->likes as $like)
                            @if($like->user->id == Auth::user()->id)
                               <?php $user_like = true; ?> 
                            @endif
                        @endforeach
                        
                        @if($user_like)
                            <img src="assets/heartred.png" data-id="{{$image->id}}" class="btn-dislike"/>
                        @else
                            <img src="assets/heartgray.png" data-id="{{$image->id}}" class="btn-like"/>
                        @endif
                        <span class="numer_likes">{{count($image->likes)}}</span>
                    </div>

                    <div class="comments">
                        <a href="" class="btn btn-sm btn-warning btn-comments">
                            Comentarios ({{count($image->comments)}})
                        </a>
                    </div>
                </div>  

            </div>

            @endforeach

            <!--PAGINACION-->
            <div class="clearfix"></div>
            {{$images->links()}}

        </div>        
    </div>
</div>
@endsection
