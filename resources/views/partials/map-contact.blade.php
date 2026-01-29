<section class="px-3 bg-secondary">
    <div class="mx-auto">
        <div
            class="title grid grid-cols-1 w-full items-center justify-center px-5 py-3 rounded-2xl bg-primary text-center">
            <h2 class="text-4xl text-white">Hubungi Kami</h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mt-3">
            {{-- Map Card --}}
            <div
                class="group relative rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500  h-full ">
                <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-transparent pointer-events-none">
                </div>
                <iframe class="w-full h-full grayscale group-hover:grayscale-0 transition-all duration-500"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.1234567890!2d110.8234567!3d-7.6234567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMzcnMjQuNCJTIDExMMKwNDknMjQuNCJF!5e0!3m2!1sen!2sid!4v1234567890"
                    style="border:0;" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <div
                    class="absolute top-3 left-3 bg-white/90 backdrop-blur px-4 py-2 rounded-lg text-sm font-medium text-primary shadow">
                    Lokasi Toko
                </div>
            </div>

            {{-- Contact + Actions --}}
            <div class="flex flex-col gap-4">
                <div
                    class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 flex flex-col">
                    <h3 class="text-2xl font-bold text-primary mb-3">Tetap Terhubung</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Kami siap membantu kebutuhan sandal Anda. Hubungi kami melalui saluran berikut.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- Address --}}
                        <div
                            class="p-5 rounded-xl border border-gray-100 hover:border-primary/40 hover:shadow-md transition-all duration-300 bg-gradient-to-br from-primary/5 to-transparent">
                            <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">Alamat</h4>
                            <p class="text-sm text-gray-600 leading-snug">
                                Jl. Sekarpetak KM 1, Jatipuro, Jatipuro, Karanganyar, Jawa Tengah
                            </p>
                        </div>

                        {{-- Phone --}}
                        <a href="tel:+6288226532887"
                            class="p-5 rounded-xl border border-gray-100 hover:border-primary/40 hover:shadow-md transition-all duration-300 bg-gradient-to-br from-primary/5 to-transparent group">
                            <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-primary group-hover:scale-110 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.3a1 1 0 01.95.69l1.5 4.5a1 1 0 01-.5 1.2l-2.3 1.1a11 11 0 005.5 5.5l1.1-2.3a1 1 0 011.2-.5l4.5 1.5a1 1 0 01.7.95V19a2 2 0 01-2 2h-1C9.7 21 3 14.3 3 6V5z" />
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">Telepon</h4>
                            <p class="text-sm text-primary font-medium">+62 8822-6532-8872</p>
                        </a>

                        {{-- WhatsApp --}}
                        <a href="https://wa.me/6288226532872" target="_blank"
                            class="p-5 rounded-xl border border-gray-100 hover:border-primary/40 hover:shadow-md transition-all duration-300 bg-gradient-to-br from-primary/5 to-transparent group">
                            <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-primary group-hover:scale-110 transition-transform"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.3-.15-1.76-.868-2.03-.968-.27-.1-.47-.148-.67.15l-.94 1.165c-.17.198-.34.222-.64.074-.3-.15-1.26-.463-2.39-1.475-1.03-.92-1.68-2.054-1.85-2.35-.17-.297-.02-.458.13-.606l.45-.52c.15-.174.2-.298.3-.497s.05-.37-.03-.52c-.07-.148-.66-1.612-.9-2.207-.25-.579-.49-.5-.67-.51h-.57c-.2 0-.52.074-.79.372-.28.297-1.05 1.016-1.05 2.479s1.08 2.875 1.23 3.074c.15.198 2.1 3.2 5.08 4.487.71.306 1.26.489 1.69.625.71.227 1.36.195 1.87.118.57-.085 1.76-.719 2.01-1.413.25-.694.25-1.289.17-1.413-.07-.124-.27-.198-.57-.347" />
                                    <path
                                        d="M12.05 22c-1.74 0-3.44-.45-4.94-1.3l-3.53.925.95-3.48A9.83 9.83 0 012.2 12C2.2 6.54 6.64 2.1 12.1 2.1c2.64 0 5.13 1.03 7 2.9a9.86 9.86 0 012.9 7c0 5.46-4.44 9.9-9.95 9.9z" />
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">WhatsApp</h4>
                            <p class="text-sm text-primary font-medium">+62 8822-6532-8872</p>
                        </a>

                        {{-- Email (optional new) --}}
                        <div
                            class="p-5 rounded-xl border border-gray-100 hover:border-primary/40 hover:shadow-md transition-all duration-300 bg-gradient-to-br from-primary/5 to-transparent">
                            <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">Email</h4>
                            <p class="text-sm text-gray-600">anekasandaljtpr@gmail.com</p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col sm:flex-row gap-4 mt-8">
                        <a href="https://wa.me/6288226532872" target="_blank"
                            class="flex-1 bg-primary hover:bg-primary/90 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.3-.15-1.76-.868-2.03-.968-.27-.1-.47-.148-.67.15l-.94 1.165c-.17.198-.34.222-.64.074-.3-.15-1.26-.463-2.39-1.475-1.03-.92-1.68-2.054-1.85-2.35-.17-.297-.02-.458.13-.606l.45-.52c.15-.174.2-.298.3-.497s.05-.37-.03-.52c-.07-.148-.66-1.612-.9-2.207-.25-.579-.49-.5-.67-.51h-.57c-.2 0-.52.074-.79.372-.28.297-1.05 1.016-1.05 2.479s1.08 2.875 1.23 3.074c.15.198 2.1 3.2 5.08 4.487.71.306 1.26.489 1.69.625.71.227 1.36.195 1.87.118.57-.085 1.76-.719 2.01-1.413.25-.694.25-1.289.17-1.413-.07-.124-.27-.198-.57-.347" />
                                <path
                                    d="M12.05 22c-1.74 0-3.44-.45-4.94-1.3l-3.53.925.95-3.48A9.83 9.83 0 012.2 12C2.2 6.54 6.64 2.1 12.1 2.1c2.64 0 5.13 1.03 7 2.9a9.86 9.86 0 012.9 7c0 5.46-4.44 9.9-9.95 9.9z" />
                            </svg>
                            Chat WhatsApp
                        </a>
                        <a href="tel:+6288226532872"
                            class="flex-1 border border-primary text-primary hover:bg-primary hover:text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.3a1 1 0 01.95.69l1.5 4.5a1 1 0 01-.5 1.2l-2.3 1.1a11 11 0 005.5 5.5l1.1-2.3a1 1 0 011.2-.5l4.5 1.5a1 1 0 01.7.95V19a2 2 0 01-2 2h-1C9.7 21 3 14.3 3 6V5z" />
                            </svg>
                            Telepon
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>