<x-app-layout>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2"
                    fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                    <polygon points="50,0 100,0 50,100 0,100" />
                </svg>

                <div>
                    <div class="relative pt-6 px-4 sm:px-6 lg:px-8">
                    </div>
                </div>

                <main class="relative mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">Education to enrich your</span>
                            <span class="block text-indigo-600 xl:inline">knowledge</span>
                        </h1>
                        <p
                            class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Successful and unsuccessful people do not vary greatly in their abilities. They vary in
                            their desires to reach their potential.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="#"
                                    class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                    Get started
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full"
                src="https://images.pexels.com/photos/5428264/pexels-photo-5428264.jpeg?cs=srgb&dl=pexels-tima-miroshnichenko-5428264.jpg&fm=jpg"
                alt="">
        </div>
    </div>

    @if ($post != null)
        <div class="bg-gray-50">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
                <h2 class="text-3xl font-extrabold text-center tracking-tight text-gray-900 sm:text-4xl">
                    <span class="block text-indigo-600">New Announcement</span>
                </h2>
                <div class="pt-4">
                    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                            <div
                                class="p-4 text-sm flex items-center justify-end text-gray-500 border-b border-gray-300">
                                <i class="fas fa-clock mr-2"></i>
                                {{ $post->created_at->diffForHumans() }}
                            </div>
                            <div class="p-6">
                                {!! $post->body !!}
                            </div>
                            <div class="p-4 bg-gray-50 text-xs">
                                <a href="{{ route('announcement') }}">See more announcements</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-gray-50">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
                <h2 class="text-3xl font-extrabold text-center tracking-tight text-gray-900 sm:text-4xl">
                    <span class="block text-gray-600">No Announcement</span>
                </h2>
            </div>
        </div>
    @endif


</x-app-layout>
