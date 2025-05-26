function slideInterval() {
    
    const slide = document.querySelector('#carousel');
    const carousel = new bootstrap.Carousel(slide);
    
    let interval = setInterval(() => {
        carousel.next();
    }, 3000);
    
    slide.addEventListener("mouseenter", function (){
        clearInterval(interval);
    });
    slide.addEventListener("mouseleave", function (){
        interval = setInterval(() => {
            carousel.next();
        }, 3000);
    });
}

slideInterval();