<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $request->only(['onlyData']);

        $query = User::query()->with(['addresses', 'addresses.orderArea'])
            ->where('role', 'customer');


        if($request->has('onlyData')){
            $customers = $query->get();
        }else{
            $customers = $query->paginate(20);
        }
        return response()->json($customers);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:30|min:1',
            'email' => 'required|unique:employees',
            'phone' => 'required|unique:employees',
        ]);

        if ($request->photo){
            $photo = $request->photo;
            $photo = $request->photo;
            $position = strpos($photo, ';');
            $subString = substr($photo, 0,$position);
            $imageExt = explode( '/',$subString )[1];
            $imageName = time().rand(0000,9999).'.'.$imageExt;
            $resize = Image::make($photo)->resize(200, 180)->encode('jpg');
            Storage::put("public/customers/$imageName", $resize->__toString());


            $uploadPath = "storage/customers/$imageName";

            User::create([
                'full_name' => $request->name,
                'username' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'photo' => $uploadPath,
                'password' => Hash::make(12345678)
            ]);


            return response()->json(['message' =>'Customer save with image'], 200);
        }else{
            Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'position' => $request->position,
                $userImage = ['user.svg', 'default.png'],
                'address' => $request->address,
                'photo' => 'storage/customers/'.$userImage[array_rand($userImage, 1)],
            ]);
            return response()->json(['message' =>'Customer save without image'], 200);
        }
    }
    public function show(Customer $customer)
    {
        return response()->json($customer);
    }
    public function update(Request $request, Customer $customer)
    {
        $customer->update($request->all());
        return response()->json(['message' =>'Customer update without image'], 200);
    }
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(['message' =>'Customer delete without image'], 200);
    }

    public function loginCustomer(Request $request)
    {
        $request->validate([
           'email' => 'required|email',
           'password' => 'required'
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

            if(Auth::user()->role != "customer"){
                Auth::logout();

                throw ValidationException::withMessages([
                    'email' => 'These credentials do not match our records.',
                ]);
            }

            $user = Auth::user();
            $user->token =  $user->createToken('MyApp')->plainTextToken;

            return response()->json([
               "message" => "User Registration Successfully Done...",
               "data" =>$user
            ]);
        }
        else{
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);

//            return response()->json([
//                "status" => false,
//                "message" => "Email Or Password Not Valid..."
//            ]);
        }
    }



    public function logoutCustomer(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->noContent();
    }

}
