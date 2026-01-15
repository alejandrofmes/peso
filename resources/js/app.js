import "./bootstrap"; // Ensure this is the first import
import "preline";
// import Alpine from 'alpinejs';
import "flyonui/flyonui.js";

// window.Alpine = Alpine;
// Alpine.start();
import KeenSlider from "https://cdn.jsdelivr.net/npm/keen-slider@6.8.6/+esm";

const keenSlider = new KeenSlider(
    "#keen-slider",
    {
        loop: true,
        slides: {
            origin: "auto",
            perView: 1,
            spacing: 12,
        },
        breakpoints: {
            "(min-width: 1024px)": {
                slides: {
                    origin: "auto",
                    perView: 2.65,
                    spacing: 32,
                },
            },
        },
    },
    []
);

const keenSliderPrevious = document.getElementById("keen-slider-previous");
const keenSliderNext = document.getElementById("keen-slider-next");

const keenSliderPreviousDesktop = document.getElementById(
    "keen-slider-previous-desktop"
);
const keenSliderNextDesktop = document.getElementById(
    "keen-slider-next-desktop"
);

keenSliderPrevious.addEventListener("click", () => keenSlider.prev());
keenSliderNext.addEventListener("click", () => keenSlider.next());

keenSliderPreviousDesktop.addEventListener("click", () => keenSlider.prev());
keenSliderNextDesktop.addEventListener("click", () => keenSlider.next());
