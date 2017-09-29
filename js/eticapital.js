var navbar = $('#navbarheader');
var logo = $('#navbarheader #logo');
var anchor = $("#navbaranchor").offset().top-100;

$(window).scroll(function(){
  var scrollTop = $(window).scrollTop();
  if(scrollTop > anchor){
    navbar.removeClass("navbar-dark pt-3 px-0").addClass( "navbar-light bg-white fixed-top" );
    logo.attr("src", "img/logodark.png");
  }
  else if (scrollTop <= anchor) {
    navbar.removeClass("navbar-light bg-white fixed-top").addClass( "navbar-dark pt-3 px-0" );
    logo.attr("src", "img/logolight.png");
  }
});
