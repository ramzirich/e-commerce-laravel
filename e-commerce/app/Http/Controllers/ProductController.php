<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persons;
use App\Models\Product;
use Illuminate\Http\Response;
use App\DataInfrustructure\GenericRepository;
class ProductController extends Controller
{
    //
    public function get_all_products()
    {
        $products = Product::all();
        return response()->json([
            "products" => $products
        ]);
    }
    public function create_product(Request $req){
        $product = new Product;
        try{
            $product->name = $req->name;
            $product->quantity = $req->quantity;
            $product->price = $req->price;
            $product->image_url = $req->image_url;
            $product->description = $req->description;
            $product->person_id = $req->person_id;
            $product->category_id = $req->category_id;
            $product->save();
            return response()->json([
                "person"=> $product,
                "message" =>"Product created successfully"
            ]);
        }catch(\Exception $ex){
            return response()->json([
                "status"=>"error",
                "message"=> $ex->getMessage()
            ],500);
        }
        
    }

    public function get_product(Request $req){
        try{
            $product = new GenericRepository();
            $product_result = $product->get_item( $req->id, 'product');
            $product_data = json_decode($product_result->getContent());
        
            if ($product_data && $product_data->message=="product not found") {
                return response()->json([
                    "status" => "error",
                    "message" => $product_data->message,
                ], 404);
            }
    
            $person_id = $product_data->message->person_id;
            $person_result = null;
            $person_data=null;
            if($person_id != null){
                $person_result = $product->get_item( $person_id, 'persons');
                $person_data = json_decode($person_result->getContent());
            }
    
            $category_id = $product_data->message->category_id;
            $category_data = null;
            if($category_id != null){
                $category_result = $product->get_item( $category_id, 'category');
                $category_data = json_decode($category_result->getContent());
            }
    
            if($person_data ==null){
                return response()->json([
                    "product" =>$product_result,
                    'person'=> $person_data,
                    'category'=>3
                ]);
            }
    
            return response()->json([
                "product" =>$product_data->message,
                'person'=> $person_data->message,
                'category'=>$category_data->message
            ]);
        }catch(\Exception $ex){
            return response()->json([
                "status"=>"error",
                "message"=> $ex->getMessage()
            ],500);
        }
       
    }

    public function update_product(Request $req){
        $product = Product::where("id", $req->id)->first();
        if(!$product){
            return response()->json([
                "status"=>"error",
                "message"=> "Product not found"
            ],404);
        }       
        try{   
            $product->update([
                "name" => $req->name ?? $product->name,
                "quantity" => $req->quantity ?? $product->quantity,
                "price" => $req->price ?? $product->price,
                "description" => $req->description ?? $product->description,
                "person_id" => $req->person_id ?? $product->person_id,
                "category_id" => $req->category_id ?? $product->category_id,
                "image_url" => $req->image_url ?? $product->image_url
            ]);

            return response()->json([
                "status"=> "success",
                "person"=> $product,
                "message"=> "Product updated successfully"
            ]);
        }catch(\Exception $ex){
            return response()->json([
                "status"=>"error",
                "message"=> $ex->getMessage()
            ],500);
        }       
    }

    public function delete_product(Request $req){
        $product = new GenericRepository();
        return $product->delete_item( $req->id, 'product');
    }
}
