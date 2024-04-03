<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Upload') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('upload.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file">
                        <button type="submit">Upload</button>
                    </form>

                    <div class="mt-3">
                        @if ($uploads->count() > 0)
                            <ul>
                                @foreach ($uploads as $upload)
                                    <x-view-pdf :id="$upload->id" :name="$upload->file_name" :path="$upload->file_path" :type="$upload->file_type" />
                                @endforeach
                            </ul>
                        @else
                            <p>No files uploaded yet.</p>
                        @endif
                    </div>

                    <img src="myuploads/show/12">
                    <embed src="http://127.0.0.1:8000/myuploads/show/13">

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
