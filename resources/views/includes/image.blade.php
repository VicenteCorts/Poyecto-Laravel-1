<div class="card pub-image">

    <div class="card-header">
        @if($image->user->image)
        <div class='container-avatar'>
            <!--<img src="{{ route('user.avatar', ['filename' => $image->user->image])}}" class="avatar"/>-->
            <img src="<?= env('APP_URL') ?>/avatares/{{$image->user->image}}" class="avatar"/>
            <?php // var_dump($image->user->image); ?>
        </div>
        @endif

        <div class="data-user">
            <a href="{{route('profile', ['id'=>$image->user->id])}}">
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
            <img src="<?= env('APP_URL') ?>/imagenes/{{$image->image_path}}"/>
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
                <img src="<?= env('APP_URL') ?>/assets/heartred.png" data-id="{{$image->id}}" class="btn-dislike"/>
            @else
                <img src="<?= env('APP_URL') ?>/assets/heartgray.png" data-id="{{$image->id}}" class="btn-like"/>
            @endif
            <span class="numer_likes">{{count($image->likes)}}</span>
        </div>

        <div class="comments">
            <a href="{{route('image.detail', ['id'=>$image->id])}}" class="btn btn-sm btn-warning btn-comments">
                Comentarios ({{count($image->comments)}})
            </a>
        </div>
    </div>  

</div>
