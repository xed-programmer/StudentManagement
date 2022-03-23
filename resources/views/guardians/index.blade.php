<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2>Students</h2>
                    <!-- Button trigger modal -->
                    <button
                        class="m-4 bg-purple-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button" onclick="toggleModal('form-modal')">
                        {{ __('Add Student') }}
                    </button>
                    <div class="flex flex-col my-2">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Name') }}
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Student Code') }}
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Guardian\'s Phone') }}
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Action') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse ($guardian->students as $s)
                                                <tr class="hover:bg-gray-300">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $s->user->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $s->student_code }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $s->user->phone_number }}
                                                    </td>
                                                    <td
                                                        class="flex justify-center gap-1 px-6 py-4 text-sm text-gray-500">
                                                        <a href="{{ route('guardian.show.student', $s) }}"
                                                            class="text-xs bg-blue-300 text-blue-800 py-2 px-4 rounded-lg">
                                                            {{ __('View') }}
                                                        </a>

                                                        <form
                                                            action="{{ route('guardian.delete.student', [$guardian, $s]) }}"
                                                            method="POST"
                                                            onclick="
                                                            return confirm('Do you want to remove {{ $s->user->name }} ?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="submit" value="{{ __('Remove') }}"
                                                                class="text-xs bg-red-300 text-red-800 py-2 px-4 rounded-lg">
                                                        </form>
                                                    </td>
                                                </tr>

                                            @empty
                                                <tr>
                                                    <td>
                                                        <p class="text-gray-300 text-center">No Student</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                        {{ __('Add Student') }}
                    </h3>
                    <button
                        class="p-1 ml-auto bg-transparent border-0 text-gray-300 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
                        onclick="toggleModal('form-modal')">
                        <span class="bg-transparent h-6 w-6 text-2xl block outline-none focus:outline-none">
                            <i class="fas fa-times"></i>
                        </span>
                    </button>
                </div>
                <!--body-->
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                <form id="addform" method="POST">
                    @csrf
                    <div class="relative p-6 flex-auto">
                        <!-- Email Address -->
                        <div>
                            <x-label for="student_code" :value="__('Student Code')" />

                            <x-input id="student_code" class="block mt-1 w-full" type="text" name="student_code"
                                required autofocus />
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
                            Add Student
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
                        url: "{{ route('guardian.store.student', $guardian) }}",
                        data: $('#addform').serialize(),
                        success: (response) => {
                            alert("Student Add");
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

</x-app-layout>
