jQuery(function($) {
  $(document).on('click', 'a[href^="#"]', function (event) {
    event.preventDefault();

    $('html, body').animate({
	 scrollTop: $($.attr(this, 'href')).offset().top
    }, 500);
});
});
var hamburger = '<div id = "hamburger-container"><button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#sidenav" id = "hamburger">≡</button></div>';
let container = document.getElementsByClassName("nav-header-container")[0];
container.innerHTML += hamburger;
//Change project name in navbar to "CFR Project" on small screens
function setCFR(x) {
	if(x.matches){ // If media query matches
		document.getElementById("navbar-title").innerHTML = "CFR Project";
	}else{
		document.getElementById("navbar-title").innerHTML = "The Carbon Footprint Reduction Project";
	}
}
var mediawatch = window.matchMedia("(max-width: 786px)");
setCFR(mediawatch);
mediawatch.addListener(setCFR);
var navlinks = document.getElementById("menu-navigation-bar").getElementsByTagName("li");
for (let c = 0; c < navlinks.length; c++){
	var linktext = navlinks[c].innerHTML;
	document.getElementById("mobile-nav-container").innerHTML += "<span class = 'mobile-nav-link-container'>" + linktext + "</span>";
}
jQuery(document).on('swipeleft', '#container-fluid', function(event){
	changeHeaderSlideshow(-1);
	console.log("Hello");
});
jQuery(document).on('swiperight', '#container-fluid', function(event){
	changeHeaderSlideshow(1);
});
/*
function mob_nav(x){
	if (x.matches){
		 var lastScrollTop = 0;
		 window.addEventListener("scroll", function(){
			  var st = window.pageYOffset || document.documentElement.scrollTop;
			  if (st - lastScrollTop > 15){
				   document.getElementById("topnav").style.top = "-100px";
			  }else {
				   if (lastScrollTop - st > 15){
					    document.getElementById("topnav").style.top = "0px";
						}
			  if (document.body.scrollTop === 0){
				   document.getElementById("topnav").style.top = "0px";
			  }
		    }
		    lastScrollTop = st <= 0 ? 0 : st;
		 }, false);
	}
	else{
		document.getElementById('sidenav').className='hide collapse';
	}
}
mob_nav(mediawatch);
mediawatch.addListener(mob_nav);*/
