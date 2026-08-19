@extends('layouts.app')

@section('content')
<!-- Public Website Blogs Page Header Banner with Dynamic Admin Management -->
<x-page-banner 
    page="blogs" 
    default-title="Religious Blogs & Articles" 
    default-subtitle="Read sacred topics and official updates from our samiti"
    badge="Sanatana Dharma Publications"
    min-height="300px"
/>

<div class="py-12 bg-gray-50/50">
    <div class="container mx-auto px-4">
        <!-- Live Admin Blogs Display Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($blogs as $blog)
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 transition-all hover:shadow-lg flex flex-col h-full">
                    
                    <!-- Blog Thumbnail Image Block -->
                    <div class="aspect-[16/10] w-full bg-gray-100 relative overflow-hidden group shrink-0">
                        @if($blog->thumbnail_path)
                            <img src="{{ asset('storage/' . $blog->thumbnail_path) }}" class="w-full h-full object-cover transition-all duration-300 group-hover:scale-105" alt="Blog Preview">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400 font-bold text-xs">No Preview Image</div>
                        @endif
                        <span class="absolute top-3 left-3 bg-orange-600 text-white text-[9px] font-black px-2.5 py-1 rounded shadow uppercase tracking-wider">Sanatana Dharma</span>
                    </div>

                    <!-- Blog Title and Small Info Body -->
                    <div class="p-5 flex flex-col flex-1">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">
                            📅 Published: {{ \Carbon\Carbon::parse($blog->created_at)->format('d-M-Y') }}
                        </span>
                        
                        <h4 class="text-base font-bold text-gray-900 uppercase tracking-wide line-clamp-2 mb-2 hover:text-orange-600 transition">
                            {{ $blog->title }}
                        </h4>
                        
                        <p class="text-xs text-gray-500 font-medium line-clamp-3 mb-4 leading-relaxed">
                            {{ strip_tags($blog->content) }}
                        </p>
                        
                        <!-- Read full article link action button -->
                        <div class="mt-auto pt-2">
                            <a href="#" class="text-orange-600 hover:text-orange-700 font-black text-xs uppercase tracking-wider inline-flex items-center gap-1">
                                Read Full Article <span class="text-sm">→</span>
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                <!-- Fallback block if blogs register is clear -->
                <div class="col-span-full text-center py-12">
                    <span class="text-4xl block mb-2">📰</span>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider">No religious blog articles discovered inside the website repository yet.</h3>
                </div>
            @endforelse
        </div>

        <!-- Pagination Links Block -->
        @if($blogs->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $blogs->links() }}
            </div>
        @endif

    </div> <!-- End Container -->
</div> <!-- End Py-12 Wrapper -->
@endsection
