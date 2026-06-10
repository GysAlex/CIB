import gsap from 'gsap'
import { SplitText } from 'gsap/SplitText'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import { Autoplay, Pagination, Navigation, Thumbs } from 'swiper/modules';

import Swiper from 'swiper'

// import Swiper styles
import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'


Swiper.use([Navigation, Thumbs, Pagination, Autoplay])

var swiper1 = new Swiper(".mySwiper", {
    spaceBetween: 10,
    slidesPerView: 3,
    loop: true,
    watchSlidesProgress: true,
    freeMode: true,
    direction: 'horizontal',
    breakpoints: {
        768:{
            direction: "vertical"
        },

        400:{
            slidesPerView: 3
        },

        300: {
            slidesPerView: 2
        }

    },    
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
        disableOnMouseEnter: true
    },

})

var swiper2 = new Swiper(".mySwiper2", {
    spaceBetween: 10,
    loop: true,

    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },

    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
        disableOnMouseEnter: true
    },

    thumbs:{
        swiper: swiper1,
        slideThumbActiveClass: 'swiper-slide-thumb-active'
    }
})

const swiper = new Swiper('.myFirstSwiper', {
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

gsap.registerPlugin(SplitText)
gsap.registerPlugin(ScrollTrigger)

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

function heroAnimation() {
    const section = document.getElementById('hero')

    const tl = gsap.timeline({ defaults: { ease: "power4.out" } })
    tl.from(".hero-badge", {
        y: -20,
        opacity: 0,
        duration: 0.8
    })

    const mainText = section.querySelector('h1')

    const secondText = section.querySelector('p')

    const titleSplit = SplitText.create(mainText, { type: "words" })
    const secondSplit = SplitText.create(secondText, { type: "lines" })


    tl
        .from(titleSplit.words, {
            y: 60,
            opacity: 0,
            rotateX: -30,
            stagger: 0.2,
            duration: 1.2
        }, "-=0.4")
        .from(secondSplit.lines, {
            y: "100%",
            opacity: 0,
            stagger: 0.1,
            duration: 1
        }, "-=0.8")

}

document.addEventListener('DOMContentLoaded', () => {
    heroAnimation()
    headerAnimation()
})