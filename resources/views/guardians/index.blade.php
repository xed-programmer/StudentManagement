<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Guardian
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2>Students</h2>
                    <div class="border-t border-gray-200">
                        @foreach ($guardian->students as $i => $s)
                            <div
                                class="
                                @if ($i % 2 == 0)
                                bg-gray-50
                                @else
                                bg-white
                                @endif 
                                px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    <a href="{{ route('guardian.show.student', $s) }}">{{ $s->user->name }}</a>
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $s->student_code }}
                                </dd>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
