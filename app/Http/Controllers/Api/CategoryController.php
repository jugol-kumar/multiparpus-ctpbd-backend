<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['childrenRecursive', 'parentCategory'])
//            ->where('parent_id', 0)
                ->latest()
            ->get();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:30|min:1|unique:categories',
            'photo' => 'required',
        ]);

        if (\Illuminate\Support\Facades\Request::hasFile('image')){
            $icon = \Illuminate\Support\Facades\Request::file('image')->store('category', 'public');
        }
        $data = $request->all();
        $data['parent_id'] = $request->integer('parent') ?? 0;
        $data['slug'] = Str::slug($request->name);
        $data['photo'] = $icon ??  NULL;
        $data['details'] = $request->details ??  NULL;
        Category::create($data);
        return response()->json(['message' => 'Category save successfully done.'], 200);
    }

    public function show(Category $category)
    {
        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {
        return $request;


//        $this->validate($request, [
//            'name' => 'required|max:30|min:1|unique:categories',
//        ]);
//
//        $data = $request->all();
//        $data['slug'] = Str::slug($request->name);
//        $category->update($data);
//        return response()->json(['message' => 'Category save successfully done.'], 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message' => 'Category save successfully done.'], 200);
    }


    public function updateCategory(Request $request){
        $category = Category::find($request->id);

        $this->validate($request, [
            'name' => 'required|max:30|min:1|unique:categories,name,'.$category->id,
            'description' => 'max:100'
        ]);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        if($request->hasFile('photo')){
            $this->validate($request, [
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $photo = $request->file('photo');
            $imageName = time().random_int(1,9999).'.'.$photo->getClientOriginalExtension();
            $photo->move('category/',$imageName);
            $uploadPath = "category/$imageName";
            @unlink($category->photo);
            $category->photo = $uploadPath;
        }
        if ($category->update()){
            return response()->json(['message' => 'Category update successfully done.'], 200);
        }else{
            @unlink($uploadPath);
            return response()->json(['message' => 'Have an error occurred....'], 500);
        }

    }



    public function navCategories(){

        $ids = collect(json_decode(get_setting('navCats')))->pluck('id');
        $categories = Category::query()->with(['childrenRecursive'])->whereIn('id', $ids)->get();


        return response()->json($categories);
    }




    public function homeCategories()
    {
        $categories = collect(json_decode(get_setting('navCats')))->pluck('id');
        $products = Category::query()->with(['products', 'products.images', 'products.stocks'])->whereIn('id', $categories)->get();

        $products->each(function ($product){
            $product->products->each(function($product) {
                $product->images->map(function($image) {
                    $image->url = Storage::url("uploads/$image->image");
                    return $image;
                });
            });
        });

        return response()->json($products);
    }



}

