<div class="px-3 pt-3 bg-secondary">
    <div class="mx-auto">
        <div class="title grid grid-cols-1 w-full items-center justify-center p-5 rounded-2xl bg-primary text-center">
            <h2 class="text-4xl text-white">Kategori</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 w-full mt-3">
            @foreach ($categories as $category)
                <div
                    class="category-item shadow-lg hover:shadow-2xl relative overflow-hidden flex flex-col hover:rounded-[140px] transition-all duration-400 ease-in-out justify-center items-center bg-cover bg-center bg-no-repeat rounded-2xl p-4 min-h-[400px]   group">
                    <img src="{{$category['image']}}"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-400 ease-in-out hover:scale-110 ">
                    <div class="absolute inset-0 bg-black/50"></div>
                    <h3
                        class="text-sm w-fit z-10 mt-9 relative items-center text-center border border-secondary group-hover:border-transparent py-3 px-5 rounded-full font-semibold text-white transition-all duration-400 ease-in-out group-hover:-translate-y-4">
                        {{ $category['name'] }}
                    </h3>
                    <a href="{{ route('products') }}?category={{ $category['id'] }}"
                        class="text-sm mt-4 opacity-0 group-hover:opacity-100 flex w-fit z-10 relative items-center text-center py-3 px-5 rounded-full font-semibold text-white transition-all duration-400 ease-in-out group-hover:-translate-y-4 group-hover:border border-white">Show
                        More</a>
                </div>
            @endforeach
            <div
                class="category-item flex shadow-lg hover:shadow-2xl flex-col bg-primary  hover:rounded-[140px] justify-center transition-all duration-400 ease-in-out items-center bg-cover bg-center bg-no-repeat rounded-2xl p-4 min-h-[400px] border-2 border-transparent hover:border-secondary">
                <a href={{route('categories')}}
                    class="text-sm w-fit items-center text-center border border-secondary py-3 px-5 rounded-full font-semibold text-white">
                    Semua Kategori >
                </a>
            </div>
        </div>
    </div>
</div>