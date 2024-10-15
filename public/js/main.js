////VICTOR ROBLES
//window.addEventListener("load", function () {
////    alert("Página completamente carga");
////    COMPROBAR SI FUNCIONA JQUERY:
////    $('body').css('background', 'red');
//
//    $('.btn-like').css('cursor', 'pointer');
//    $('.btn-dislike').css('cursor', 'pointer');
//
//    //BOTON LIKE
//    function like() {
//        $('.btn-like').unbind('click').click(function () {
//            console.log('like');
//            $(this).addClass('btn-dislike').removeClass('btn-like');
//            $(this).attr('src', 'assets/heartred.png');
//            dislike();
//        });
//    }
//    like();
//
//    //BOTON DISLIKE
//    function dislike() {
//        $('.btn-dislike')unbind('click').click(function () {
//            console.log('dislike');
//            $(this).addClass('btn-like').removeClass('btn-dislike');
//            $(this).attr('src', 'assets/heartgray.png');
//            like();
//        });
//    }
//    dislike();
//});


//RANDOM DE LAS PREGUNTAS DE LA CLASE
 window.addEventListener("load", function(){
	$('.btn-like').css('cursor','pointer');
	$('.btn-dislike').css('cursor','pointer');
	$(document).on("click", ".btn-like", function(e){
                console.log('like');
		$(this).addClass('btn-dislike').removeClass('btn-like');
		$(this).attr('src', 'assets/heartred.png');
	});
	$(document).on("click", ".btn-dislike", function(e){
                console.log('dislike');
		$(this).addClass('btn-like').removeClass('btn-dislike');
		$(this).attr('src', 'assets/heartgray.png');
	});
});