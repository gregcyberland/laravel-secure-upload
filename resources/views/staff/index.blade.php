<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Request Account Access') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session()->has('message'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                    {{ session('message') }}
                </div>
            @endif

            @if(session()->has('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif
                <br>
            <div class=" overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-200 p-4">
                        <p class="text-xl text-gray-700">Request Form</p>
                        <div class="p-6 text-gray-900">

{{--                            @if($request->count() === 0)--}}
                                <form action="{{ route('staff.store') }}" method="POST" id="request_form" class="flex flex-col" >
                                    @csrf
                                    <div class="p-2">
                                        <label for="time" class="block text-sm font-medium text-gray-700">Time</label>
                                        <select class="mt-2" name="time">
                                            <option value="+1 minute">1 minute</option>
                                            <option value="+2 minute">2 minute</option>
                                            <option value="+3 minute">3 minute</option>
                                            <option value="+1 hour">1 hour</option>
                                            <option value="+5 hour">5 hour</option>
                                            <option value="+8 hour">8 hour</option>
                                        </select>
                                    </div>
                                    <div class="p-2">
                                        <label for="customer" class="block text-sm font-medium text-gray-700">Customer</label>
                                        <select class="mt-2" name="customer">
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer }}">{{ $customer }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="p-2">
                                        <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                                        <input type="text" name="reason" required style="width:500px;">
                                    </div>

                                    <div class="p-2">
                                        <button id="request_btn" type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ">
                                            Request
                                        </button>
                                    </div>
                                </form>
{{--                            @else--}}
{{--                                <h1 class="text-2xl font-bold mb-4">Active Request</h1>--}}

{{--                                @foreach($request as $req)--}}
{{--                                    <div class="flex justify-between items-center bg-gray-100 p-4 rounded-lg mb-4">--}}
{{--                                        <div>--}}
{{--                                            <p class="font-bold">Requested at: {{ $req->created_at->diffForHumans() }}</p>--}}
{{--                                            <p class="text-bold">Status: {{ $req->approved === 0 ? 'Pending' : 'Approve' }}</p>--}}
{{--                                            <p class="text-bold">Customer: {{ $req->customer }}</p>--}}
{{--                                            <p class="text-bold">Access Expires at: {{ $req->expiration }}</p>--}}
{{--                                            <p class="font-bold" id="timeRemainingActive">Time Remaining: </p>--}}

{{--                                            <script>--}}
{{--                                                const expirationDateA = new Date("{{ $req->expiration }}");--}}
{{--                                                const nowA = new Date();--}}

{{--                                                const timeDifferenceA = expirationDateA.getTime() - nowA.getTime();--}}
{{--                                                const secondsRemainingA = Math.floor(timeDifferenceA / 1000);--}}

{{--                                                const daysA = Math.floor(secondsRemainingA / (60 * 60 * 24));--}}
{{--                                                const hoursA = Math.floor((secondsRemainingA % (60 * 60 * 24)) / (60 * 60));--}}
{{--                                                const minutesA = Math.floor((secondsRemainingA % (60 * 60)) / 60);--}}
{{--                                                const secondsA = secondsRemainingA % 60;--}}

