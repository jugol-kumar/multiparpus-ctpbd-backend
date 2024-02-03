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
            $file =  \Illuminate\Support\Facades\Request::file('image');
            $file->storeAs('uploads', [
                'disk' => 'public'
            ]);
//            $icon = $file->store('/category');

//            $icon = $file->move(public_path('/category'), 'category'.rand(1, 9999).".".$file->getClientOriginalExtension());
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
        if (\Illuminate\Support\Facades\Request::hasFile('photo')){
            $file =  \Illuminate\Support\Facades\Request::file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $icon = $file->storeAs('category', $fileName, [
                'disk' => 'public'
            ]);
        }

        return $icon;


        $data = $request->all();
        $data['parent_id'] = $request->integer('parent') ?? 0;
        $data['slug'] = Str::slug($request->name);
        $data['photo'] = $icon ??  NULL;
        $data['details'] = $request->details ??  NULL;
        $category->update($data);
        return response()->json(['message' => 'Category update successfully done.'], 200);

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


        if (\Illuminate\Support\Facades\Request::hasFile('photo')){
            $file =  \Illuminate\Support\Facades\Request::file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $icon = $file->storeAs('category', $fileName, [
                'disk' => 'public'
            ]);
        }

        $data = $request->all();
        $data['parent_id'] = $request->integer('parent') ?? 0;
        $data['slug'] = Str::slug($request->name);
        $data['photo'] = $icon ??  NULL;
        $data['details'] = $request->details ??  NULL;
        $category->update($data);

        return response()->json(['message' => 'Category update successfully done.'], 200);
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

