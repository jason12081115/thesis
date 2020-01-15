<?php

namespace App\Http\Controllers\Curriculums;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Curriculums\CurriculumYears;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;


class CurriculumYearsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $curr_years = CurriculumYears::where('is_deleted', 0)->orderBy('curriculum_year_id')->get();
        return Reference::collection($curr_years);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Validator::make($request->all(),
            [
                'curriculum_year' => 'required',
            ]
        )->validate();

        $curr_years = new CurriculumYears();
        $curr_years->curriculum_year = $request->input('curriculum_year');
        $curr_years->curriculum_desc = $request->input('curriculum_desc');
        $curr_years->created_datetime = Carbon::now();
        $curr_years->created_by = Auth::user()->id;
    
        $curr_years->save();

        //return json based from the resource data
        return ( new Reference( $curr_years ))
                ->response()
                ->setStatusCode(201);
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
    public function show($id)
    {
        $curr_years = CurriculumYears::findOrFail($id);

        return ( new Reference( $curr_years ) )
            ->response()
            ->setStatusCode(200);
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
        $curr_years = CurriculumYears::findOrFail($id);
        
        Validator::make($request->all(),
            [
                'curriculum_year' => 'required',
            ]
        )->validate();

       
        $curr_years->curriculum_year = $request->input('curriculum_year');
        $curr_years->curriculum_desc = $request->input('curriculum_desc');
        $curr_years->modified_datetime = Carbon::now();
        $curr_years->modified_by = Auth::user()->id;
    
        $curr_years->save();

        //return json based from the resource data
        return ( new Reference( $curr_years ))
                ->response()
                ->setStatusCode(201);
    }
    public function delete($id)
    {   
        $curr_years = CurriculumYears::findOrFail($id);

        $curr_years->is_deleted = 1;
        $curr_years->deleted_datetime = Carbon::now();
        $curr_years->deleted_by = Auth::user()->id;

        //update classification based on the http json body that is sent
        $curr_years->save();

        return ( new Reference( $curr_years ) )
            ->response()
            ->setStatusCode(200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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
    public function checkIfUsed($id)
    {
        $exists = 'false';
        return $exists;
    }
}
