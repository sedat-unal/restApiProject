<?php

namespace App\Http\Controllers\API;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public $successStatus = 200;

    // create main category
    public function createCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'name' => 'required|min:3|unique:categories',
        ]);
        if($validator->fails())
        {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $category                   = Category::create($request->all());
        $success["message"]         = "The category has been created successfully";
        $success["category_id"]     = $category->id;
        $success["category_name"]   = $category->name;
        $success["category_parent"] = $category->parent_id;

        return response()->json(["success" => $success], $this->successStatus);

        // if category_parent is null the category have not any children.
    }

    public function createSubcategory(Request $request)
    {
        $validor = Validator::make($request->all(), [
            'name'          => 'required|min:3|unique:categories',
            'parent_id'     => 'required'
        ]);
        if ($validor->fails())
        {
            return \response()->json(['error' => $validor->errors()], 401);
        }
        $subcategory = Category::create($request->all());
        $success["message"]             = "The Subcategory has been created successfully";
        $success["subcategory_id"]      = $subcategory->id;
        $success["subcategory_name"]    = $subcategory->name;
        $success["subcategory_parent"]  = $subcategory->parent_id;
        return response()->json(["success" => $success], $this->successStatus);

    }

    // List all categories
    public function listCategory()
    {
        $queryAll = DB::table('categories')->where('parent_id')->get();
        if($queryAll->count() == 0)
        {
            return response()->json(["error" => "has not been created any category"], 401);
        }
        foreach ($queryAll as $item)
        {
            $list[] = $item;
        }
        return response()->json([$list], $this->successStatus);
    }

    public function listSubcategory()
    {
        $queryAll = DB::table('categories')->where('parent_id', '<>', '', 'and')->get();
        if ($queryAll->count() == 0)
        {
            return response()->json(["error" => "has not been created any category"], 401);
        }
        foreach ($queryAll as $item)
        {
            $list[] = $item;
        }
        return response()->json([$list], $this->successStatus);
    }
}