{{--                                                const timeRemainingActiveElement = document.getElementById('timeRemainingActive');--}}
{{--                                                timeRemainingActiveElement.textContent += `${hoursA} hours, ${minutesA} minutes, ${secondsA} seconds`;--}}
{{--                                            </script>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    @if($req->approved === 1)--}}
{{--                                        <div class="grid grid-cols-2 gap-4">--}}
{{--                                            <div>--}}
{{--                                                <input type="password" value="{{ Crypt::decryptString($req->password) }}" id="password" class="rounded-l-lg p-2 border border-gray-300 w-64" readonly>--}}
{{--                                                <button id="viewPassword" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mt-1">View Password</button>--}}
{{--                                            </div>--}}
{{--                                            <div>--}}
{{--                                                <form action="{{ route('staff.endsession') }}" method="POST">--}}
{{--                                                    @csrf--}}
{{--                                                    <input type="hidden" name="id" value="{{ $req->id }}">--}}
{{--                                                    <button id="endsession" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-500 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3">End Session</button>--}}
{{--                                                </form>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}

{{--                                @endforeach--}}

{{--                            @endif--}}

                        </div>
                    </div>
                    <div class="bg-gray-300 p-4">
                        <p class="text-xl text-gray-700">Active Sessions</p>
                        <div class="p-6 text-gray-900">
                            @if($activeSession->count() === 0)
                                <p>No active sessions</p>
                            @else
                                @foreach($activeSession as $session)
                                    <div class="flex justify-between items-center bg-gray-100 p-4 rounded-lg mb-4">
                                        <div>
                                            <p class="font-bold">User: {{ $session->user->name }}</p>
                                            <p class="font-bold">Status: {{ $session->approved === 1 ? 'Approve' : 'Pending' }}</p>
                                            <p class="font-bold">Customer: {{ $session->customer }}</p>
                                            <p class="font-bold">Requested at: {{ $session->created_at->diffForHumans() }}</p>
                                            <p class="font-bold">Expiration Date: {{ $session->expiration }}</p>
                                            <p class="font-bold" id="timeRemaining{{ $session->id }}">Time Remaining: </p>

                                            <script>
                                                const expirationDate{{ $session->id }} = new Date("{{ $session->expiration }}");
                                                const now{{ $session->id }} = new Date();

                                                const timeDifference{{ $session->id }} = expirationDate{{ $session->id }}.getTime() - now{{ $session->id }}.getTime();
                                                const secondsRemaining{{ $session->id }} = Math.floor(timeDifference{{ $session->id }} / 1000);

                                                const days{{ $session->id }} = Math.floor(secondsRemaining{{ $session->id }} / (60 * 60 * 24));
                                                const hours{{ $session->id }} = Math.floor((secondsRemaining{{ $session->id }} % (60 * 60 * 24)) / (60 * 60));
                                                const minutes{{ $session->id }} = Math.floor((secondsRemaining{{ $session->id }} % (60 * 60)) / 60);
                                                const seconds{{ $session->id }} = secondsRemaining{{ $session->id }} % 60;

                                                const timeRemainingElement{{ $session->id }} = document.getElementById('timeRemaining{{ $session->id }}');
                                                timeRemainingElement{{ $session->id }}.textContent += `${hours{{ $session->id }}} hours, ${minutes{{ $session->id }}} minutes, ${seconds{{ $session->id }}} seconds`;
                                            </script>
                                            @if($session->approved === 1 && $session->user_id === Auth::user()->id)
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <input type="password" value="{{ Crypt::decryptString($session->password) }}" id="password{{ $session->id }}" class="rounded-l-lg p-2 border border-gray-300 w-64" readonly>
                                                        <button id="viewPassword{{ $session->id }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mt-1">View Password</button>
                                                    </div>
                                                    <div>
                                                        <form action="{{ route('staff.endsession') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $session->id }}">
                                                            <button id="endsession{{ $session->id }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-500 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3">End Session</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <script>
                                                    const passwordInput{{ $session->id }} = document.getElementById('password{{ $session->id }}');
                                                    const viewPasswordButton{{ $session->id }} = document.getElementById('viewPassword{{ $session->id }}');

                                                    if (viewPasswordButton{{ $session->id }}) {
                                                        viewPasswordButton{{ $session->id }}.addEventListener('click', () => {
                                                            if (passwordInput{{ $session->id }}.type === 'password') {
                                                                passwordInput{{ $session->id }}.type = 'text';
                                                                viewPasswordButton{{ $session->id }}.textContent = 'Hide Password';
                                                            } else {
                                                                passwordInput{{ $session->id }}.type = 'password';
                                                                viewPasswordButton{{ $session->id }}.textContent = 'View Password';
                                                            }
                                                        });
                                                    }
                                                </script>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>


<script>

    // const passwordInput = document.getElementById('password');
    // const viewPasswordButton = document.getElementById('viewPassword');
    //
    // if (viewPasswordButton) {
    //     viewPasswordButton.addEventListener('click', () => {
    //         if (passwordInput.type === 'password') {
    //             passwordInput.type = 'text';
    //             viewPasswordButton.textContent = 'Hide Password';
    //         } else {
    //             passwordInput.type = 'password';
    //             viewPasswordButton.textContent = 'View Password';
    //         }
    //     });
    // }

    document.getElementById('request_form').addEventListener('submit', function() {
        var submitButton = document.getElementById('request_btn');
        submitButton.disabled = true; // Disable the button
        submitButton.innerText = 'Sending mail . . .'; // Change button text
    });
</script>
