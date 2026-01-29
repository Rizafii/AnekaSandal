<footer class="my-3 px-3 bg-transparent">
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary to-primary/90 text-white shadow-lg">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/diagmonds.png')]">
        </div>
        <div class="relative z-10 px-8 py-12 grid grid-cols-1 md:grid-cols-4 gap-10">
            <div>
                <h4 class="text-xl font-bold mb-3">AnekaSandal</h4>
                <p class="text-white/80 text-sm leading-relaxed">
                    Sandal berkualitas tinggi untuk kenyamanan & gaya Anda setiap hari.
                </p>
            </div>
            <div>
                <h5 class="font-semibold mb-3">Navigasi</h5>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:underline">Beranda</a></li>
                    <li><a href="{{ route('categories') }}" class="hover:underline">Kategori</a></li>
                    <li><a href="{{ route('products') }}" class="hover:underline">Produk</a></li>
                    <li><a href="{{ route('orders.index') }}" class="hover:underline">Pesanan</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-semibold mb-3">Kontak</h5>
                <ul class="space-y-2 text-sm">
                    <li>Jl. Sekarpetak KM 1, Jatipuro</li>
                    <li><a href="tel:+6288226532872" class="hover:underline">+62 8822-6532-8872</a></li>
                    <li><a href="mailto:anekasandaljtpr@gmail.com" class="hover:underline">anekasandaljtpr@gmail.com</a>
                    </li>
                    <li><a href="https://wa.me/6288226532872" target="_blank" class="hover:underline">WhatsApp</a>
                    </li>
                </ul>
            </div>
            <div>
                <h5 class="font-semibold mb-3">Ikuti Kami</h5>
                <div class="flex gap-3">
                    <a href="#"
                        class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M22.54 6.42a8.94 8.94 0 01-.26 2.09 10 10 0 01-3.3 5.14c-3.6 3.08-9 3.44-12.95.84l-.15-.1a10 10 0 01-4.1-5.18c-.06-.2-.1-.41-.15-.62a6.5 6.5 0 00.06 1.11 10 10 0 0015.5 6.45 10 10 0 003.3-5.14 8.94 8.94 0 00.26-2.09 6.5 6.5 0 00-.26-1.82 10 10 0 01-3.3 5.14 10 10 0 01-12.95.84A10 10 0 012.5 8.5v-.18A10 10 0 0012.05 18a10 10 0 009.45-7.58 8.94 8.94 0 00.26-2.09z" />
                        </svg>
                    </a>
                    <a href="#"
                        class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M22 12a10 10 0 10-11.5 9.9v-7H8v-3h2.5V9.5A3.5 3.5 0 0114.4 6h2.6v3h-2.6a1 1 0 00-1 1V12H17l-.5 3h-2.7v7A10 10 0 0022 12z" />
                        </svg>
                    </a>
                    <a href="#"
                        class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M7.5 2h9A5.5 5.5 0 0122 7.5v9a5.5 5.5 0 01-5.5 5.5h-9A5.5 5.5 0 012 16.5v-9A5.5 5.5 0 017.5 2zm0 2A3.5 3.5 0 004 7.5v9A3.5 3.5 0 007.5 20h9a3.5 3.5 0 003.5-3.5v-9A3.5 3.5 0 0016.5 4h-9zm9.75 1.75a1 1 0 110 2 1 1 0 010-2zM12 8a4 4 0 110 8 4 4 0 010-8z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="border-t border-white/10 px-8 py-4 text-center text-xs text-white/70">
            © {{ date('Y') }} AnekaSandal • All rights reserved.
        </div>
    </div>
</footer>