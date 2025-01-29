let currentSlideIndex = 0;

function showSlide(index) {
    const slides = document.querySelectorAll('.slide');
    if (index >= slides.length) {
        currentSlideIndex = 0;
    }
    if (index < 0) {
        currentSlideIndex = slides.length - 1;
    }
    slides.forEach(slide => (slide.style.display = 'none'));
    slides[currentSlideIndex].style.display = 'block';
}

function changeSlide(direction) {
    currentSlideIndex += direction;
    showSlide(currentSlideIndex);
}

// Initialize the slideshow
showSlide(currentSlideIndex);

// Auto-slide every 5 seconds
setInterval(() => {
    changeSlide(1);
}, 5000);
