<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(session()->has('message'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requested Access To</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Requested</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Expiration</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Link</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Session</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Table rows go here -->

                        @foreach($requests as $request)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $request->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <p>{{ ucwords($request->customer) }}</p>
                                    <small><b>REQUESTED TIME:</b><br>{{ str_replace("+", "", $request->requested) }}</small><br>
                                    <small><b>REASON:</b><br>{{ $request->reason }}</small>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ date('F j Y H:i:s', strtotime($request->date)) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">@if($request->expiration !== NULL) {{ date('F j Y H:i:s', strtotime($request->expiration)) }} @endif</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    @if($request->link !== '')
                                        <a href="{{ route('staff.approve', Crypt::encryptString($request->user_id.'_'.date("Y-m-d H:i:s", strtotime($request->date)))) }}">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3">
                                                Approve?
                                            </button>
                                        </a>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    @if($request->approved === 0)
                                        @if($request->link == '')
                                        Expired
                                        @else
                                            Pending
                                        @endif
                                    @elseif($request->approved === 1)
                                        Approved
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <!-- check if date expiration is greater than current date -->
                                    @if(strtotime($request->expiration) > strtotime(date('Y-m-d H:i:s')) && $request->approved === 1)
                                        <form action="{{ route('staff.endsession') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $request->id }}">
                                            <button id="endsession" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-500 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3">End Session</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @if(strtotime($request->expiration) > strtotime(date('Y-m-d H:i:s')) && $request->approved === 1)
                            <tr>
                                <td align="right" colspan="7" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <form action="{{ route('admin.addtime') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $request->id }}">
                                        <select class="mt-2" name="time">
                                            <option value="1">1 hour</option>
                                            <option value="2">2 hours</option>
                                            <option value="3">3 hours</option>
                                            <option value="4">4 hours</option>
                                            <option value="5">5 hours</option>
                                        </select>
                                        <button id="addtime" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-500 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3">Add Time</button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                        @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
