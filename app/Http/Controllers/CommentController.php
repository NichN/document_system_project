<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Document;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Get comments for a specific document
    public function index(Request $request)
    {
        $documentId = $request->query('documentId');
        $document = Document::find($documentId);

        if (!$document) {
            return response()->json(['message' => 'Document not found.'], 404);
        }

        $comments = Comment::where('document_id', $documentId)->with('user')->get();

        return response()->json(['comments' => $comments]);
    }

    // Store a new comment for a specific document
    public function store(Request $request, $documentId)
    {
        // Validate the incoming request
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        // Create a new comment
        $comment = new Comment();
        $comment->document_id = $documentId;
        $comment->user_id = auth()->id();  // Assuming the user is logged in
        $comment->comment = $request->comment;
        $comment->save();

        return response()->json(['message' => 'Comment posted successfully!', 'comment' => $comment]);
    }
}
