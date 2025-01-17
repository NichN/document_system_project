<?php
namespace App\Http\Controllers;
use App\Http\Controllers\DocumentController;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Http;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Log;

class cardcontroller extends Controller
{


    public function showCard()
    {
        try {
            $response = Http::get('http://localhost:8000/api/documents');

            if ($response->ok()) {
                $documents = $response->json();
            } else {
                $documents = [];
            }
        } catch (\Exception $e) {
            $documents = [];
        }

        return view('Student.Document', compact('documents'));
    }

}
