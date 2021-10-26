<x-app-layout>
    <div class="my-4">

        @forelse ($posts as $post)
            <div class="pt-4">
                <div class="max-w-3xl mx-auto  sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                        <div class="p-4 text-sm flex items-center justify-end text-gray-500 border-b border-gray-300">
                            <i class="fas fa-clock mr-2"></i>
                            {{ $post->created_at->diffForHumans() }}
                        </div>
                        <div class="p-6">
                            {!! $post->body !!}
                        </div>
                    </div>
                </div>
            </div>
        @empty

        @endforelse
    </div>
</x-app-layout>
