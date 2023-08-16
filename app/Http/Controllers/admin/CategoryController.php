<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category = Category::paginate(6);

        if(!empty($request->get('keyword'))){
            $category = $category->where('slug', 'like', '%'.$request->get('keyword').'%');
        }
        // $category = $category->paginate(6);
        
        return view('admin.category.list', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required',
            'slug' => 'unique:categories',
        ]);

        if($validator->passes()){
            if(!empty($data['image'])){
                $data['image'] = $this->saveImage($data['image']);
            }
            Category::create($data);
            session()->flash('success', 'Category added successfully');
            
            return response()->json([
                'status' => true,
                'message' => 'Category added successfully',
            ]);
            
        }
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug, Request $request)
    {
        $category = Category::where('slug', $slug)->first();
        
        if(empty($category)){
            return redirect()->route('admin.category.index')->with('error', 'Category does not exist');
        }
        
        // session()->push('category_id', $id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * PUT METHOD
     */
    public function update(Request $request, string $slug)
    {
        $category = Category::where('slug', $slug)->first();

        if(empty($category)){
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Category not found',
            ]);
        }
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required',
            'slug' => 'unique:categories,slug,'.$category->id.',id',
        ]);

        if($validator->passes()){
            if(!empty($data['image'])){
                $data['image'] = $this->saveImage($data['image'], true);

            }else{
                $data['image'] = $category->image;
            }
            $category->update($data);
            session()->flash('success', 'Category update successfully');
            
            return response()->json([
                'status' => true,
                'message' => $request->name.' update successfully',
            ]);
            
        }
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if(empty($category)){
            return redirect()->route('admin.category.index')
                            ->with('error', 'Category does not exist');
        }
        File::delete(public_path().'/uploads/categories/'.$category->image);
        $category->delete();

        session()->flash('success', 'Category deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully',
        ]);
    }

    public function createSlug(Request $request){
        $slug = '';

        if(!empty($request->title)){
            $slug = Str::slug($request->title);
        }
        return response()->json([
            'status' => true,
            'slug' => $slug,
        ]);
    }

    public function saveImage($image_id, $isUpload = false){
        
        $tempImage = TempImage::find($image_id);
        $extA = explode('.', $tempImage->name);
        $ext = last($extA);

        $newImage = time().'.'.$ext;
        $sPath = public_path().'/temp'.'/'.$tempImage->name;
        $dPath = public_path().'/uploads/categories/'.$newImage;

        if($isUpload && !empty($oldImage))
            File::delete(public_path().'/uploads/categories/'.$oldImage);

        File::copy($sPath, $dPath);
        File::delete($sPath);

        return $newImage;
    }

}
