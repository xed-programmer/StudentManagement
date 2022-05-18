<x-guest-layout>

    <div class="row">
        <div class="h-screen">
            <ul class="nav nav-tabs flex flex-col md:flex-row flex-wrap list-none border-b-0 pl-0 mb-4" id="tabs-tabFill"
                role="tablist">
                <li class="nav-item flex-auto text-center" role="presentation">
                    <a href="#tabs-homeFill"
                        class="
      nav-link
      w-full
      block
      font-medium
      text-xs
      leading-tight
      uppercase      
      border-x-0 border-t-0 border-b-2 border-transparent
      px-6
      py-3
      my-2
      hover:border-transparent hover:bg-gray-100
      focus:border-transparent
      active
    "
                        id="tabs-student-tabFill" data-bs-toggle="pill" data-bs-target="#tabs-studentFill" role="tab"
                        aria-controls="tabs-studentFill" aria-selected="true">Student</a>
                </li>
                <li class="nav-item flex-auto text-center" role="presentation">
                    <a href="#tabs-profileFill"
                        class="
      nav-link
      w-full
      block
      font-medium
      text-xs
      leading-tight
      uppercase
      border-x-0 border-t-0 border-b-2 border-transparent
      px-6
      py-3
      my-2
      hover:border-transparent hover:bg-gray-100
      focus:border-transparent
    "
                        id="tabs-visitor-tabFill" data-bs-toggle="pill" data-bs-target="#tabs-visitorFill" role="tab"
                        aria-controls="tabs-visitorFill" aria-selected="false">Visitor</a>
                </li>
            </ul>
            <div class="tab-content" id="tabs-tabContentFill">
                <div class="tab-pane fade show active" id="tabs-studentFill" role="tabpanel"
                    aria-labelledby="tabs-student-tabFill">
                    <div class="row">
                        <div class="mx-auto md:w-3/5 text-center flex items-center flex-col justify-center">
                            <h1 class="text-5xl font-bold leading-tight">
                                Student's Gatepass
                            </h1>
                            <div class="w-1/3 mt-8 flex lg:mt-0 lg:flex-shrink-0" style="height: 50vh;">
                                <div class="rounded-md shadow p-10 border-2 border-black" style="width: 100%">
                                    @if ($student != null)
                                        @if ($student->user->profile_pic)
                                            <img src="{{ asset($student->user->profile_pic) }}" alt="photo"
                                                class="m-auto h-28 w-28">
                                        @else
                                            <img src="{{ asset('uploads/images/avatar1.png') }}" alt="photo"
                                                class="m-auto h-28 w-28">
                                        @endif
                                        <h1 class="text-3xl">{{ $student->user->name }}</h1>
                                        <h1>{{ $student->student_code }}</h1>
                                        <h1>{{ $student->course }} {{ $student->year }} {{ $student->section }}
                                        </h1>
                                        <h1>{{ strtoupper($status) }}</h1>
                                    @endif
                                </div>
                            </div>
                            <div class="mx-auto my-5 px-4 sm:px-6 lg:px-8 lg:flex lg:items-center lg:justify-center">
                                <div class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                                    <form action="{{ route('gatepass.store') }}" method="POST" autocomplete="off">
                                        @csrf
                                        <div class="bg-gray-50 flex items-center rounded-full shadow-xl">
                                            <input class="border-none rounded-full w-full py-4 px-6 text-gray-700"
                                                name="student_code" id="student_code" type="text"
                                                placeholder="Student Code" autofocus required>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tabs-visitorFill" role="tabpanel"
                    aria-labelledby="tabs-visitor-tabFill">
                    <div class="row">
                        <div class="mx-auto md:w-3/5 text-center flex items-center flex-col justify-center">
                            <h1 class="text-5xl font-bold leading-tight">
                                Visitor's Gatepass
                            </h1>
                            <!-- Button trigger modal -->
                            <button type="button"
                                class="inline-block m-2 px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
                                data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                {{ __('Add Visitor') }}
                            </button>
                            <div class="flex justify-center">
                                <div class="w-1/3 mt-8 flex lg:mt-0 lg:flex-shrink-0" style="height: 35vh;">
                                    <div class="rounded-md shadow p-10 border-2 border-black" style="width: 100%">
                                        @if ($visitor != null)
                                            <h1 class="text-3xl">{{ $visitor->name }}</h1>
                                            <h1>{{ $visitor->email }}</h1>
                                            <h1>Destination: {{ $destination }}</h1>
                                            <h1>{{ strtoupper($status) }}</h1>
                                        @endif
                                    </div>
                                </div>
                                <div
                                    class="mx-auto my-5 px-4 sm:px-6 lg:px-8 lg:flex lg:items-center lg:justify-center">
                                    <div class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                                        <form action="{{ route('gatepass.visitor.store') }}" method="POST"
                                            autocomplete="off">
                                            @csrf
                                            <label for="email"
                                                class="form-label text-xl inline-block mb-2 text-gray-700">Email</label>
                                            <div class="bg-gray-50 flex items-center rounded-full shadow-xl my-3">
                                                <input
                                                    class="appearance-none
                                                block
                                                w-full
                                                px-3
                                                py-1.5
                                                text-base
                                                font-normal
                                                text-gray-700
                                                bg-white bg-clip-padding bg-no-repeat
                                                border border-solid border-gray-300
                                                rounded"
                                                    name="email" id="email" type="text" placeholder="Email" autofocus
                                                    required>
                                            </div>
                                            <label for="destination"
                                                class="form-label text-xl inline-block mb-2 text-gray-700">Destination</label>
                                            <div class="flex justify-center">
                                                <div class="mb-3 xl:w-96">
                                                    <select
                                                        class="form-select appearance-none
                                                    block
                                                    w-full
                                                    px-3
                                                    py-1.5
                                                    text-base
                                                    font-normal
                                                    text-gray-700
                                                    bg-white bg-clip-padding bg-no-repeat
                                                    border border-solid border-gray-300
                                                    rounded
                                                    transition
                                                    ease-in-out
                                                    m-0
                                                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                                        name="destination" id="destination">
                                                        @foreach ($destinations as $d)
                                                            <option value="{{ $d->name }}">{{ $d->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <button
                                                class="w-full bg-purple-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                                type="submit">
                                                {{ __('Enter') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
        id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog relative w-auto pointer-events-none">
            <div
                class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                <div
                    class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">
                        Add Visitor
                    </h5>
                    <button type="button"
                        class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body relative p-4">
                    <form id="addform" method="POST">
                        @csrf
                        <div class="relative p-6 flex-auto">
                            <!-- Name -->
                            <div>
                                <x-label for="name" :value="__('Name')" />

                                <x-input id="name" class="block mt-1 w-full" type="text" name="name" required
                                    autofocus />
                            </div>
                            <!-- Email Address -->
                            <div>
                                <x-label for="email" :value="__('Email')" />

                                <x-input id="email" class="block mt-1 w-full" type="email" name="email" required />
                            </div>
                            <!-- Address -->
                            <div>
                                <x-label for="address" :value="__('Address')" />

                                <x-input id="address" class="block mt-1 w-full" type="text" name="address" required />
                            </div>
                            <!-- Phone -->
                            <div>
                                <x-label for="phone" :value="__('Phone')" />

                                <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" required />
                            </div>
                        </div>
                        {{-- footer --}}
                        <div
                            class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                            <button type="button"
                                class="inline-block px-6 py-2.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit"
                                class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1">Add</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    @prepend('scripts')
        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('js/index.min.js') }}"></script>
        <script>
            $(document).ready(() => {
                setInterval(() => {
                    $('#student_code').focus();
                }, 500);
            });
        </script>
        <script>
            $(document).ready(() => {
                $('#addform').on('submit', (e) => {
                    e.preventDefault();

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('gatepass.visitor.add') }}",
                        data: $('#addform').serialize(),
                        success: (response) => {
                            $('#addform input').val('');
                            window.location.reload(1);
                            toggleModal('form-modal');
                        },
                        error: (error) => {
                            try {
                                if (error.responseJSON.error === undefined) {
                                    throw exception;
                                } else {
                                    alert(error.responseJSON.error);
                                }
                            } catch {
                                alert('Data Not Saved');
                            }
                            console.log(error);
                        },
                    });
                });
            });
        </script>
    @endprepend
</x-guest-layout>
