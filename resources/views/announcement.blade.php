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
            <div class="pt-4">
                <div class="max-w-3xl mx-auto  sm:px-6 lg:px-8">
                    <div class="p-6 text-lg text-center text-gray-400 uppercase tracking-wider">
                        NO ANNOUNCEMENTS
                    </div>
                </div>
            </div>
        @endforelse

        @if ($posts->count() > 0)
            <div class="pt-4">
                <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden sm:rounded-lg">
                        <div class="p-6 text-lg text-gray-400 uppercase tracking-wider">
                            {{ $posts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
