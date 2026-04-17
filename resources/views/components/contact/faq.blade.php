@php
    $faqs = [
        [
            'question' => 'Quelles zones desservez-vous au Cameroun ?',
            'answer' => 'Nous intervenons principalement sur Douala et Yaoundé, mais nous sommes ouverts à des projets sur l\'ensemble du territoire national selon l\'envergure et la durée du chantier.'
        ],
        [
            'question' => 'À quel moment devrais-je vous contacter pour un nouveau projet ?',
            'answer' => 'Le plus tôt est le mieux. Idéalement, contactez-nous dès la phase d\'idée. Nous pouvons vous accompagner de la conception des plans 3D jusqu\'à la remise des clés.'
        ],
        [
            'question' => 'Offrez-vous des consultations gratuites ?',
            'answer' => 'Oui, nous proposons une première séance de consultation gratuite pour évaluer la faisabilité technique de votre projet et comprendre vos besoins spécifiques.'
        ],
        [
            'question' => 'Pouvez-vous m\'aider pour les permis et la documentation ?',
            'answer' => 'Absolument. Notre équipe s\'occupe du dossier technique complet et vous accompagne dans les démarches administratives pour l\'obtention de votre permis de bâtir.'
        ],
        [
            'question' => 'Travaillez-vous sur des designs personnalisés ?',
            'answer' => 'Chaque projet est unique. Nous travaillons soit à partir de vos propres plans, soit en créant un design sur-mesure totalement adapté à votre terrain et à votre budget.'
        ],
    ];
@endphp
<section class="py-24 bg-white" x-data="{ activeAccordion: null }">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col items-center text-center gap-4 mb-16">
            <span
                class="text-gcp-primary-color bg-gcp-primary-color/10 text-[12px] font-bold rounded-3xl px-3 py-2 uppercase tracking-widest">
                FAQs
            </span>
            <h2 class="text-4xl md:text-5xl font-medium text-[#1e262f]">Besoin d'aide avant de bâtir ?</h2>
            <p class="text-muted-foreground max-w-xl">
                Trouvez des réponses rapides aux questions les plus fréquemment posées par nos clients.
            </p>
        </div>

        <div class="space-y-0 border-t border-gray-100">
            @foreach($faqs as $index => $faq)
                <div class="border-b border-gray-100 group">
                    <button @click="activeAccordion = (activeAccordion === {{ $index }} ? null : {{ $index }})"
                            class="w-full py-8 flex items-center justify-between text-left transition-all">
                        
                        <div class="flex items-center gap-8 md:gap-12">
                            <span class="text-gcp-primary-color font-bold text-lg md:text-xl opacity-80">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            
                            <span class="text-lg md:text-xl font-medium text-[#1e262f] group-hover:text-gcp-primary-color transition-colors">
                                {{ $faq['question'] }}
                            </span>
                        </div>

                        <div class="ml-4 text-gray-400 transition-transform duration-300"
                             :class="activeAccordion === {{ $index }} ? 'rotate-180' : ''">
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                    </button>

                    <div x-show="activeAccordion === {{ $index }}"
                         x-cloak
                         class="overflow-hidden">
                        <div class="pb-8 pl-18 md:pl-24 pr-4">
                            <p class="text-muted-foreground leading-relaxed text-lg">
                                {{ $faq['answer'] }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>