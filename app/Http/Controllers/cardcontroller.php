<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class cardcontroller extends Controller
{
    public function showcard()
    {
        $card = [
            [
                'id' => 1,
                'title' => 'SE',
                'description' => 'A systematic approach to the analysis, design,
                                implementation and maintenance of software.',
                'teacher' => 'sry chrea'

            ],
            [
                'id' => 2,
                'title' => 'Project Managemt',
                'description' => 'A systematic approach to the analysis, design,
                                implementation and maintenance of software.',
                'teacher' => 'sry chrea'
            ],
            [
                'id' => 3,
                'title' => 'HTML',
                'description' => 'A systematic approach to the analysis, design,
                                implementation and maintenance of software.',
                'teacher' => 'sry chrea'

            ],
            [
                'id' => 4,
                'title' => 'WORDPRESS',
                'description' => 'A systematic approach to the analysis, design,
                                implementation and maintenance of software.',
                'teacher' => 'sry chrea'

            ],
            [
                'id' => 5,
                'title' => 'SE',
                'description' => 'A systematic approach to the analysis, design,
                                implementation and maintenance of software.',
                'teacher' => 'sry chrea'

            ],
            [
                'id' => 6,
                'title' => 'WORDPRESS',
                'description' => 'A systematic approach to the analysis, design,
                                implementation and maintenance of software.',
                'teacher' => 'sry chrea'

            ],
            [
                'id' => 7,
                'title' => 'WORDPRESS',
                'description' => 'A systematic approach to the analysis, design,
                                implementation and maintenance of software.',
                'teacher' => 'sry chrea'

            ],
            [
                'id' => 8,
                'title' => 'WORDPRESS',
                'description' => 'A systematic approach to the analysis, design,
                                implementation and maintenance of software.',
                'teacher' => 'sry chrea'

            ]
        ];
        return view('Student.Document', compact('card'));
    }

    public function show($documentId)
    {
        // Retrieve the document details
        $document = Document::find($documentId);

        // If the document does not exist, return an error or redirect
        if (!$document) {
            return redirect()->route('document.index')->with('error', 'Document not found.');
        }

        // Pass the document to the view
        return view('document-detail', compact('document'));
    }

}
