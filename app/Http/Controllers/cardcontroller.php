<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class cardcontroller extends Controller
{
    public function showcard(){
        $card = [
            [
                'image' => asset('image/subc.png'),
                'title' => 'WORDPRESS',
                'name'=> 'Read'
            
            ],
            [
                'image' => asset('image/Norton.png'),
                'title' => 'WORDPRESS',
            
            ]
        ];
        return view('Student.Document',compact('card'));
    }
}
