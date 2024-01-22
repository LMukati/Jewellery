$(function() {
  var btn = $('.btns');
  $(window).scroll(function() {
    if ($(window).scrollTop() > 0) {
      btn.css("display","block",);
    } else {
      btn.css("display","none");
    }
  });
  btn.on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({scrollTop:0}, '300');
  });
});





// $(document).ready(function(){
//   // Add smooth scrolling to all links
//   $("a").on('click', function(event) {

//     // Make sure this.hash has a value before overriding default behavior
//     if (this.hash !== "") {
//       // Prevent default anchor click behavior
//       event.preventDefault();

//       // Store hash
//       var hash = this.hash;

//       // Using jQuery's animate() method to add smooth page scroll
//       // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
//       $('html, body').animate({
//         scrollTop: $(hash).offset().top
//       }, 800, function(){
   
//         // Add hash (#) to URL when done scrolling (default click behavior)
//         window.location.hash = hash;
//       });
//     } // End if
//   });
// });




/*puls circl script start*/
$(function() {
  $('.plus-minus-toggle').on('click', function() {
    $(this).toggleClass('collapsed');
  });
});

/*puls circl script end*/

$(document).ready(function(){

    $(".filter-button").click(function(){
        var value = $(this).attr('data-filter');
        
        if(value == "all")
        {
            //$('.filter').removeClass('hidden');
            $('.filter').show('1000');
        }
        else
        {
//            $('.filter[filter-item="'+value+'"]').removeClass('hidden');
//            $(".filter").not('.filter[filter-item="'+value+'"]').addClass('hidden');
            $(".filter").not('.'+value).hide('3000');
            $('.filter').filter('.'+value).show('3000');
            
        }
    });
    
    if ($(".filter-button").removeClass("active")) {
$(this).removeClass("active");
}
$(this).addClass("active");

});















$(document).ready(function() {
  
  // Find the initial scroll top when the page is loaded.
  var initScrollTop = $(window).scrollTop();
  
  // Set the image's vertical background position based on the scroll top when the page is loaded.
  $('.services-secn').css({'background-position-y' : (initScrollTop/75)+'%'});
  
  // When the user scrolls...
  $(window).scroll(function() {
    
    // Find the new scroll top.
    var scrollTop = $(window).scrollTop();
    
    // Set the new background position.
    $('.services-secn').css({'background-position-y' : (scrollTop/75)+'%'});
    
  });
  
});
// $('#special-fetr').owlCarousel({
// loop:true,
//     margin:25,
//     autoplay:true,
//     responsiveClass:true,
//     responsive:{
//         0:{
//             items:1,
//             nav:true
//         },
//         600:{
//             items:2,
//             nav:false
//         },
//         1000:{
//             items:4,
//             nav:true,
//             loop:false
//         }
//     }
     
// })


// $('.owl-carousel').owlCarousel({
//     loop:true,
//     margin:25,

//     responsiveClass:true,
//     responsive:{
//         0:{
//             items:1,
//             nav:true
//         },
//         600:{
//             items:3,
//             nav:false
//         },
//         1000:{
//             items:4,
//             nav:true,

//         }
//     }

// })



/*=========toggel menu script start========*/ 
$(document).ready(function(){
$(".sub-menu").hide();

$(".all-apnds").click(function(){
     $(this).next(".sub-menu").slideToggle("slow");
});
});
/*=========nav bar toggel menu script end========*/ 




/*==========product page script start========*/
    // <script type="text/javascript">
        $('#categorsv').owlCarousel({
    loop:true,
    margin:10,
     autoplay:true,
    responsiveClass:true,
    responsive:{
        0:{
            items:3,
            nav:true
        },
        600:{
            items:6,
            nav:false
        },
        1000:{
            items:11,
            nav:true,
            
        }
    }
})
    // </script>

/*==========product page script end========*/




/*==========product page script start========*/
    // <script type="text/javascript">
        $('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
     autoplay:true,
    responsiveClass:true,
    responsive:{
        0:{
            items:2,
            nav:true
        },
        600:{
            items:2,
            nav:false
        },
        1000:{
            items:7,
            nav:true,
        }
    }
})
    // </script>

/*==========product page script end========*/




/*=========side bar responsive menu script start========*/ 
function openLeftMenu() {
    document.getElementById("leftMenu").style.width = "100%";
  document.getElementById("leftMenu").style.display = "block";
}

function closeLeftMenu() {
  document.getElementById("leftMenu").style.display = "none";
}
/*=========side bar responsive menu  script end========*/ 



/*==========left sidde bar on profile page page script start========*/
function openLeftMenuPro() {
    document.getElementById("leftMenu1").style.width = "100%";
  document.getElementById("leftMenu1").style.display = "block";
}

function closeLeftMenuPro() {
  document.getElementById("leftMenu1").style.display = "none";
}
/*==========left sidde bar on profile page page script end========*/



/*==========read more script start========*/
$(document).ready(function(){
    var maxLength = 40;
    $(".show-read-more").each(function(){
        var myStr = $(this).text();
        if($.trim(myStr).length > maxLength){
            var newStr = myStr.substring(0, maxLength);
            var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
            $(this).empty().html(newStr);
            $(this).append(' <a href="javascript:void(0);" class="read-more">...</a>');
            $(this).append('<span class="more-text">' + removedStr + '</span>');
        }
    });
    $(".read-more").click(function(){
        $(this).siblings(".more-text").contents().unwrap();
        $(this).remove();
    });
});



/*==========read more script end========*/