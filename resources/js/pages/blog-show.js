import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import { SplitText } from 'gsap/SplitText'
import { Autoplay, Pagination } from 'swiper/modules';

import Swiper from 'swiper'

// import Swiper styles
import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'

const swiper = new Swiper('.swiper', {
    modules: [Autoplay, Pagination],
    loop: true,
    spaceBetween: 30,
    centeredSlides: true,
    lazy: true,
    
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
        disableOnMouseEnter: true
    },
    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
    },
})

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