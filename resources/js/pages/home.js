import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import { SplitText } from 'gsap/SplitText'


gsap.registerPlugin(ScrollTrigger)
gsap.registerPlugin(SplitText)


function headerAnimation() {
    const headerBg = document.querySelector('.h-bg');
    const heroSection = document.querySelector('.hero-section');

    if (!headerBg || !heroSection) return;

    gsap.to(headerBg, {
        width: "105%",
        height: "100%",
        top: 0,
        backgroundColor: "rgba(3, 3, 32, 0.6)",
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
    const tl = gsap.timeline({ defaults: { ease: "power4.out" } });

    const mainText = SplitText.create('.mainText', { type: "lines, words", })
    const secondText = SplitText.create('.secondText', { type: "lines", })
    const mainCta = document.getElementById('main-cta')

    tl.from(mainText.words, {
        opacity: 0,
        rotateX: 150,
        duration: 1.2,
        stagger: 0.3,
    })
        .from(secondText.lines, {
            duration: 0.5,
            yPercent: 100,
            opacity: 0,
            stagger: 0.1,
        }, "-=0.8")
        .from(mainCta, {
            scale: 0.8,
            opacity: 0,
            y: 20,
            duration: 0.8,
            ease: "back.out(1.7)"
        }, "-=0.5")
}

function aboutAnimation() {
    const aboutSection = document.getElementById('about')

    const aboutTl = gsap.timeline({
        scrollTrigger: {
            trigger: aboutSection,
            start: "top 40%",
            toggleActions: "play none none reverse"
        }
    });
    const aboutTitle = SplitText.create('.about-title', { type: "lines", })

    aboutTl.from(aboutTitle.lines, {
        y: 100,
        opacity: 0,
        duration: 1,
        stagger: 0.1,
        ease: "power4.out"
    })

    aboutTl.from(".stat", {
        y: 30,
        opacity: 0,
        duration: 0.8,
        stagger: 0.2,
        ease: "power3.out"
    }, "-=0.5");

    document.querySelectorAll('[data-target]').forEach((obj) => {
        const targetValue = parseFloat(obj.getAttribute('data-target'));

        aboutTl.to(obj, {
            innerText: targetValue,
            duration: 2,
            snap: { innerText: targetValue % 1 === 0 ? 1 : 0.1 },
            ease: "power2.out",
            onUpdate: function () {

            }
        }, "-=1");
    });
}

function serviceAnimation() {
    const serviceSection = document.getElementById('service')

    const serviceTl = gsap.timeline({
        scrollTrigger: {
            trigger: serviceSection,
            start: "top 60%",
            toggleActions: "play none none reverse"
        }
    })

    const cards = serviceSection.querySelectorAll('.card')

    const targets = gsap.utils.toArray(cards)



    const titleEl = document.getElementById('service').querySelector('.serviceMainText')
    const secondEl = document.getElementById('service').querySelector('p')

    const titleSplit = SplitText.create(titleEl, { type: "words" })
    const secondSplit = SplitText.create(secondEl, { type: "lines" })

    serviceTl
        .from(titleSplit.words, {
            opacity: 0,
            duration: 2,
            ease: "sine.out",
            stagger: 0.1,
        })
        .from(secondSplit.lines, {
            y: 100,
            opacity: 0,
            duration: 0.8,
            stagger: 0.2,
            ease: "power3.out"
        }, "-=1.5")
        .from(targets, {
            opacity: 0,
            duration: 0.5,
            y: (i) => i % 2 == 0 ? i * 50 : i * -50,
            x: (i) => i % 2 == 0 ? i * 60 : i * -60,
            stagger: 0.2
        }, "-=0.5")

}

function valuesAnimation() {
    const valueSection = document.getElementById('why-us')

    const serviceTl = gsap.timeline({
        scrollTrigger: {
            trigger: valueSection,
            start: "top 60%",
            toggleActions: "play none none reverse"
        }
    })

    const cards = valueSection.querySelectorAll('.card')

    const targets = gsap.utils.toArray(cards)

    const titleEl = valueSection.querySelector('.whyTitle')
    const secondEl = valueSection.querySelector('p')

    const titleSplit = SplitText.create(titleEl, { type: "words" })
    const secondSplit = SplitText.create(secondEl, { type: "lines" })

    let random = gsap.utils.random(0, 0.5)

    serviceTl
        .from(titleSplit.words, {
            opacity: 0,
            duration: 2,
            ease: "sine.out",
            stagger: 0.1,
        })
        .from(secondSplit.lines, {
            y: 100,
            opacity: 0,
            duration: 0.8,
            stagger: 0.2,
            ease: "power3.out"
        }, "<0.5")
        .from(targets, {
            y: 100,
            stagger: 0.3,
            opacity: 0,
            delay: () => gsap.utils.random(0, 0.3)
        }, "<0.5")

}

document.addEventListener('DOMContentLoaded', () => {
    headerAnimation()
    heroAnimation()
    aboutAnimation()
    serviceAnimation()
    valuesAnimation()

})