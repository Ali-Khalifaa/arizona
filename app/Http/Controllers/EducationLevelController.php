<?php

namespace App\Http\Controllers;

use App\Models\EducationLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EducationLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $levels = EducationLevel::all();

        return response()->json($levels);
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
            'name' => 'required|string|max:100|unique:education_levels,name',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors,422);
        }

        $level = EducationLevel::create([
            'name' => $request->name
        ]);
        return response()->json($level);
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
            'name' => 'required|string|max:100|unique:education_levels,name,'.$id,
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors,422);
        }

        $level = EducationLevel::find($id);

        $level->update([
            'name' => $request->name
        ]);

        return response()->json($level);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $level = EducationLevel::find($id);

        if (count($level->leads) > 0){
            return response()->json("sorry can not delete");
        }

        $level->delete();
        return response()->json("successfully");
    }
}
