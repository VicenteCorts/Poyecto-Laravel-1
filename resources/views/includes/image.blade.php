<div class="card pub-image">
    <div class="card-header">
        @if($image->user->image)
        <div class='container-avatar'>
            <img src="avatares/{{$image->user->image}}" class="avatar"/>
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
            <img src="imagenes/{{$image->image_path}}"/>
        </div>

        <div class="description">
            <span class="nickname">{{'@'.$image->user->nick}}</span>
            <span class="nickname date">
                {{' | '. \FormatTime::LongTimeFilter($image->created_at)}}
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
