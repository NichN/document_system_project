<?php
namespace App\Http\Controllers;
use App\Http\Controllers\DocumentController;
use Illuminate\Http\Request;
<<<<<<< HEAD
use App\Models\Document;
=======
use Illuminate\Support\Facades\Http;
use Psy\Readline\Hoa\Console;
>>>>>>> 4ff7031e84b6924b2d379bbe62158744c8f9252b

class cardcontroller extends Controller
{


    public function showCard()
    {
        try {
            // Fetch data from the external API
            $response = Http::get('http://127.0.0.1:3000/api/documents');

            if ($response->ok()) {
                $documents = $response->json();
                \Log::info('Documents fetched successfully:', $documents); // Debugging log
            } else {
                // Log error and set empty array
                \Log::error('Failed to fetch documents. Status: ' . $response->status());
                $documents = [];
            }
        } catch (\Exception $e) {
            // Log exception and provide fallback data
            \Log::error('Error fetching documents: ' . $e->getMessage());
            $documents = [];
        }

        return view('Student.Document', compact('documents'));
    }

}
