import gsap from 'gsap'
import { SplitText } from 'gsap/SplitText'

gsap.registerPlugin(SplitText)

function heroAnimation()
{
    const section = document.getElementById('hero')

    const tl = gsap.timeline({ defaults: { ease: "power4.out" } })
    tl.from(".hero-badge", {
        y: -20,
        opacity: 0,
        duration: 0.8
    })

    const mainText = section.querySelector('h1')

    const secondText = section.querySelector('p')

    const titleSplit =  SplitText.create(mainText, { type: "words" })
    const secondSplit = SplitText.create(secondText, {type: "lines"})


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


document.addEventListener('DOMContentLoaded', ()=>{
    heroAnimation()
})