<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Storage;
    use App\Models\Document;
    
    class DocumentController extends Controller
    {
        public function index()
        {
            $documents = Document::all();  
            return view('Admin.dashboard', compact('documents'));  
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
                $filePath = $file->store('documents', 'public');  // Store the file in public storage
                $fileExtension = $file->getClientOriginalExtension();  // Get file extension
    
                // Create new document entry in the database
                $document = Document::create([
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'type' => $request->input('type'),
                    'file_path' => $filePath,
                    'uploaded_by' => auth()->user()->id,  // Store the user ID of the uploader
                    'file_extension' => $fileExtension,  // Store file extension
                ]);
    
                return response()->json(['success' => true, 'document' => $document], 201);
            }
    
            return response()->json(['error' => 'File upload failed'], 400);
        }
    }
    
?>