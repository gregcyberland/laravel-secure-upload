<?php

namespace App\Http\Controllers;

use App\Models\Upload;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UploadController extends Controller
{
    public function index(): View
    {
        $uploads = Upload::where('user_id', auth()->id())->get();
        return view('upload.index', compact('uploads'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'file' => 'required|file|mimes:pdf,jpeg,png,gif',
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $fileType = $file->getClientOriginalExtension();
        $filePath = $file->store('uploads');

        $upload = new Upload();
        $upload->file_name = $fileName;
        $upload->file_path = $filePath;
        $upload->file_type = $fileType;
        $upload->user_id = auth()->id();
        $upload->save();

        return redirect()->back()->with('success', 'File uploaded successfully.');
    }
    public function show($id)
    {

        $uploads = Upload::where('user_id', auth()->id())
            ->where('id', $id)
            ->first();

        if (!$uploads) {
            abort(404);
        }

        $filePath = storage_path('app/' . $uploads->file_path);

        // Check if the file exists
        if (!Storage::exists($uploads->file_path)) {
            abort(404);
        }

        // Determine the content type
        $contentType = Storage::mimeType($uploads->file_path);

        // Return response with file content
        return response()->file($filePath, ['Content-Type' => $contentType]);
    }
}
