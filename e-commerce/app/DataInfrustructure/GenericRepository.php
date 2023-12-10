<?php

namespace App\DataInfrustructure;
    class GenericRepository{
        public function get_item($id, $modelType)
        {
            try {
                $modelClass = "App\\Models\\" . ucfirst($modelType);
                if(!class_exists($modelClass)){
                    return response()->json([
                        "status" => "error",
                        "message" => ucfirst($modelType) ."Not found",
                    ], 404);
                }
                $object = $modelClass::where("id", $id)->first();
                if (!$object) {
                    return response()->json([
                        "status" => "error",
                        "message" => "product not found",
                    ], 404);
                }
                return  response()->json([
                    "message" => $object,
                ], 200);
    
            } catch (\Exception $ex) {
                return response()->json([
                    "status" => "error",
                    "message" => $ex->getMessage(),
                ], 500);
            }
        }

        public function delete_item($id, $modelType)
        {
            try {
                $modelClass = "App\\Models\\" . ucfirst($modelType);
                if(!class_exists($modelClass)){
                    return response()->json([
                        "status" => "error",
                        "message" => "Not found",
                    ], 404);
                }
                $object = $modelClass::where("id", $id)->first();
                if(!$object){
                    return response()->json([
                        "status"=>"error",
                        "message"=> "user not found"
                    ],404);
                }
               
                $object->delete();
                return response()->json([
                    "status"=> "success",
                    "message"=> ucfirst($modelType) ." deleted successfully"
                ]);
                
    
            } catch (\Exception $ex) {
                return response()->json([
                    "status" => "error",
                    "message" => $ex->getMessage(),
                ], 500);
            }
        }

    }