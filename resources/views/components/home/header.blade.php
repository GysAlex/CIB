<header class="fixed top-0 inset-x-0 z-50 h-16" x-data="{ 
        mobileMenuOpen: false,
        toggleMobileMenu() {
            if (!document.startViewTransition) {
                this.mobileMenuOpen = !this.mobileMenuOpen;
                return;
            }
            document.startViewTransition(() => this.mobileMenuOpen = !this.mobileMenuOpen);
        }
    }">
    <div class="mx-auto px-4 sm:px-6 lg:px-8" style="max-width: var(--max-width-size)">
        <div class="flex items-center justify-between h-16">

            <div class="shrink-0">
                <a href="#" class="flex items-center space-x-2 group" aria-label="CIB Manager Home">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/gcp.jpg') }}" alt="Logo"
                            class="h-12 w-auto transition-transform duration-300 rounded-xl group-hover:scale-105" />
                        <div
                            class="flex flex-col text-[12px] font-extrabold leading-tight mt-1 uppercase tracking-tighter">
                            <span class="text-white">Construction</span>
                            <span class="text-white">Intelligente</span>
                        </div>
                    </div>
                </a>
            </div>

            <nav class="hidden md:flex items-center space-x-10 bg-background/40 backdrop-blur-sm px-7 rounded-2xl">
                @foreach(['Accueil' => '/', 'Projets' => '/project', 'Blog' => '/blog', 'Contact' => '/contact'] as $label => $url)
                    <a href="{{ $url }}"
                        class="text-muted hover:text-white px-1 py-2 text-sm font-medium transition-colors relative group">
                        {{ $label }}
                        <span
                            class="absolute bottom-1 left-0 w-full h-0.5 bg-gcp-primary-color scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
                    </a>
                @endforeach
            </nav>

            <div class="hidden md:block">
                <a href="{{ route('login') }}"
                    class="bg-gcp-primary-color capitalize text-[13px] text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm hover:shadow-lg hover:brightness-110 transition-all inline-flex items-center gap-2">
                    <i class="fa-solid fa-user"></i>
                    mon espace
                </a>
            </div>

            <button @click="toggleMobileMenu()" class="md:hidden p-2 text-foreground">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
                <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <div x-cloak :class="mobileMenuOpen ? 'md:hidden' : 'hidden' ">

        <div class="fixed h-[calc(100dvh-64px)] top-16 right-0 w-[85%] max-w-sm bg-background border-l border-border z-65 shadow-2xl flex justify-start flex-col p-3 pt-24"
            style="view-transition-name: mobile-menu">
            <nav class="flex flex-col space-y-8">
                <a href="#hero" @click="toggleMobileMenu()"
                    class="tracking-tighter text-foreground hover:text-gcp-primary-color transition-colors">
                    Accueil
                </a>
                <a href="#services" @click="toggleMobileMenu()"
                    class="tracking-tighter text-foreground hover:text-gcp-primary-color transition-colors">
                    Services
                </a>

                <a href="#about" @click="toggleMobileMenu()"
                    class="tracking-tighter text-foreground hover:text-gcp-primary-color transition-colors">
                    A propos
                </a>

                <a href="#final-cta" @click="toggleMobileMenu()"
                    class="tracking-tighter text-foreground hover:text-gcp-primary-color transition-colors">
                    Contacts
                </a>

                <div class="">
                    <a href="{{ route('login') }}"
                        class="bg-gcp-primary-color capitalize text-[13px] text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm hover:shadow-lg hover:brightness-110 transition-all inline-flex items-center gap-2">
                        <i class="fa-solid fa-user"></i>
                        mon espace
                    </a>
                </div>
            </nav>


        </div>
    </div>
</header>