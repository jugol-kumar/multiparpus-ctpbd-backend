<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Pos;
use App\Models\Product;
use App\Models\ProductStock;
use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $orders = Order::query()->with(['orderdetails', 'orderdetails.product', 'orderdetails.stoke'])->where('user_id', $user->id)->paginate(10);

        return response()->json([
            'message' => 'users all orders',
            'data' => $orders
        ]);
    }
    public function store(Request $request)
    {
        if(Auth::check()) {

            $address = Address::with('orderArea')->findOrFail($request->addressId);

            $grandTotal = $address->orderArea->delivery_charge + $request->orderTotal;



            $order = Order::create([
                'user_id' => $request->user()->id,
                'address_id' => $request->input('addressId'),
                'payment_method' => $request->input('paymentMethod'),
                'sub_total' => $request->orderTotal,
                'grand_total' => $grandTotal,
                'order_date' => Carbon::now(),
            ]);

            $orderDetails = [];
            foreach ($request->orders as $key => $item){
                $orderDetails[] =[
                  'order_id' => $order->id,
                  'product_id' => $item['data']['id'],
                  'product_stock_id' => $item["selectSku"]["id"],
                  'quantity' => $item["selectSku"]["selectQty"]
                ];
                $stock = ProductStock::where('id', $item["selectSku"]["id"])->first();
                $stock->qty = $stock->qty - $item["selectSku"]["selectQty"];
                $stock->save();
            }
            $order->orderdetails()->createMany($orderDetails);



//            $posProducts = Pos::all();





/*            foreach ($posProducts as $product){
                $qtyProduct = Product::findORFail($product->product_id);
                $qtyProduct->update([
                    'stock' => $qtyProduct->stock - $product->quantity
                ]);

                $oProduct['order_id'] = $order->id;
                $oProduct['product_id'] = $product->product_id;
                $oProduct['product_title'] = $product->title;
                $oProduct['product_quantity'] = $product->quantity;
                $oProduct['product_price'] = $product->price;
                $oProduct['sub_total'] = $product->sub_total;
                $oProduct['product_image'] = $product->photo;

                OrderDetails::create($oProduct);
            }
            DB::table('pos')->delete();*/

            return response()->json([
                'message' =>'Order save successfully done.',
                'data' => $order,
            ], 200);
        }


        throw new AuthenticationException();

    }
    public function show(Order $order)
    {
        return response()->json(Order::find('id',$order->id)->with('orderdetails')->first());
    }

    public function orderDetails($id){
        return Order::with('orderdetails')->findOrFail($id);
    }

    public function update(Request $request, Order $order)
    {
        //
    }
    public function destroy(Order $order)
    {
        //
    }
}