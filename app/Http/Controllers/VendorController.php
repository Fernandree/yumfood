<?php

namespace App\Http\Controllers;

use App\Http\Resources\VendorResource;
use App\Vendor;
use App\Tag;
use App\Taggables;
use App\Dishes;
use App\Vendordishes;
use App\Orders;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return VendorResource::collection(Vendor::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:128'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Make sure name is less then 128 characters or not empty'
            ], 400);
        }
        else{
            Vendor::create($request->all());
            return response()->json([
                'status' => 'ok',
                'message' => 'Vendor has been created!'
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Vendor::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Vendor::find($id)->update($request->all());

        return response()->json([
            'status' => 'ok',
            'message' => 'Vendor has been updated'
        ], 200);
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Vendor::destroy($id);

        return response()->json([
            'status' => 'ok',
            'message' => 'Vendor has been deleted!'
        ]);
    }

    public function searchTag(request $request)
    {
        $tags = $request->input('tags');      
        $res = Vendor::select('vendors.name')->distinct()
        ->join('taggables','taggables.taggable_id', '=' ,'vendors.id')
        ->join('tags','tags.id', '=' ,'taggables.tag_id');
        foreach($tags as $tag){
            $res->orwhere('tags.name', '=', $tag);
        }
        return $res->get();
        
    }

    public function searchMenu(request $request)
    {
        if($request->has('name')){ // if using name
            $validator = Validator::make($request->all(),[
                'name' => 'required|max:128',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Make sure you input vendor name!'
                ], 400);
            }else{
                $name = $request->input('name');   
                $vendor = Vendor::select('id')->where('name','=',$request->input('name'))->get();
                $data = json_decode($vendor,true);
                if(!empty($data)){
                    $res = Vendordishes::select('dishes.name','dishes.price')
                    ->join('dishes', 'vendordishes.dish_id','=', 'dishes.id')
                    ->join('vendors', 'vendors.id', '=', 'vendordishes.vendor_id')
                    ->where('vendors.name','=', $name);
                    return $res->get();
                }
                else{
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Vendor not found!'
                    ], 400);
                }
            }  
        }elseif ($request->has('id')){ // if using id
            $validator = Validator::make($request->all(),[
                'id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Make sure you input id!'
                ], 400);
            }else{
                $id = $request->input('id');   
                $vendor = Vendor::select('id')->where('id','=',$request->input('id'))->get();
                $data = json_decode($vendor,true);
                if(!empty($data)){
                    $id = $request->input('id');      
                    $res = Vendordishes::select('dishes.name','dishes.price')
                    ->join('dishes', 'vendordishes.dish_id','=', 'dishes.id')
                    ->join('vendors', 'vendors.id', '=', 'vendordishes.vendor_id')
                    ->where('vendors.id','=', $id);
                    return $res->get();
                }else{
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Vendor not found!'
                    ], 400);
                }
            }
        }
    
    }

    public function makeOrder(request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:128',
            'quantity'=> 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Make sure you input food name and quantity!'
            ], 400);
        }
        else{
            $order = new Orders;
            $dish = Dishes::select('id')->where('name','=',$request->input('name'))->get();
            $data = json_decode($dish,true);
            if(!empty($data)){
                foreach($dish as $key => $value){
                    $order->dish_id = $value['id'];
                }
                $order->name = $request->input('name');
                $order->quantity = $request->input('quantity');
                $price = Dishes::select('price')->where('name','=',$request->input('name'))->get();
                foreach($price as $key => $value){
                    $final_price = $value['price'];
                }
                $order->total_price = $final_price * $order->quantity;
                $order->request = $request->input('request');
                $order->save();
                
                return response()->json([
                    'status' => 'ok',
                    'message' => 'Order has been made!'
                ], 200);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Menu not found!'
                ], 400);
            }
            
        }
    }
    public function showOrder(request $request)
    {
        return Orders::all();        
    }
    
}
