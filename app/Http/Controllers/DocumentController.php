<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;
use App\Models\User;


class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::all();
        if ($documents->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'No documents found'], 404);
        }
        return response()->json(['status' => 'success', 'documents' => $documents], 200);
    }

    public function create()
    {
        return view('Admin.add');
    }
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'type' => 'required|string|in:Books,Exam Paper,Questions,Knowledge',
        'file_path' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', 
    ]);
    if ($request->hasFile('file_path')) {
        $filePath = $request->file('file_path')->store('documents', 'public');
    } else {
        return back()->with('error', 'No file selected.');
    }

    $document = Document::create([
        'title' => $request->title,
        'description' => $request->description,
        'type' => $request->type,
        'file_path' => $filePath,  
        'uploaded_by' => auth()->id(), 
    ]);

    return response()->json(['status' => 'success', 'message' => 'Document uploaded successfully', 'document' => $document], 201);
}

      public function show($id)
    {
        $document = Document::find($id);
        if (!$document) {
            return response()->json(['status' => 'error', 'message' => 'Document not found'], 404);
        }
        return response()->json(['status' => 'success', 'document' => $document], 200);
    }
    public function display($id)
{
    // Fetch the document using the ID
    $document = Document::findOrFail($id);

    // Return the document details view
    return view('Student.document_detail', compact('document'));
}
    public function edit($id)
    {
        $document = Document::findOrFail($id);
        return view('Admin.edit_document', ['document' => $document]);
    }
    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|in:Books,Exam Paper,Questions,Knowledge',
        ]);

        $document->title = $request->title;
        $document->description = $request->description;
        $document->type = $request->type;

        if ($request->hasFile('file')) {
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }
            $filePath = $request->file('file')->store('uploads', 'public');
            $document->file_path = $filePath;
        }

        $document->save();

        return redirect()->route('document_dashboard')->with('success', 'Document updated successfully.');
    }

    public function destroy($id)
    {
        $document = Document::find($id);

        if (!$document) {
            return response()->json(['status' => 'error', 'message' => 'Document not found'], 404);
        }
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return response()->json(['status' => 'success', 'message' => 'Document deleted successfully'], 200);
    }
    
}


?>
