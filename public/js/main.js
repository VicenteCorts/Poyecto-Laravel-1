//VICTOR ROBLES
var url ='http://proyecto-laravel.com.devel/';
window.addEventListener("load", function () {
//    alert("Página completamente carga");
//    COMPROBAR SI FUNCIONA JQUERY:
//    $('body').css('background', 'red');

    $('.btn-like').css('cursor', 'pointer');
    $('.btn-dislike').css('cursor', 'pointer');

    //BOTON LIKE
    function like() {
        $('.btn-like').unbind('click').click(function () {
            console.log('like');
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src', 'assets/heartred.png');
            
            $.ajax({
                url: url+'like/'+$(this).data('id'),
                type: 'GET',
                success: function(response){
                    if(response.like){
                      console.log('Has dado like');  
                    }else{
                        console.log('Error al dar like'); 
                    }
                }
            });
            
            dislike();
        });
    }
    like();

    //BOTON DISLIKE
    function dislike() {
        $('.btn-dislike').unbind('click').click(function () {
            console.log('dislike');
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src', 'assets/heartgray.png');
            
                        $.ajax({
                url: url+'dislike/'+$(this).data('id'),
                type: 'GET',
                success: function(response){
                    if(response.like){
                      console.log('Has dado dislike');  
                    }else{
                        console.log('Error al dar dislike'); 
                    }
                }
            });
            
            like();
        });
    }
    dislike();
});


////RANDOM DE LAS PREGUNTAS DE LA CLASE
// window.addEventListener("load", function(){
//	$('.btn-like').css('cursor','pointer');
//	$('.btn-dislike').css('cursor','pointer');
//	$(document).on("click", ".btn-like", function(e){
//                console.log('like');
//		$(this).addClass('btn-dislike').removeClass('btn-like');
//		$(this).attr('src', 'assets/heartred.png');
//	});
//	$(document).on("click", ".btn-dislike", function(e){
//                console.log('dislike');
//		$(this).addClass('btn-like').removeClass('btn-dislike');
//		$(this).attr('src', 'assets/heartgray.png');
//	});
//});