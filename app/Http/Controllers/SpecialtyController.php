<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specialty = Specialty::all();

        return response()->json($specialty);
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
            'name' => 'required|string|max:100|unique:specialties,name',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors,422);
        }

        $specialty = Specialty::create([
            'name' => $request->name
        ]);
        return response()->json($specialty);
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
            'name' => 'required|string|max:100|unique:specialties,name,'.$id,
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors,422);
        }

        $specialty = Specialty::find($id);

        $specialty->update([
            'name' => $request->name
        ]);

        return response()->json($specialty);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $specialty = Specialty::find($id);

        if (count($specialty->leads) > 0){
            return response()->json("sorry can not delete");
        }

        $specialty->delete();
        return response()->json("successfully");
    }
}
