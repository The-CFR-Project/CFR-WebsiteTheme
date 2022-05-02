var headerSlideIndex = 0;
var resetCarousel = 0;

reloadSlideshow(headerSlideIndex);
carousel();

function changeHeaderSlideshow(n) {
    reloadSlideshow(headerSlideIndex + n);
    resetCarousel = 2;
}

function setHeaderSlideshow(n) {
    reloadSlideshow(n);
    resetCarousel = 2;
}

function reloadSlideshow(n) {
    var i;
    var headerSlides = document.getElementsByClassName("header-slide");
    var headerSlideDots = document.getElementsByClassName("header-slideshow-dot");

    if (n >= headerSlides.length) {
        headerSlideIndex = 0;
    }
    else if (n < 0) {
        headerSlideIndex = headerSlides.length - 1;
    }
    else {
        headerSlideIndex = n;
    }

    for (i = 0; i < headerSlides.length; i++) {
        headerSlides[i].style.display = "none";
        headerSlideDots[i].className = "header-slideshow-dot";
    }

    headerSlides[headerSlideIndex].style.display = "block";
    headerSlideDots[headerSlideIndex].className += " header-slideshow-dot-active";
}

function carousel() {
    if (resetCarousel > 0) {
        resetCarousel -= 1;
    }
    else if (document.activeElement.id !== "read-more") {
        reloadSlideshow(headerSlideIndex + 1)
    }
    //setTimeout(carousel, 4000); // Change image every 4 seconds
}