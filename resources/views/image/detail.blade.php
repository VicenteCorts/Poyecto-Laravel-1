@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            @include('includes.message')

            <div class="card pub-image pub-image-detail">

                <div class="card-header">
                    @if($image->user->image)
                    <div class='container-avatar'>
                        <img src="<?= env('APP_URL') ?>/avatares/{{$image->user->image}}" class="avatar"/>
                    </div>
                    @endif
                    <div class="data-user">
                        <a href="{{route('profile', ['id'=>$image->user->id])}}">
                            {{ $image->user->name.' '.$image->user->surname}}
                            <span class='nickname'>{{' | @'.$image->user->nick }}</span>
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="image-container image-detail">
                        <img src="<?= env('APP_URL') ?>/imagenes/{{$image->image_path}}"/>
                    </div>

                    <div class="description">
                        <span class="nickname">{{'@'.$image->user->nick}}</span>
                        <span class="nickname date">{{' | '. \FormatTime::LongTimeFilter($image->created_at)}}</span>
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

                    <!--BOTONES DE ELIMINAR Y EDITAR-->
                    @if(Auth::user() && Auth::user()->id == $image->user->id)
                    <div class="actions">
                        <a href="" class="btn btn-sm btn-primary">Actualziar</a>

                        <!--MODAL DE BOOTSTRAP PARA BORRAR IMAGEN-->
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModal">
                            Borrar
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Borrar Imagen</h5>
                                        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>-->
                                    </div>
                                    <div class="modal-body">
                                        <p>Estás a punto de borrar esta imagen, sus comentarios y sus likes ¿Estás seguro de que quieres continuar?</p>
                                        <p> No habrá marcha atrás</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <a href="{{route('image.delete', ['id'=>$image->id])}}" class="btn btn-danger">Borrar Definitivamente</a>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    @endif

                    <div class="clearfix"></div>
                    <div class="comments">
                        <h2>Comentarios ({{count($image->comments)}})</h2>
                        <hr>

                        <form action="{{route('comment.save')}}" method="POST">
                            @csrf
                            <input type="hidden" name="image_id" value="{{$image->id}}"/>
                            <p>
                                <textarea class="form-control {{$errors->has('content') ? 'is-invalid' : ''  }}" name="content"></textarea>
                                @if($errors->has('content'))
                                <span class='invalid-feedback' role='alert'>
                                    <strong>{{$errors->first('content')}}</strong>
                                </span>
                                @endif
                            </p>
                            <button type="submit" class="btn btn-success">
                                Enviar
                            </button>
                        </form>
                        <hr>
                        @foreach($image->comments as $comment)
                        <div class="comment">
                            <span class="nickname">{{'@'.$comment->user->nick}}</span>
                            <span class="nickname date">{{' | '. \FormatTime::LongTimeFilter($comment->created_at)}}</span>
                            <p>{{$comment->content}}<br>

                                <!--Boton para borrar comentarios-->
                                @if (Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                                <a href="{{route('comment.delete', ['id' => $comment->id])}}" class="btn btn-sm btn-danger">
                                    Eliminar
                                </a>
                                @endif
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>        
    </div>
</div>
@endsection