// Ratings Functions
function starRating(value) {
    var averageRate = Math.round(value * 2) / 2;
    const star = {
        0   : 'images/starRating/0_Star.png',
        0.5 : 'images/starRating/0.5_Star.png',
        1   : 'images/starRating/1_Star.png',
        1.5 : 'images/starRating/1.5_Star.png',
        2   : 'images/starRating/2_Star.png',
        2.5 : 'images/starRating/2.5_Star.png',
        3   : 'images/starRating/3_Star.png',
        3.5 : 'images/starRating/3.5_Star.png',
        4   : 'images/starRating/4_Star.png',
        4.5 : 'images/starRating/4.5_Star.png',
        5   : 'images/starRating/5_Star.png',
    };
    return star[averageRate];
}

function averageRate() {
    let ratings = [4.8, 3.5, 5.0]; // Demo Data - Please update
    let average = ratings.reduce((a, b) => a + b, 0) / ratings.length;

    //Outputting the Star Rating to productpage
    let resImg = document.getElementById('reviews_Img');
    resImg.innerHTML = "";
    let img = document.createElement('img');
    img.src = starRating(average);
    resImg.appendChild(img);
}

function reviewText(username, rating, review) {
    let resText = document.getElementById('reviews_Text');
    let img = document.createElement('img');
    img.src = starRating(rating);

    resText.appendChild(document.createTextNode(username));
    resText.appendChild(document.createElement('br'));
    resText.appendChild(img);
    resText.appendChild(document.createElement('br'));
    resText.appendChild(document.createTextNode(review));
    resText.appendChild(document.createElement('hr'));
}

// Slideshow Functions
let slideIndex = 1;
let slideTimer;

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");

    if (n > slides.length) { slideIndex = 1; }
    if (n < 1) { slideIndex = slides.length; }

    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }

    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
}

function startAutoPlay() {
    slideTimer = setInterval(function() { plusSlides(1); }, 10000);
}

function stopAutoPlay() {
    clearInterval(slideTimer);
}

// Run when page loads
document.addEventListener("DOMContentLoaded", function() {
    //For demo purposes
    averageRate();
    reviewText('Olivia Brown', 4.8, 'This liquid foundation is amazing! It blends seamlessly, gives a natural glow, and lasts all day without feeling heavy.');
    reviewText('Hannah Wilson', 3.5, 'The eyeshadow palette has gorgeous shades, but some colors don’t have great pigmentation. Works well with primer though.');
    reviewText('Sophia Martinez', 5.0, 'Absolutely love this matte lipstick! The color payoff is incredible, it doesn’t dry my lips, and it stays put even after eating.');

    //Image Slideshow
    showSlides(slideIndex);
    startAutoPlay();

    let slideshow = document.querySelector(".slideshow-container");
    slideshow.addEventListener("mouseenter", stopAutoPlay);
    slideshow.addEventListener("mouseleave", startAutoPlay);
});
