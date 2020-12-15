<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public $successStatus = 200;

    // create main category
    public function createCategoryNode(Request $request)
    {
        $name = $request->all();
        $node = Category::create($name);
        if (!$node)
        {
            return response()->json(['error' => "error"], 404);
        }
        return response()->json(['success' => $node], $this->successStatus);
    }

    public function createSubcategory(Request $request)
    {
        $input = $request->all();
        $subcategoryName[] = $input['subcategory_name'];
        $parent = $input['parent_id'];

        $query = DB::table('categories')->where('id', $parent)->first();
        if ($query->count() == 0)
        {
            return response()->json(['error' => "error"], 404);
        }
        $update = DB::table('categories')->where('id', $parent)->update(['parent_id' => $parent]);
        if($update = false)
        {
            return response()->json(['error' => 'The subcategory has not been created. Because main category can not found'], 401);
        }

        //$subcategory = Category::create($subcategoryName, $parent);

        //$parent->children()->create($subcategoryName, $parent);
    }

    // List all categories
    public function listCategoryNode()
    {
        $queryAll = DB::table('categories')->get();
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
}
