const selEl = element => document.querySelector(element);

const selAll = elements => Array.from(document.querySelectorAll(elements));

let slideIndex = 0;
showSlides();

function showSlides() {
   const SLIDES = selAll(".slideshow__slide");
   const TITLES = selAll(".slideshow__title");
   const TEXTS = selAll(".slideshow__text");
   const DOTS = selAll(".dot");

   SLIDES.forEach((slide, index) => {
      SLIDES[index].style.display = "none";
      TITLES[index].style.display = "none";
      TEXTS[index].style.display = "none";
   });

   slideIndex++;

   if (slideIndex > SLIDES.length) {
      slideIndex = 1;
   }
   DOTS.forEach((slide, index) => {
      DOTS[index].className = DOTS[index].className.replace(" active-dot", "");
      // TEXTS[index].className = TEXTS[index].className.replace(
      //    " inactive-text",
      //    ""
      // );
   });

   SLIDES[slideIndex - 1].style.display = "block";
   TITLES[slideIndex - 1].style.display = "block";
   TEXTS[slideIndex - 1].style.display = "block";
   DOTS[slideIndex - 1].className += " active-dot";
   // TEXTS[slideIndex - 1].className += " inactive-text";
   // Change image every x seconds
   // setTimeout(() => {
   //    SLIDES.forEach((slide, index) => {
   //       SLIDES[index].style.display = "none";
   //       TITLES[index].style.display = "none";
   //    });
   // }, 2000);
   setTimeout(showSlides, 7000);
}
