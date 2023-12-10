<?php

namespace App\Http\Controllers;
use App\DataInfrustructure\GenericRepository;
use App\Models\ShoppingCart;

use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    //
    public function create_update_shopping_cart(Request $req){
        $shopping_cart = new ShoppingCart;
        $shopping_cart_generic = new GenericRepository();
        try{
            $shopping_cart_find = ShoppingCart::where("person_id", $req->person_id)
                    ->where("product_id", $req->product_id)
                    ->first();
                if(!$shopping_cart_find){
                    $shopping_cart->person_id = $req->person_id;
                    $shopping_cart->product_id = $req->product_id;
                    $shopping_cart->quantity = $req->quantity;
                    $shopping_cart->save();
                    return response()->json([
                        "status"=> "success",
                        "shopping_cart"=> $shopping_cart,
                        "message" =>"Shopping cart created successfully"
                    ]);
            }else{
                $updated_shopping_cart = ShoppingCart::where("person_id", $req->person_id)
                    ->where("product_id", $req->product_id)
                    ->update([    
                    "quantity" => $req->quantity ?? $shopping_cart->quantity,
                ]);
    
                return response()->json([
                    "status"=> "success",
                    "shopping_cart"=> $updated_shopping_cart,
                    "message"=> "Shopping cart updated successfully"
                ]);
            }
        }catch(\Exception $ex){
            return response()->json([
                "status"=>"error",
                "message"=> $ex->getMessage()
            ],500);
        }     
    }

    public function get_shopping_cart(Request $req){
        try{
            $shopping_cart = ShoppingCart::where("person_id", $req->person_id)
                    ->where("product_id", $req->product_id)
                    ->first();

            if(!$shopping_cart){
                return response()->json([
                    "shopping_cart" =>"shopping cart not found"
                ],404);
            }

            return response()->json([
                "shopping_cart" =>$shopping_cart
            ]);

        }catch(\Exception $ex){
            return response()->json([
                "status"=>"error",
                "message"=> $ex->getMessage()
            ],500);
        }     
    }

    public function delete_shopping_cart(Request $req){
        try{
            $shopping_cart = ShoppingCart::where("person_id", $req->person_id)
                    ->where("product_id", $req->product_id)
                    ->delete();

            if($shopping_cart){
                return response()->json([
                    "status" => "success",
                    "message" => "Item deleted successfully"
                ]);
            }
            else {
                return response()->json([
                    "status" => "error",
                    "message" => "Item not found"
                ], 404);
            }
        }
        catch(\Exception $ex){
            return response()->json([
                "status"=>"error",
                "message"=> $ex->getMessage()
            ],500);
        } 
    }
}
