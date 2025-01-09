<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function upload(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:Questions,Knowledge,Exam Paper,Books,Newspaper,Projects',
            'file' => 'required|file|mimes:pdf,doc,docx,txt|max:10240', // Max 10MB
        ]);

        // Store file in the "uploads" directory
        $filePath = $request->file('file')->store('uploads', 'public');

        // Save file details in the database
        $uploadedFile = Document::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'file_path' => $filePath,
            'uploaded_by' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'File uploaded successfully',
            'file' => $uploadedFile,
        ], 201);
    }

    // Download File
    public function download($id)
    {
        $file = Document::findOrFail($id);

        return Storage::disk('public')->download($file->file_path);
    }

    // List Uploaded Files
    public function index()
    {
        $files = Document::with('uploader:id,username')->get();

        return response()->json($files);
    }
}
