<div class="bg-white p-6 md:p-8">
    <div class="text-center mb-10">
        <h2 class="text-2xl font-bold text-[#1e262f] tracking-tight">Envoyez-nous un message</h2>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-2xl border border-green-200 flex items-center gap-3 animate-fade-in">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
        
        <div class="md:col-span-2">
            <label class="block text-sm font-bold text-[#1e262f] mb-2">Nom Complet*</label>
            <input type="text" wire:model="name" placeholder="Ex: Jean Douala" 
                   class="w-full px-5 py-4 border border-gray-200 focus:border-gcp-primary-color focus:ring-1 focus:ring-gcp-primary-color outline-none transition-all bg-gray-50/50">
            @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-bold text-[#1e262f] mb-2">Adresse Email*</label>
            <input type="email" wire:model="email" placeholder="votre@email.com"
                   class="w-full px-5 py-4 border border-gray-200 focus:border-gcp-primary-color focus:ring-1 focus:ring-gcp-primary-color outline-none transition-all bg-gray-50/50">
            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-[#1e262f] mb-2">Numéro de Téléphone*</label>
            <input type="text" wire:model="phone" placeholder="+237 6xx xxx xxx"
                   class="w-full px-5 py-4 border border-gray-200 focus:border-gcp-primary-color focus:ring-1 focus:ring-gcp-primary-color outline-none transition-all bg-gray-50/50">
            @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-[#1e262f] mb-2">Type de Projet*</label>
            <div class="relative">
                <select wire:model="projectType" 
                        class="w-full px-5 py-4 border border-gray-200 focus:border-gcp-primary-color focus:ring-1 focus:ring-gcp-primary-color outline-none transition-all appearance-none bg-gray-50/50 cursor-pointer">
                    <option value="">Sélectionnez un type</option>
                    <option value="residential">Construction Résidentielle (Villa, Duplex)</option>
                    <option value="commercial">Bâtiment Commercial / Bureaux</option>
                    <option value="renovation">Rénovation & Extension</option>
                    <option value="consulting">Conseil & Études Techniques</option>
                </select>
                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                    <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                </div>
            </div>
            @error('projectType') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-bold text-[#1e262f] mb-2">Description de votre projet*</label>
            <textarea wire:model="message" rows="5" placeholder="Parlez-nous de vos besoins, de la localisation, de vos délais..."
                      class="w-full px-5 py-4 border border-gray-200 focus:border-gcp-primary-color focus:ring-1 focus:ring-gcp-primary-color outline-none transition-all bg-gray-50/50"></textarea>
            @error('message') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="md:col-span-2 flex justify-center mt-4">
            <button type="submit" 
                    class="bg-gcp-primary-color text-white px-6 py-3 font-bold flex items-center gap-3 hover:shadow-2xl hover:shadow-gcp-primary-color/30 transition-all group">
                <span > Envoyer le message </span>
                <i class="fa-solid fa-paper-plane text-sm transition-transform group-hover:translate-x-1 group-hover:-translate-y-1"></i>
                
                <div wire:loading class="ml-2 animate-spin size-4 border-2 border-white/30 border-t-white rounded-full"></div>
            </button>
        </div>

    </form>
</div>