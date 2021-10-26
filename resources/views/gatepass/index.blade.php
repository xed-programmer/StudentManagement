<x-guest-layout>
    <div class="w-full max-h-screen">
        <div class="absolute w-full h-full">
            <div class="absolute bg-black bg-opacity-20 w-full h-full"></div>
            <img class="max-h-screen w-full object-cover"
                src="https://th.bing.com/th/id/R.7acc0074168ef13706b1a5ce02f38526?rik=lsVoqtdAODPHJg&riu=http%3a%2f%2fcnnphilippines.com%2f.imaging%2fmte%2fdemo-cnn-new%2f750x450%2fdam%2fcnn%2f2020%2f4%2f25%2fCaloocan_University_CNNPH.jpg%2fjcr%3acontent%2fCaloocan_University_CNNPH.jpg&ehk=vkWBratl%2f2HnfJwphktXDvYvJ4KKT0j5w9MGDbQ2LR8%3d&risl=&pid=ImgRaw&r=0"
                alt="">
        </div>

        <div class="fixed w-full h-screen">
            <div class="h-screen flex justify-center items-center ">
                <form action="{{ route('gatepass.store') }}" method="POST">
                    @csrf
                    <div class="bg-white flex items-center rounded-full shadow-xl">
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
