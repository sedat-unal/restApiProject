<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Subcategories;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class SubcategoryController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sub_name' => 'required',
            'root_catID' => 'required'
        ]);
        if ($validator->fails())
        {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $subCategory = Subcategories::create($input);
        $success['message'] = "Subcategory Created Successfully";
        $success['sub_name'] = $subCategory->sub_name;

        return response()->json(['success' => $success], $this->successStatus);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $sql = DB::table('subcategories')->get();
        if(DB::table('subcategories')->count() == 0)
        {
            return response()->json(['error' => 'Has not been created a Subcategory'], 400);
        }
        else
        {
            return response()->json([$sql], $this->successStatus);

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
