<x-guest-layout>
    <div class="bg-gray-900">
        <div class="flex items-center justify-center max-w-xl h-screen m-auto">
            <div class="text-center w-full p-8">
                {{-- <div class="px-4 text-lg text-gray-500 border-r border-gray-400 tracking-wider">404</div>
    
                <div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">Not Found</div> --}}
                <div class="text-lg text-gray-200 uppercase tracking-wider">
                    No Permission!
                </div>
                <div class="text-lg text-gray-200 border-gray-400 tracking-wider">
                    <span>Sorry, you dont have permission to access this page</span><br>
                    <span>You can go back to <a href="{{route('home')}}" class="text-indigo-400">Home Page</a></span>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>