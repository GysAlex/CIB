<div class="bg-gcp-primary-color/20">
    <div class="flex flex-col gap-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="flex flex-col gap-2">
                <h2 class="text-4xl md:text-5xl capitalize font-medium text-[#1e262f] leading-tight">
                    Donnez vie à vos plans les plus <span class="text-gcp-primary-color">ambitieux</span>
                </h2>
                <p class="text-muted-foreground text-lg leading-relaxed">
                    Que ce soit pour une résidence privée ou un complexe commercial, notre équipe transforme vos idées
                    en structures durables grâce à notre expertise BIM unique au Cameroun.
                </p>
                <div class="h-full flex items-end justify-start">
                    <a href="{{ route('contact') }}"
                        class="hover:bg-white mt-4 py-3 px-4 w-fit cursor-pointer bg-white text-gcp-primary-color transition-all flex items-center gap-2 group ">
                        <span class="text-[14px] font-medium min-w-max">Demarrer mon projet</span>
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-all duration-400"></i>
                    </a>
                </div>

            </div>
            <div class="relative min-h-100 order-1 lg:order-2 overflow-hidden rounded-2xl">
                <img src="{{ asset('images/hero2.jpeg') }}" alt="Construction Moderne"
                    class="absolute inset-0 w-full h-full object-cover">

                <div class="absolute inset-0 bg-linear-to-r from-white/20 to-transparent lg:hidden"></div>

                <div
                    class="absolute bottom-8 right-8 bg-white/90 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-white/20 hidden md:flex items-center gap-4">
                    <div
                        class="size-10 bg-gcp-primary-color/10 rounded-full flex items-center justify-center text-gcp-primary-color">
                        <i class="fa-solid fa-vr-cardboard"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-gray-400 uppercase">Technologie</span>
                        <span class="text-xs font-bold text-[#1e262f]">Visualisation 3D incluse</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>