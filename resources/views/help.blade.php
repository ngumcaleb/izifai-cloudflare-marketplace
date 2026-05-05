<x-app-layout>
    <div class="bg-slate-50 min-h-screen">
        <!-- Help Hero -->
        <div class="bg-[#0A1D37] text-white py-16">
            <div class="max-w-4xl mx-auto px-6 text-center">
                <span class="inline-block bg-green-500/20 text-green-400 text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-[0.3em] mb-6">Support Hub</span>
                <h1 class="text-4xl md:text-5xl font-black mb-8 leading-tight">How can we <br> <span class="text-green-500">help you</span> today?</h1>
                
                <div class="relative max-w-2xl mx-auto">
                    <input type="text" placeholder="Search for guides, policies, or topics..." class="w-full h-16 bg-white/10 border border-white/20 rounded-2xl px-8 text-white placeholder-white/40 focus:bg-white focus:text-slate-900 focus:ring-4 focus:ring-green-500/20 transition-all outline-none">
                    <button class="absolute right-3 top-3 bottom-3 bg-green-600 px-6 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-green-700 transition-all">Search</button>
                </div>
            </div>
        </div>

        <div class="max-w-[1200px] mx-auto px-6 -mt-10 pb-20">
            <!-- Quick Links -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-white p-8 rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 group hover:border-green-600 transition-all cursor-pointer">
                    <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 mb-6 group-hover:bg-green-600 group-hover:text-white transition-all">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 mb-2">Getting Started</h3>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">New to Izifai? Learn how to buy, verify sellers, and manage your orders.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 group hover:border-green-600 transition-all cursor-pointer">
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 mb-2">Selling on Izifai</h3>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">Build your digital storefront, upload products, and connect with buyers in Cameroon.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 group hover:border-green-600 transition-all cursor-pointer">
                    <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center text-red-600 mb-6 group-hover:bg-red-600 group-hover:text-white transition-all">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04c-.243.39-.314.906-.314 1.414 0 6.666 4.721 12.23 11.089 13.914l.111.028.111-.028C19.279 19.584 24 14.02 24 7.354c0-.508-.071-1.024-.314-1.414z"></path></svg>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 mb-2">Trust & Safety</h3>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">Learn about our verification process and how we protect buyers and sellers.</p>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="bg-white rounded-[2rem] p-10 md:p-16 border border-slate-100 shadow-sm overflow-hidden relative">
                <div class="relative z-10 grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl font-black text-slate-900 mb-6 leading-tight">Can't find what you're <br> looking for?</h2>
                        <p class="text-slate-500 font-medium mb-10 leading-relaxed">Our support team is available Monday to Friday, 8 AM - 6 PM (WAT) to assist you with any inquiries or issues.</p>
                        
                        <div class="flex flex-wrap gap-4">
                            <a href="https://wa.me/237XXXXXXXXX" target="_blank" class="bg-[#25D366] text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest flex items-center gap-3 hover:scale-105 transition-all">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                Contact WhatsApp
                            </a>
                            <a href="mailto:support@izifai.com" class="bg-slate-900 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all">Email Support</a>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <img src="https://img.freepik.com/free-photo/customer-service-operator-with-headset_23-2148102144.jpg" class="rounded-[2rem] w-full aspect-square object-cover shadow-2xl">
                    </div>
                </div>
                
                <!-- Background Decoration -->
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-green-500/5 rounded-full blur-3xl"></div>
                <div class="absolute -left-20 -top-20 w-80 h-80 bg-blue-500/5 rounded-full blur-3xl"></div>
            </div>
        </div>
    </div>
</x-app-layout>
