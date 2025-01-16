<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Comment;


class CommentController extends Controller
{
    public function show($documentId)
    {
        // Retrieve the document details
        $document = Document::find($documentId);

        // If the document does not exist, redirect with an error message
        if (!$document) {
            return redirect()->route('home')->with('error', 'Document not found.');
        }

        // Retrieve comments related to the document, including user details
        $comments = Comment::where('document_id', $documentId)->with('user')->get();

        // Pass the data to the view
        return view('document-detail', compact('document', 'comments'));
    }

}
