<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyLead;
use App\Models\Lead;
use App\Models\LeadCourse;
use App\Models\LeadDiploma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyLeadController extends Controller
{
    /**
     * get company leads by company id
     */
    public function companyLeadsByCompanyId($id)
    {
        $leads = Lead::with(['leadDiplomas','city'])->where([
                ['company_id',$id],
                ['black_list',0],
            ])->get();

        return response()->json($leads);
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
            'company_id' => 'required|exists:companies,id',
            'lead_id' => 'required|exists:leads,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors,422);
        }

        $company = Company::findOrFail($request->company_id);
        $lead = Lead::findOrFail($request->lead_id);
        if($lead->company_id != null)
        {
            return response()->json("sorry this lead belongs to a company",422);
        }
        $lead->update([

            "lead_type" => 1,
            "company_name" => $company->name,
            "company_id" => $request->company_id
        ]);

        return response()->json($lead);
    }

    /**
    * add Company Leads new
    */
    public function companyLeadsNew(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'arabic_name' => 'required|string|max:100',
            'english_name' => 'required|string|max:100',
            'registration_remark' => 'string',
            'phone' => 'required|unique:leads,phone',
            'email' => 'nullable|string|email|max:255|unique:leads,email',
            'city_id' => 'required|exists:cities,id',
            'interesting_level_id' => 'required|exists:interesting_levels,id',
            'education_level_id' => 'nullable|exists:education_levels,id',
            'specialty_id' => 'nullable|exists:specialties,id',
            'university_id' => 'nullable|exists:universities,id',
            'lead_source_id' => 'required|exists:lead_sources,id',
            'attendance_state' => 'required',
            'work' => 'nullable|string|max:100',
            'whatsapp_number' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'company_id' => 'required|exists:companies,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors,422);
        }
        $company = Company::findOrFail($request->company_id);

        $request_data = $request->all();
        $request_data['lead_type'] = 1;
        $request_data['company_name'] = $company->name;

        $lead = new Lead($request_data);
        $lead->save();
        //create courses lead

        if ($request->courses)
        {
            $courses = $request->courses;

            foreach ($courses as $course)
            {
                LeadCourse::create([
                    'course_id' =>$course['course_id'],
                    'lead_id' =>$lead->id,
                    'category_id'=>$course['category_id'],
                    'vendor_id'=>$course['vendor_id'],
                ]);
            }
        }

        //create diplomas lead
        if ($request->diplomas)
        {
            $diplomas = $request->diplomas;
            foreach ($diplomas as $diploma)
            {
                LeadDiploma::create([
                    'diploma_id' =>$diploma['diploma_id'],
                    'lead_id' =>$lead->id,
                    'category_id'=>$diploma['category_id'],
                    'vendor_id'=>$diploma['vendor_id'],
                ]);
            }
        }

        return response()->json($lead);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();
        return response()->json('deleted successfully');
    }
}
