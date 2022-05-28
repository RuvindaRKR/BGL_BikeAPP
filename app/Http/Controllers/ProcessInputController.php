<?php

namespace App\Http\Controllers;

use App\Models\Grid;
use App\Models\Bike;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProcessInputController extends Controller
{

    public function index(Request $request)
    {
        return Inertia::render('Main');
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'input' => ['required', 'max:15'],
        ]);

        // $grid = new Grid();
        // $grid->SizeX = 7;
        // $grid->SizeY = 7;
        // $grid->save();

        $input = $request->input;
        $input_split = explode(" ", $input);

        if(strcmp($input_split[0], 'PLACE') == 0){
            //self::placeCommand($input_split[1]);
            $input_split2 = explode(",", $input_split[1]);
        }
        elseif(!array_key_exists(1, $input_split)){
            if(strcmp($input_split[0], 'FORWARD') == 0){

            }
            elseif(strcmp($input_split[0], 'TURN_LEFT') == 0){
    
            }
            elseif(strcmp($input_split[0], 'TURN_RIGHT') == 0){
                
            }
            elseif(strcmp($input_split[0], 'GPS_REPORT') == 0){
                
            }
            else{

            }
        }
        else{

        }


        return Inertia::render('Main', ['formData' => $sum]);
    }

    public function placeCommand(String $input){
        $input_split1 = explode(",", $input);
        return Inertia::render('Main', ['formData' => $input_split1]);
        
    }
}
