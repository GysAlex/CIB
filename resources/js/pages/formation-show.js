import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import { SplitText } from 'gsap/SplitText'


gsap.registerPlugin(ScrollTrigger)
gsap.registerPlugin(SplitText)
function headerAnimation() {

    const headerBg = document.querySelector('.h-bg2');

    const heroSection = document.querySelector('.hero-section');

    if (!headerBg || !heroSection) return;

    gsap.to(headerBg, {
        width: "113%",
        height: "100%",
        top: 0,
        backgroundColor: "rgba(255, 255, 255, 0.8)",
        borderRadius: 0,
        ease: "none",
        scrollTrigger: {
            trigger: heroSection,
            start: "top top",
            end: "bottom top",
            scrub: true,
            // markers: true,     
        }
    });


}


document.addEventListener('DOMContentLoaded', () => {
    headerAnimation()
})