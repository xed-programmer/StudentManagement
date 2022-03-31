<x-guest-layout>

    <div class="row">
        <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
            <div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center">
                <!--Left Col-->
                <div class="flex flex-col w-full md:w-2/5 justify-center items-start text-center md:text-left">
                    <h1 class="my-4 text-5xl font-bold leading-tight">
                        RFID Based Student Gate Pass With SMS Notification
                        And Web Based Monitoring
                    </h1>
                </div>
                <!--Right Col-->
                <div class="mx-auto md:w-3/5 py-6 text-center flex items-center flex-col justify-center">
                    <h1 class="my-4 text-5xl font-bold leading-tight">
                        Visitor's Gatepass
                    </h1>
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
                    <div class="mx-auto my-5 px-4 sm:px-6 lg:px-8 lg:flex lg:items-center lg:justify-center">
                        <div class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                            <form action="{{ route('gatepass.visitor.store') }}" method="POST">
                                @csrf
                                <div class="bg-gray-50 flex items-center rounded-full shadow-xl my-3">
                                    <input class="border-none rounded-full w-full py-4 px-6 text-gray-700" name="email"
                                        id="email" type="text" placeholder="Email" autofocus required>
                                </div>
                                <div class="bg-gray-50 flex items-center rounded-full shadow-xl my-3">
                                    <input class="border-none rounded-full w-full py-4 px-6 text-gray-700"
                                        name="destination" id="destination" type="text" placeholder="Destination"
                                        autofocus required>
                                </div>
                                <button
                                    class="w-full m-4 bg-purple-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                    type="submit">
                                    {{ __('Enter') }}
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- Button trigger modal -->
                    <button
                        class="m-4 bg-purple-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button" onclick="toggleModal('form-modal')">
                        {{ __('Add Visitor') }}
                    </button>
                </div>
            </div>

            <div>
                <svg viewBox="0 0 1428 174" version="1.1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g transform="translate(-2.000000, 44.000000)" fill="#FFFFFF" fill-rule="nonzero">
                            <path
                                d="M0,0 C90.7283404,0.927527913 147.912752,27.187927 291.910178,59.9119003 C387.908462,81.7278826 543.605069,89.334785 759,82.7326078 C469.336065,156.254352 216.336065,153.6679 0,74.9732496"
                                opacity="0.100000001"></path>
                            <path
                                d="M100,104.708498 C277.413333,72.2345949 426.147877,52.5246657 546.203633,45.5787101 C666.259389,38.6327546 810.524845,41.7979068 979,55.0741668 C931.069965,56.122511 810.303266,74.8455141 616.699903,111.243176 C423.096539,147.640838 250.863238,145.462612 100,104.708498 Z"
                                opacity="0.100000001"></path>
                            <path
                                d="M1046,51.6521276 C1130.83045,29.328812 1279.08318,17.607883 1439,40.1656806 L1439,120 C1271.17211,77.9435312 1140.17211,55.1609071 1046,51.6521276 Z"
                                id="Path-4" opacity="0.200000003"></path>
                        </g>
                        <g transform="translate(-4.000000, 76.000000)" fill="#FFFFFF" fill-rule="nonzero">
                            <path
                                d="M0.457,34.035 C57.086,53.198 98.208,65.809 123.822,71.865 C181.454,85.495 234.295,90.29 272.033,93.459 C311.355,96.759 396.635,95.801 461.025,91.663 C486.76,90.01 518.727,86.372 556.926,80.752 C595.747,74.596 622.372,70.008 636.799,66.991 C663.913,61.324 712.501,49.503 727.605,46.128 C780.47,34.317 818.839,22.532 856.324,15.904 C922.689,4.169 955.676,2.522 1011.185,0.432 C1060.705,1.477 1097.39,3.129 1121.236,5.387 C1161.703,9.219 1208.621,17.821 1235.4,22.304 C1285.855,30.748 1354.351,47.432 1440.886,72.354 L1441.191,104.352 L1.121,104.031 L0.457,34.035 Z">
                            </path>
                        </g>
                    </g>
                </svg>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
        id="form-modal">
        <div class="relative w-auto my-6 mx-auto max-w-sm">
            <!--content-->
            <div
                class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                <!--header-->
                <div class="flex items-start justify-between p-5 border-b border-solid border-gray-200 rounded-t">
                    <h3 class="text-xl font-semibold">
                        {{ __('Add Visitor') }}
                    </h3>
                    <button
                        class="p-1 ml-auto bg-transparent border-0 text-gray-300 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
                        onclick="toggleModal('form-modal')">
                        <span class="bg-transparent h-6 w-6 text-2xl block outline-none focus:outline-none">
                            <i class="fas fa-times"></i>
                        </span>
                    </button>
                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                </div>
                <!--body-->
                <form id="addform" method="POST">
                    @csrf
                    <div class="relative p-6 flex-auto">
                        <!-- Name -->
                        <div>
                            <x-label for="name" :value="__('Name')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
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
                    <!--footer-->
                    <div class="flex items-center justify-end p-6 border-t border-solid border-gray-200 rounded-b">
                        <button
                            class="text-purple-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            type="button" onclick="toggleModal('form-modal')">
                            Close
                        </button>
                        <button
                            class="bg-purple-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            type="submit" name="submit">
                            Add
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="form-modal-backdrop"></div>


    @prepend('scripts')
        <!-- jQuery -->
        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <script type="text/javascript">
            function toggleModal(modalID) {
                document.getElementById(modalID).classList.toggle("hidden");
                document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
                document.getElementById(modalID).classList.toggle("flex");
                document.getElementById(modalID + "-backdrop").classList.toggle("flex");
            }
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
