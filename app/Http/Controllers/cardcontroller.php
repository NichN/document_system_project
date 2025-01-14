<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class cardcontroller extends Controller
{
    public function showcard(){
        $card = [
            [
                'title' => 'SE',
                'description'=> 'A systematic approach to the analysis, design,
                                implementation and maintenance of software.',
                'teacher'=>'sry chrea'
            
            ],
            [
                'title' => 'Project Managemt',
                'description'=> 'A systematic approach to the analysis, design,
                                implementation and maintenance of software.',
                'teacher'=>'sry chrea'
            ],
            [
                'title' => 'HTML',
                'description'=> 'A systematic approach to the analysis, design,
                                implementation and maintenance of software.',
                'teacher'=>'sry chrea'
            
            ],
            [
                'title' => 'WORDPRESS',
                'description'=> 'A systematic approach to the analysis, design,
                                implementation and maintenance of software.',
                'teacher'=>'sry chrea'
            
            ],
            [
                'title' => 'SE',
                'description'=> 'A systematic approach to the analysis, design,
                                implementation and maintenance of software.',
                'teacher'=>'sry chrea'
            
            ],
            [
                'title' => 'WORDPRESS',
                'description'=> 'A systematic approach to the analysis, design,
                                implementation and maintenance of software.',
                'teacher'=>'sry chrea'
            
            ],
            [
                'title' => 'WORDPRESS',
                'description'=> 'A systematic approach to the analysis, design,
                                implementation and maintenance of software.',
                'teacher'=>'sry chrea'
            
            ],
            [
                'title' => 'WORDPRESS',
                'description'=> 'A systematic approach to the analysis, design,
                                implementation and maintenance of software.',
                'teacher'=>'sry chrea'
            
            ]
        ];
        return view('Student.Document',compact('card'));
    }
}
