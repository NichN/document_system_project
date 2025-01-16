<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;

class DocumentController extends Controller
{
    public function index()
    {
        return view('Admin.dashboard');
    }

    public function create()
    {
        return view('Admin.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'type' => 'required|string',
            'document' => 'required|file|mimes:pdf,docx,doc,jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('document') && $request->file('document')->isValid()) {
            $file = $request->file('document');
            $filePath = $file->store('documents', 'public');

            $document = Document::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'type' => $request->input('type'),
                'file' => $filePath,
                'uploaded_by' => auth()->user()->id, 
            ]);

            return response()->json(['success' => true, 'document' => $document], 201);
        }

        return response()->json(['error' => 'File upload failed'], 400);
    }

    public function getDocuments()
    {
        $documents = Document::all();
        return view('Admin.dashboard', compact('documents'));
    }
    
}
