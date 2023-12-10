<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingCart;
use App\Models\Product;
use App\Models\OrderHistory;
use App\Models\OrderDetail;
use App\DataInfrustructure\GenericRepository;

class OrderHistoryController extends Controller
{
    //
    public function create_order_history(Request $request){
        try{
            $person_id_purchase= ShoppingCart::where("person_id", $request->person_id)
        ->get();
        $total_amount = 0;
        $order_history = new OrderHistory;     
        $order_history->person_id = $request->person_id;
        $order_history->amount = $total_amount;
        $order_history->save();

        $order_id = $order_history->id;
        foreach ($person_id_purchase as $purchase) {
            $product= Product::where("id", $purchase->product_id)->first();
            $product_price  = (float)$product->price;
            $product_id = $product->id;
            $quantity = (int)$purchase->quantity;
            $total_amount += (float)$product_price * $quantity; 
            $order_detail = new OrderDetail;
            $order_detail->product_id = $product_id;
            $order_detail->amount= (float)$product_price * $quantity;
            $order_detail->quantity= $quantity;
            $order_detail->order_history_id= $order_id;
            $order_detail->save();
            ShoppingCart::where("person_id", $request->person_id)
                    ->where("product_id", $product_id)
                    ->delete();
            
        }
        $order_history->update([
            "amount" => $total_amount,
        ]);
       
        return response()->json([
            "message"=>$order_history
        ]);
        }catch(\Exception $ex){
            return response()->json([
                "status"=>"error",
                "message"=> $ex->getMessage()
            ],500);
        }       
    }

    public function delete_order_detail(Request $req){
        $order_detail = new GenericRepository();
        return $order_detail->delete_item( $req->id, '$order_detail');
    }

    public function delete_order_history(Request $req){
        try{
            OrderDetail::where("order_history_id", $req->id)->delete();
            OrderHistory::where("id", $req->id)->delete();
            return response()->json([
                "message"=>"This order has been deleted"
            ]);

        }catch(\Exception $ex){
            return response()->json([
                "status"=>"error",
                "message"=> $ex->getMessage()
            ],500);
        } 
    }

    public function get_order_history(Request $req){
        try{
            $order_history= OrderHistory::where("id", $req->id)->first();
            $orders_detail= OrderDetail::where("order_history_id", $req->id)->get();
            return response()->json([
                "order_history"=>$order_history,
                "order_detail"=>$orders_detail
            ]); 
        }catch(\Exception $ex){
            return response()->json([
                "status"=>"error",
                "message"=> $ex->getMessage()
            ],500);
        } 
    }
}
