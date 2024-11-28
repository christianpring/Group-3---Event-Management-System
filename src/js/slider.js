  const slider = document.querySelector('.slider-container');
  const slides = document.querySelectorAll('.slide');
  const prev = document.querySelector('.prev');
  const next = document.querySelector('.next');

  let currentIndex = 0;

  function updateSliderPosition() {
    slider.style.transform = `translateX(-${currentIndex * 100}%)`;
  }

  prev.addEventListener('click', () => {
    currentIndex = (currentIndex > 0) ? currentIndex - 1 : slides.length - 1;
    updateSliderPosition();
  });

  next.addEventListener('click', () => {
    currentIndex = (currentIndex < slides.length - 1) ? currentIndex + 1 : 0;
    updateSliderPosition();
  });

  
  setInterval(() => {
    currentIndex = (currentIndex < slides.length - 1) ? currentIndex + 1 : 0;
    updateSliderPosition();
  }, 5000); 