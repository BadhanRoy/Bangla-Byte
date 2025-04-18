let slideIndex = 0;
let slides = document.getElementsByClassName("mySlides");

function showSlides() {
    // Remove active class from all slides
    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove("active");
    }

    // Increase index, reset if it exceeds slide count
    slideIndex++;
    if (slideIndex > slides.length) {
        slideIndex = 1;
    }
    let currentSlide = slides[slideIndex - 1];

    //background image from data attribute
    let bgImage = currentSlide.getAttribute("data-bg");
    currentSlide.style.backgroundImage = `linear-gradient(45deg, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.3)), url('${bgImage}')`;

    // current slide visible
    currentSlide.classList.add("active");

    // Wait for 10 seconds before showing the next slide
    setTimeout(showSlides, 10000);
}

// Start the slideshow
showSlides();