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

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'input' => ['required', 'max:15'],
        ]);

        // $grid = new Grid();
        // $grid->SizeX = 7;
        // $grid->SizeY = 7;
        // $grid->save();

        $bikeid = null;
        if($id != 0){
            $bikeid = $id;
        }

        $input = $request->input;
        $input_split1 = explode(" ", $input);

        $msg = '';
        $bike = null;
        $placeX = null;
        $placeY = null;
        $direction = null;

        if(strcmp($input_split1[0], 'PLACE') == 0){
            //self::placeCommand($input_split[1]);
            $input_split2 = explode(",", $input_split1[1]);

            if(is_numeric($input_split2[0]) && is_numeric($input_split2[1])){
                if($input_split2[0]<=7 && $input_split2[1]<=7){
                    $placeX = $input_split2[0];
                    $placeY = $input_split2[1];

                    if(strcmp($input_split2[2], 'NORTH') == 0){
                        $direction = 'NORTH';
                    }
                    elseif(strcmp($input_split2[2], 'SOUTH') == 0){
                        $direction = 'SOUTH';
                    }
                    elseif(strcmp($input_split2[2], 'EAST') == 0){
                        $direction = 'EAST';   
                    }
                    elseif(strcmp($input_split2[2], 'WEST') == 0){
                        $direction = 'WEST';
                    }
                    else{
                        $msg = 'Invalid facing direction';
                    }
                }
                else{
                    $msg = 'Position values exceeds grid size';
                }
                
            }
            else{
                $msg = 'Invalid position values';
            }  
        }
        elseif(!array_key_exists(1, $input_split1)){
            if(strcmp($input_split1[0], 'FORWARD') == 0){

            }
            elseif(strcmp($input_split1[0], 'TURN_LEFT') == 0){
    
            }
            elseif(strcmp($input_split1[0], 'TURN_RIGHT') == 0){
                
            }
            elseif(strcmp($input_split1[0], 'GPS_REPORT') == 0){
                
            }
            else{
                $msg = 'Invalid movement';
            }
        }
        else{
            $msg = 'Invalid command';
        }

        if($bikeid == null){
            if($direction != null){
                $bike = new Bike();
                $bike->placeX = $placeX;
                $bike->placeY = $placeY;
                $bike->direction= $direction;
    
                $bike->save();
    
                return Inertia::render('Main', ['bikeid' => $bike->id]);
            }
        }
        else{
            return Inertia::render('Main', ['bikeid' => $id]);
        }
        return Inertia::render('Main', ['bikeid' => $id]);
    }

    public function placeCommand(String $input){
        $input_split1 = explode(",", $input);
        return Inertia::render('Main', ['formData' => $input_split1]);
        
    }
}
