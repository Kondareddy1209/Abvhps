@extends('layouts.app')

@section('content')
<!-- Public Website Gallery Page Header Banner -->
<div class="bg-gray-900 text-white py-12 text-center" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('/assets/images/banner.jpg') no-repeat center center; background-size: cover;">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold uppercase tracking-wide text-orange-500">🔱 Service Media Gallery</h1>
        <p class="text-xs md:text-sm text-gray-300 mt-2 uppercase tracking-widest">Live glimpses of our social and religious service events</p>
    </div>
</div>

<div class="py-12 bg-gray-50/50">
    <div class="container mx-auto px-4">
        <!-- Live Admin Media Display Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($galleryItems as $item)
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 transition-all hover:shadow-lg">
                    
                    <!-- Display block for Photo Assets -->
                    @if($item->media_type === 'image')
                        <div class="aspect-[4/3] w-full bg-gray-100 relative overflow-hidden group">
                            <img src="{{ asset('storage/' . $item->image_path) }}" class="w-full h-full object-cover transition-all duration-300 group-hover:scale-105" alt="ABVHPS Service Photo">
                            <span class="absolute bottom-2 left-2 bg-orange-600 text-white text-[9px] font-bold px-2 py-0.5 rounded shadow-sm">PHOTO</span>
                        </div>
                    
                    <!-- Display block for Video Link Assets -->
                    @else
                        <div class="aspect-[4/3] w-full bg-gray-900 flex flex-col items-center justify-center relative p-4 group">
                            <span class="text-4xl block transition-all group-hover:scale-110">📺</span>
                            <span class="absolute bottom-2 left-2 bg-indigo-600 text-white text-[9px] font-bold px-2 py-0.5 rounded shadow-sm">VIDEO LINK</span>
                            <div class="mt-3 text-center w-full">
                                <a href="{{ $item->video_url }}" target="_blank" class="bg-gray-800 hover:bg-orange-600 text-white font-bold text-[10px] px-4 py-1.5 rounded-md transition-all inline-block uppercase tracking-wider shadow">
                                    Watch Video →
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Card Info Footer -->
                    <div class="p-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center text-[10px] text-gray-400 font-semibold">
                        <span>🔱 ABVHPS Service</span>
                        <span>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</span>
                    </div>

                </div>
            @empty
                <!-- Fallback block if table register is clear -->
                <div class="col-span-full text-center py-12">
                    <span class="text-4xl block mb-2">🖼️</span>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider">No media items discovered inside the public gallery yet.</h3>
                </div>
            @endforelse
        </div>

    </div> <!-- End Container -->
</div> <!-- End Py-12 Wrapper -->
@endsection
