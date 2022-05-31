<?php

namespace App\Http\Controllers;

use App\Models\Grid;
use App\Models\Bike;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;

class ProcessInputController extends Controller
{
    public function process(Request $request, $bikeid)
    {
        $validated = $request->validate([
            'input' => ['required', 'max:15'],
        ]);

        $msg = null;
        $bike = null;
        $placeX = null;
        $placeY = null;
        $direction = null;

        $input = $request->input;
        $input_split1 = explode(" ", $input);

        // Get bike object from db using id
        if($bikeid != 0){
            $bike = Bike::find($bikeid);
        }
        elseif($bikeid == 0 && strcmp($input_split1[0], 'PLACE') != 0){         // Return if the first command is not a place command 
            return Inertia::render('Main', ['msg' => 'Place the bike first!']);
        }

        if(strcmp($input_split1[0], 'PLACE') == 0){
            $input_split2 = explode(",", $input_split1[1]);

            if(is_numeric($input_split2[0]) && is_numeric($input_split2[1])){
                if(($input_split2[0]>=0 && $input_split2[0]<=7) && ($input_split2[1]>=0 && $input_split2[1]<=7)){  // Check if the input parameters are within grid size
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

                    if($direction != null && $bikeid == 0){
                        $bike = new Bike();
                    }
                }
                else{
                    $msg = 'Invalid position values';
                }  
            }
            else{
                $msg = 'Invalid position values';
            }  
        }
        elseif(!array_key_exists(1, $input_split1) && $bikeid != 0){            // Check if the input has only 1 argument
            $placeX = $bike->placeX;
            $placeY = $bike->placeY;
            $direction = $bike->direction;

            if(strcmp($input_split1[0], 'FORWARD') == 0){                       // Process teh FORWARD command
                if($direction == 'NORTH'){
                    if(($placeY-7) != 0){
                        $placeY += 1;
                    }
                    else{
                        $msg = 'Edge of grid reached!';
                    }
                }
                elseif($direction == 'SOUTH'){
                    if((7-$placeY) != 7){
                        $placeY -= 1;
                    }
                    else{
                        $msg = 'Edge of grid reached!';
                    }
                }
                elseif($direction == 'EAST'){
                    if(($placeX-7) != 0){
                        $placeX += 1;
                    }
                    else{
                        $msg = 'Edge of grid reached!';
                    }
                }
                elseif($direction == 'WEST'){
                    if((7-$placeX) != 7){
                        $placeX -= 1;
                    }
                    else{
                        $msg = 'Edge of grid reached!';
                    }
                }
            }
            elseif(strcmp($input_split1[0], 'TURN_LEFT') == 0){                 // Process the TURN_LEFT command
                if($direction == 'NORTH'){
                    $direction = 'WEST';
                }
                elseif($direction == 'SOUTH'){
                    $direction = 'EAST';
                }
                elseif($direction == 'EAST'){
                    $direction = 'NORTH';
                }
                elseif($direction == 'WEST'){
                    $direction = 'SOUTH';
                }
            }
            elseif(strcmp($input_split1[0], 'TURN_RIGHT') == 0){                // Process the TURN_RIGHT command
                if($direction == 'NORTH'){
                    $direction = 'EAST';
                }
                elseif($direction == 'SOUTH'){
                    $direction = 'WEST';
                }
                elseif($direction == 'EAST'){
                    $direction = 'SOUTH';
                }
                elseif($direction == 'WEST'){
                    $direction = 'NORTH';
                }
            }
            elseif(strcmp($input_split1[0], 'GPS_REPORT') == 0){                // Return bike object for the GPS_REPORT
                return Inertia::render('Main', ['bikeid' => $bikeid, 'msg' => $msg, 'bike' => $bike]);
            }
            else{
                $msg = 'Invalid command';
            }
        }
        else{
            $msg = 'Invalid command';
        }

        // Save bike attributes to db
        if($msg == null){
            $bike->placeX = $placeX;
            $bike->placeY = $placeY;
            $bike->direction = $direction;
            $bike->save();
            $bikeid = $bike->id;

            return Inertia::render('Main', ['bikeid' => $bikeid, 'success' => 'success']);
        }
        
        return Inertia::render('Main', ['bikeid' => $bikeid, 'msg' => $msg, 'success' => 'Success']);
    }
}
