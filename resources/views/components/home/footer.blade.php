<footer class="bg-[#040017] text-white pt-20 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-8">
            
            <div class="md:col-span-5 lg:col-span-4 flex flex-col gap-6">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/gcp.jpg') }}" alt="Logo" class="h-14 w-auto">
                </div>
                
                <div class="space-y-4">
                    <h3 class="text-xl font-semibold">Inscrivez-vous à la newsletter</h3>
                    <p class="text-gcp-light-gray text-sm leading-relaxed">
                        Recevez nos derniers conseils, actualités et innovations du secteur directement dans votre boîte mail.
                    </p>
                </div>

                <form action="#" class="relative flex items-center bg-white rounded-lg p-1.5 shadow-sm max-w-md">
                    <input type="email" placeholder="Votre adresse email" 
                        class="bg-transparent border-none  text-gray-800 px-4 py-2 outline-0 w-full text-sm">
                    <button type="submit" 
                        class="bg-gcp-primary-color hover:brightness-110 text-white px-6 py-2.5 rounded-md text-sm font-bold transition-all">
                        S'abonner
                    </button>
                </form>
            </div>

            <div class="md:col-span-7 lg:col-span-8 grid grid-cols-2 md:grid-cols-3 gap-8 md:pl-12">
                
                {{-- Entreprise --}}
                <div class="flex flex-col gap-5">
                    <h4 class="text-lg font-bold">Entreprise</h4>
                    <nav class="flex flex-col gap-3">
                        @foreach([
                            'Accueil' => 'home', 
                            'Contact' => 'contact', 
                            'Réalisations' => 'project', 
                            'Blog' => 'blog'
                        ] as $label => $route)
                            <a href="{{ route($route) }}" 
                               class="text-sm transition-colors {{ request()->routeIs($route) ? 'text-white font-bold' : 'text-gcp-light-gray hover:text-gcp-primary-color' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </nav>
                </div>

                {{-- Réseaux Sociaux --}}
                <div class="flex flex-col gap-5">
                    <h4 class="text-lg font-bold">Réseaux Sociaux</h4>
                    <nav class="flex flex-col gap-3">
                        <a href="#" class="text-gcp-light-gray hover:text-white text-sm transition-colors flex items-center gap-2">
                            <i class="fa-brands fa-x-twitter"></i> Twitter/X
                        </a>
                        <a href="#" class="text-gcp-light-gray hover:text-white text-sm transition-colors flex items-center gap-2">
                            <i class="fa-brands fa-instagram"></i> Instagram
                        </a>
                        <a href="#" class="text-gcp-light-gray hover:text-white text-sm transition-colors flex items-center gap-2">
                            <i class="fa-brands fa-facebook"></i> Facebook
                        </a>
                        <a href="#" class="text-gcp-light-gray hover:text-white text-sm transition-colors flex items-center gap-2">
                            <i class="fa-brands fa-linkedin"></i> LinkedIn
                        </a>
                    </nav>
                </div>

                {{-- Support --}}
                <div class="flex flex-col gap-5">
                    <h4 class="text-lg font-bold">Support</h4>
                    <nav class="flex flex-col gap-3">
                        <a href="{{ route('contact') }}" class="text-gcp-light-gray hover:text-white text-sm transition-colors">Contactez-nous</a>
                        <a href="#" class="text-gcp-light-gray hover:text-white text-sm transition-colors">FAQ</a>
                        <a href="#" class="text-gcp-light-gray hover:text-white text-sm transition-colors">Centre d'aide</a>
                    </nav>
                </div>

            </div>
        </div>

        <div class="mt-16 pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gcp-light-gray">
            <p>© {{ date('Y') }} CIB Manager. Tous droits réservés.</p>
            <div class="flex gap-6">
                <a href="#" class="hover:text-white transition-colors">Politique de confidentialité</a>
                <a href="#" class="hover:text-white transition-colors">Conditions d'utilisation</a>
            </div>
        </div>
    </div>
</footer>