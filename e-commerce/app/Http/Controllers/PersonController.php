<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persons;

class PersonController extends Controller
{
    //
    public function add_person(Request $req){
        $person = new Persons;
        try{
            $person->first_name = $req->first_name;
            $person->last_name = $req->last_name;
            $person->email = $req->email;
            $person->password = $this->hashPassword($req->password);
            $person->image_url = $req->image_url;
            $person->save();
            return response()->json([
                "person"=> $person,
                "message" =>"Person added successfully"
            ]);
        }catch(\Exception $ex){
            return response()->json([
                "status"=>"error",
                "message"=> $ex->getMessage()
            ],500);
        }
        
    }

    private function hashPassword($password)
    {
        return bcrypt($password);
    }

    public function get_person(Request $req){
        $person_id = $req->person_id;
    
        try{
            $person = Persons::where("id", $person_id)->first();
            if(!$person){
                return response()->json([
                    "status"=>"error",
                    "message"=> "user not found"
                ],404);
            }

            $personWithRole = Persons::getPersonWithRole($person_id);
            $role = null;
            if($personWithRole){
                $role = $personWithRole->role->name;
            }

            return response()->json([
                "person"=> $person,
                "role" =>$role
            ]);
            
        }catch(\Exception $ex){
            return response()->json([
                "status"=>"error",
                "message"=> $ex->getMessage()
            ],500);
        }
    }

    public function update_person(Request $req){
        $person = Persons::where("id", $req->id)->first();
        if(!$person){
            return response()->json([
                "status"=>"error",
                "message"=> "user not found"
            ],404);
        }       
        try{   
            $person->update([
                "first_name" => $req->first_name ?? $person->first_name,
                "last_name" => $req->last_name ?? $person->last_name,
                "email" => $req->email ?? $person->email,
                "password" => $req->password ?? $person->password,
                "role_id" => $req->role_id ?? $person->role_id,
                "image_url" => $req->image_url ?? $person->image_url
            ]);

            return response()->json([
                "status"=> "success",
                "person"=> $person,
                "message"=> "person updated successfully"
            ]);
        }catch(\Exception $ex){
            return response()->json([
                "status"=>"error",
                "message"=> $ex->getMessage()
            ],500);
        }
        
    }

    public function delete_person(Request $req){
        $person = Persons::where("id", $req->id)->first();
        if(!$person){
            return response()->json([
                "status"=>"error",
                "message"=> "user not found"
            ],404);
        }
        try{
            $person->delete();
            return response()->json([
                "status"=> "success",
                "message"=> "person deleted successfully"
            ]);
        }catch(\Exception $ex){
            return response()->json([
                "status"=>"error",
                "message"=> $ex->getMessage()
            ],500);
        }
    }
}
