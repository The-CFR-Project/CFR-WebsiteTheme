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
	var navlink = navlinks[c];
	var linktext = navlink.innerText;
	var txt = '<span class = "mobile-nav-link-container">' + linktext + '</span>';
	navlink.getElementsByTagName("a")[0].innerHTML = txt;
	document.getElementById("mobile-nav-container").innerHTML += navlink.innerHTML;
}
