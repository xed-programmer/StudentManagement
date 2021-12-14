<x-guest-layout>

    <div class="bg-gray-50">
        <div
            class="max-w-7xl h-screen mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <div class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                <form action="{{ route('gatepass.store') }}" method="POST">
                    @csrf
                    <div class="bg-gray-50 flex items-center rounded-full shadow-xl">
                        <input class="border-none rounded-full w-full py-4 px-6 text-gray-700" name="student_code"
                            id="student_code" type="text" placeholder="Student Code" autofocus required>

                        <div class="p-4">
                            <button
                                class="bg-blue-500 text-white rounded-full p-2 hover:bg-blue-400 focus:outline-none w-12 h-12 flex items-center justify-center">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="mt-8 max-w-4xl flex lg:mt-0 lg:flex-shrink-0">
                <div class="rounded-md shadow p-10">
                    @if ($student != null)
                        <h1 class="text-3xl">{{ $student->user->name }}</h1>
                        <h1>{{ $student->student_code }}</h1>
                        <h1>{{ $student->course }} {{ $student->year }} {{ $student->section }}</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>


    @prepend('scripts')
        <script>
            $(document).ready(() => {
                setInterval(() => {
                    $('#student_code').focus();
                }, 500);
            });
        </script>
    @endprepend
</x-guest-layout>
