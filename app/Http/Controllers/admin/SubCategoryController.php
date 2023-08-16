<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subCategory = SubCategory::select('sub_categories.*', 'categories.name as catName')
                    ->latest('id')
                    ->leftJoin('categories', 'sub_categories.category_id', '=', 'categories.id');
        // $subCategory->ddRawSql();

        if(!empty($request->get('keyword'))){
            $subCategory = $subCategory->where('name', 'like', '%'.$request->get('keyword').'%');
        }
        $subCategory = $subCategory->paginate(6);
        
        return view('admin.subCategory.list', compact('subCategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::orderBy('name', 'ASC')->get();
        
        return view('admin.subCategory.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'name' => 'required',
            'slug' => 'unique:sub_categories',
        ]);

        if($validator->passes()){
            $subCategory = new SubCategory();

            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->category_id = $request->category;

            $subCategory->save();
            session()->flash('success', 'Added SubCategory');

            return response()->json([
                'status' => true,
                'message' => 'Added SubCategory',
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subCategory = SubCategory::select('sub_categories.*', 'categories.name as catName')
                        ->where('sub_categories.id', $id)
                        ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
                        ->first();

        // $subCategory->ddRawSql();

        if(empty($subCategory)){
            return redirect()->route('admin.subCat.index')->with('error', 'Sub Category not found');
        }
        return view('admin.subCategory.edit', compact('subCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subCategory = SubCategory::find($id);

        if(empty($subCategory)){
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Sub Category not found',
            ]);
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'unique:sub_categories,slug,'.$subCategory->id.',id',
        ]);

        if($validator->passes()){

            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->save();
            
            // session()->forget('category_id');
            session()->flash('success', 'Sub Category update successfully');
            
            return response()->json([
                'status' => true,
                'message' => $request->name.' update successfully',
            ]);
            
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subCategory = SubCategory::find($id);

        if(empty($subCategory)){
            return redirect()->route('admin.subCat.index')
                            ->with('error', 'Category does not exist');
        }
        $subCategory->delete();

        session()->flash('success', 'Sub Category deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Sub Category deleted successfully',
        ]);
    }
}
