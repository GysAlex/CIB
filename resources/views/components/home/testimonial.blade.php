<div class="flex flex-col gap-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28" x-data="{
        currentIndex: 0,
        secondIndex: 0,
        init() {
            this.$watch('currentIndex', (value) => {
                setTimeout(() => {
                    this.secondIndex = value;
                }, 450); 
            });
        },
        testimonials_1: [
            {
                title: 'Une expertise technique hors pair',
                content: 'L’intégration de la domotique dans ma résidence a dépassé mes attentes. CIB Manager a su allier esthétique et technologie avec brio.',
                author: 'M. Ateba Oyono',
                home: 'Résidence Nitcheu'
            },
            {
                title: 'Un suivi de projet transparent',
                content: 'Grâce à leur plateforme, j’ai pu suivre l’évolution de mon chantier en temps réel. Une tranquillité d’esprit inestimable.',
                author: 'Mme. Bella',
                home: 'Villa Océan'
            }
        ],
        testimonials_2: [
            {
                title: 'Efficacité énergétique garantie',
                content: 'Ma facture d’électricité a réduit de 40% grâce aux solutions d’isolation et de gestion intelligente installées.',
                author: 'Ing. Tagne',
                home: 'Immeuble Horizon'
            },
            {
                title: 'Respect des délais exemplaire',
                content: 'Il est rare de trouver une entreprise de construction au Cameroun qui respecte les délais à la lettre. Bravo à l’équipe.',
                author: 'M. Kamga',
                home: 'Appartement K'
            }
        ],
        next() {
            this.currentIndex = (this.currentIndex + 1) % this.testimonials_1.length;
        },
        prev() {
            this.currentIndex = (this.currentIndex - 1 + this.testimonials_1.length) % this.testimonials_1.length;
        }
    }">

    <div class="flex items-center justify-center md:justify-start">
        <span class="text-gcp-primary-color bg-gcp-primary-color/10 text-[13px] font-bold rounded-3xl px-3 py-2">
            Témoignages
        </span>
    </div>

    <div class="flex items-end justify-between flex-col md:flex-row gap-y-6">
        <div class="flex flex-col gap-4">

            <div class="text-5xl lg:w-max capitalize text-foreground font-medium text-start">
                Ce que disent nos clients
            </div>
            <div class="text-muted-foreground text-start">
                Découvrez les retours d'expérience de ceux qui nous ont fait confiance pour leurs projets de
                construction intelligente.
            </div>
        </div>

        <div class=" w-full gap-1 flex flex-row justify-end">
            <button @click="prev()"
                class="hover:bg-white py-3 px-4 border border-gcp-primary-color/70 cursor-pointer bg-white/90 text-gcp-primary-color transition-all flex items-center gap-2 group ">
                <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-all duration-400"></i>
            </button>
            <button @click="next()"
                class="hover:bg-white py-3 px-4 border border-gcp-primary-color/70 cursor-pointer bg-white/90 text-gcp-primary-color transition-all flex items-center gap-2 group ">
                <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-all duration-400"></i>
            </button>

        </div>

    </div>

    <div class="testimonial-container grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
        <div class="test-cont overflow-clip relative h-100 sm:h-80 md:h-70 w-full rounded-2xl ">
            <template x-for="(testimonial, index) in testimonials_1" :key="index">
                <div class=" h-full w-full absolute flex flex-col transition-all duration-700 gap-4 bg-gcp-primary-color/20 px-3 py-2"
                    :class="currentIndex != index ? 'opacity-0 -translate-x-full' : 'opacity-100 translate-x-0'">
                    <div class="">
                        <i class="fa-solid fa-quote-left text-gcp-secondary-color text-7xl"></i>
                    </div>

                    <div class="text-2xl max-w-[95%] md:max-w-[80%] text-foreground font-medium"
                        x-text="testimonial.title">

                    </div>
                    <div class="text-muted-foreground" x-text="testimonial.content">

                    </div>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                        <span class="text-foreground font-bold" x-text="testimonial.author">

                        </span>
                        <span class="text-muted-foreground" x-text="testimonial.home">
                        </span>
                    </div>
                </div>
            </template>
        </div>
        <div class="test-cont overflow-clip hidden md:block relative mb-4 h-100 sm:h-80 md:h-70 w-full ">
            <template x-for="(testimonial, index) in testimonials_2" :key="index">
                <div class=" h-full w-full absolute flex flex-col transition-all duration-700 gap-4 bg-gcp-secondary-color/20 px-3 py-2 rounded-2xl"
                    :class="secondIndex != index ? 'opacity-0 -translate-x-full' : 'opacity-100 translate-x-0'">
                    <div class="">
                        <i class="fa-solid fa-quote-left text-gcp-secondary-color text-7xl"></i>
                    </div>

                    <div class="text-2xl max-w-[95%] md:max-w-[80%] text-foreground font-medium"
                        x-text="testimonial.title">

                    </div>
                    <div class="text-muted-foreground" x-text="testimonial.content">

                    </div>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                        <span class="text-foreground font-bold" x-text="testimonial.author">

                        </span>
                        <span class="text-muted-foreground" x-text="testimonial.home">
                        </span>
                    </div>
                </div>
            </template>
        </div>

    </div>
    <div class="flex justify-center gap-2 mt-4">
        <template x-for="(dot, index) in testimonials_1" :key="index">
            <button @click="currentIndex = index"
                class="h-2 transition-all duration-300 rounded-full"
                :class="currentIndex === index ? 'w-8 bg-gcp-primary-color' : 'w-2 bg-gcp-primary-color/20'">
            </button>
        </template>
    </div>
</div>