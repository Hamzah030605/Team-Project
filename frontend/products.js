// --- Review and Rating Functions ---

// Function to convert numerical rating to Unicode stars
function starRating(value) {
    // Rounds to the nearest half star
    const roundedRating = Math.round(value * 2) / 2;
    let stars = '';
    const fullStar = '★';
    const halfStar = '½';
    const emptyStar = '☆';

    let remaining = roundedRating;
    
    // Add full stars
    for (let i = 0; i < Math.floor(roundedRating); i++) {
        stars += fullStar;
        remaining--;
    }
    
    // Add half star if applicable
    if (remaining === 0.5) {
        stars += halfStar;
        remaining = 0;
    }
    
    // Add empty stars to complete 5 total
    while (stars.length < 5) {
        stars += emptyStar;
    }

    return `<span class="star-rating">${stars}</span>`;
}

// Function to calculate and display average rating
function averageRate() {
    let ratings = [4.8, 3.5, 5.0, 4.0, 2.5]; // Demo Data
    let total = ratings.reduce((a, b) => a + b, 0);
    let average = ratings.length > 0 ? total / ratings.length : 0;

    let resImg = document.getElementById('reviews_Img');
    if (resImg) {
        resImg.innerHTML = `
            Average Rating: ${average.toFixed(1)} / 5
            ${starRating(average)}
        `;
    }
}

// Function to display individual review text
function reviewText(username, rating, review) {
    let resText = document.getElementById('reviews_Text');
    if (resText) {
        const reviewDiv = document.createElement('div');
        reviewDiv.classList.add('review-text');

        reviewDiv.innerHTML = `
            <p><strong>${username}</strong></p>
            ${starRating(rating)}
            <p>${review}</p>
        `;
        resText.appendChild(reviewDiv);
    }
}

// --- Slideshow Functions ---
let slideIndex = 1;
// Removed: let slideTimer;

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");

    if (slides.length === 0) return;

    if (n > slides.length) { slideIndex = 1; }
    if (n < 1) { slideIndex = slides.length; }

    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (let i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }

    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
}

// Removed: startAutoPlay and stopAutoPlay functions

// Run when page loads
document.addEventListener("DOMContentLoaded", function() {
    // Run review functions with demo data
    averageRate();
    reviewText('Olivia Brown', 4.8, 'This liquid foundation is amazing! It blends seamlessly, gives a natural glow, and lasts all day without feeling heavy.');
    reviewText('Hannah Wilson', 3.5, 'The eyeshadow palette has gorgeous shades, but some colors don’t have great pigmentation. Works well with primer though.');
    reviewText('Sophia Martinez', 5.0, 'Absolutely love this matte lipstick! The color payoff is incredible, it doesn’t dry my lips, and it stays put even after eating.');

    // Image Slideshow setup
    showSlides(slideIndex);

    //Modal setup -- KEEP THIS - Extra Marks
    const modal = document.getElementById("imgModal");
    const modalImg = document.getElementById("modalImg");
    const captionText = document.getElementById("caption");
    const closeBtn = document.querySelector(".close");
    const navBar = document.getElementById("navBarID")

    document.querySelectorAll(".mySlidesImgs").forEach(img => {
        img.addEventListener("click", () => {
            modal.style.display = "block";
            modalImg.src = img.src;
            //captionText.innerHTML = img.alt || img.id;
            navBar.style.display = "none";
        });
    });
    closeBtn.onclick = () => {
        modal.style.display = "none";
        navBar.style.display = "block";
    };

    modal.onclick = (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
            navBar.style.display = "block";
        }
    }
});

// Add slideshow container
const slideshowContainer = document.createElement('div');
slideshowContainer.className = 'slideshow-container';
document.body.appendChild(slideshowContainer);
