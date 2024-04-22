<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kill All login session') }}
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

                        @if(session()->has('error'))
                            <div class="bg-red-100 border-l-4 border-red-500 p-4" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                    <form action="{{ route('admin.logoutAll') }}" method="POST" id="killall_form" class="flex flex-col" >
                        @csrf
                        <div class="p-2">
                            <label for="killall" class="block text-sm font-medium text-gray-700">Enter Admin Password</label>
                            <input type="password" name="password" required>
                            <button id="killall_btn" type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ">Kill All</button>
                        </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
