<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\RolePermission;

class DocumentController extends Controller
{


    // public function upload(Request $request)
    // {
    //     try {
    //         $user = auth()->user();
    //         if (!$user) {
    //             return response()->json(['error' => 'Unauthorized - User not found'], 401);
    //         }


    //         $permissions = \DB::table('roles_permissions')->where('role', $user->role)->first();


    //         // Check upload permission
    //         if (!$permissions || !$permissions->can_upload) {
    //             return response()->json(['error' => 'Permission denied'], 403);
    //         }

    //         $validated = $request->validate([
    //             'title' => 'required|string|max:255',
    //             'description' => 'required|string',
    //             'type' => 'required|in:Questions,Knowledge,Exam Paper,Books,Newspaper,Projects',
    //             'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
    //         ]);

    //         // Store file
    //         $filePath = $request->file('file')->store('documents', 'public');
    //         // Create document record
    //         $document = Document::create([
    //             'title' => $validated['title'],
    //             'description' => $validated['description'],
    //             'type' => $validated['type'],
    //             'file_path' => $filePath,
    //             'uploaded_by' => $user->id,
    //         ]);

    //         return response()->json(['message' => 'Document uploaded successfully', 'document' => $document], 201);

    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }

    // }

    public function upload(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized - User not found'], 401);
        }

        $permissions = \DB::table('roles_permissions')->where('role', $user->role)->first();

        // Check upload permission
        if (!$permissions || !$permissions->can_upload) {
            return response()->json(['error' => 'Permission denied'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:Questions,Knowledge,Exam Paper,Books,Newspaper,Projects',
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Store file
        $filePath = $request->file('file')->store('documents', 'public');

        // Create document record
        $document = Document::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'file_path' => $filePath,
            'uploaded_by' => $user->id,
        ]);

        return response()->json(['message' => 'File uploaded successfully', 'document' => $document], 201);
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
