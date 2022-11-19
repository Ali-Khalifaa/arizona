<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $University = University::all();

        return response()->json($University);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:universities,name',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors,422);
        }

        $University = University::create([
            'name' => $request->name
        ]);
        return response()->json($University);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:universities,name,'.$id,
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors,422);
        }

        $University = University::find($id);

        $University->update([
            'name' => $request->name
        ]);

        return response()->json($University);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $University = University::find($id);

        if (count($University->leads) > 0){
            return response()->json("sorry can not delete");
        }

        $University->delete();
        return response()->json("successfully");
    }
}
