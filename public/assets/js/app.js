// A $( document ).ready() block.
$( document ).ready(function() {

 
  if  ($('.owl-carousel'))
  {

 
  $('.owl-carousel').owlCarousel({
    loop:true,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:false,
    animateOut: 'fadeOut',
    nav:true,
    margin:10,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:true,
            loop:true
        },
        600:{
            items:3,
            nav:true,
            loop:true
        },
        1000:{
            items:3,
            nav:true,
            loop:true
        }
    }
})
 
}

    $('body').on('change','#IngredientCat',function(){

        var idcategorie=($(this).val());

        $.ajax({
            method: "GET",
            url: "/ingredients",
            data: { categorie : idcategorie }
          })
            .done(function( html  ) {
             
              $( "body" ).empty().append( html );
            });



    })

    $('body').on('change','#RecettesCat',function(){

        var idcategorie=($(this).val());

        $.ajax({
            method: "GET",
            url: "/recettes",
            data: { categorie : idcategorie }
          })
            .done(function( html  ) {
             
              $( "body" ).empty().append( html );
            });



    })



});