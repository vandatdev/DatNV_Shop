<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {        
        $products = Product::latest()->with('sub_category')->paginate(5);
        // dd($products);

        if(!empty($request->get('keyword'))){
            $products = $products->where('slug', 'like', '%'.$request->get('keyword').'%');
        }
        
        return view('admin.product.list', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('id', 'ASC')->get();
        
        return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required',
            'slug' => 'unique:products',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'sku' => 'required',
            'sub_category_id' => 'required',
            'quantity' => 'required|min:0',
        ]);

        if($validator->passes()){
            $data['created_by'] = $request->user()->id;

            if(!empty($data['image'])){
                $data['image'] = $this->saveImage($data['image']);
            }
            Product::create($data);
            session()->flash('success', 'Product added successfully');
            
            return response()->json([
                'status' => true,
                'message' => $request->name.' added successfully',
            ]);

        }else{
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $product = Product::where('slug', $slug)->with('sub_category')->first();
        
        if(empty($product)){
            return redirect()->route('admin.product.index')->with('error', 'Product not found!');
        }
        $categories = Category::orderBy('id')->with('sub_category')->get();

        $product_category = $product->sub_category->category_id;
        $sub_categories = SubCategory::where('category_id', $product_category)->orderBy('name')->get();

        
        return view('admin.product.edit', compact('product', 'categories', 'sub_categories', 'product_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $product = Product::where('slug', $slug)->first();

        if(empty($product)){
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Product not found',
            ]);
        }

        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required',
            'slug' => 'unique:products,slug,'.$product->id.',id',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'sku' => 'required',
            'sub_category_id' => 'required',
            'quantity' => 'required|min:0',
        ]);

        if($validator->passes()){
            $data['updated_by'] = $request->user()->id;

            if(!empty($data['image'])){
                $data['image'] = $this->saveImage($data['image']);

            }else{
                $data['image'] = $product->image;
            }

            $product->update($data);
            session()->flash('success', 'Product updated successfully');
            
            return response()->json([
                'status' => true,
                'message' => $request->name.' updated successfully',
            ]);

        }
        return response()->json([
            'errors' => $validator->errors(),
            'status' => false,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if(empty($product)){
            return redirect()->route('admin.product.index')
                            ->with('error', 'product does not exist');
        }
        File::delete(public_path().'/uploads/products/'.$product->image);
        $product->delete();

        session()->flash('success', 'Product deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully',
        ]);
    }


    public function getSubCategories(Request $request){

        if(!empty($request->category_id)){
            $subCats = SubCategory::where('category_id', $request->category_id)
            ->orderBy('name', 'ASC')
            ->get();

            return response()->json([
                'status' => true,
                'subCats' => $subCats,
            ]);
        }
        return response()->json([
            'status' => false,
            'subCats' => [],
        ]);
    }

    public function saveImage($image_id){
        
        $tempImage = TempImage::find($image_id);
        $extA = explode('.', $tempImage->name);
        $ext = last($extA);

        $newImage = time().'.'.$ext;
        $sPath = public_path().'/temp'.'/'.$tempImage->name;
        $dPath = public_path().'/uploads/products/'.$newImage;

        File::copy($sPath, $dPath);
        File::delete($sPath);

        return $newImage;
    }
}
