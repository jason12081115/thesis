<?php

namespace App\Http\Controllers\References;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\References\Subject;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;

class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::where('is_deleted', 0)->orderBy('subject_id', 'subject_description')->get();
        return Reference::collection($subjects);

        // $subjects = Subject::where('subject_code', null)->orderBy('subject_id')->get();
        // return Reference::collection($subjects);

        // $data['subjects'] = Subject::select(
        //                     'tbsubject.subject_code');
        
        // $data['subjects'] = Subject::select(
        //                 'tbsubject.*',
        //                 'sp.subject_code'
        //     )
        //                 ->leftJoin('tbsubject as sp', 'sp.subject_id', '=', 'tbsubject.subject_prerequisite_id')
        //                 ->where('tbsubject.is_deleted', 0)
        //                 ->get();

          // $subject =  DB::table('tbsubject')
          // ->leftjoin('tbsubject AS A', 'A.subject_id', '=', 'tbsubject.subject_code')
          // ->leftjoin('tbsubject AS B', 'B.subject_id', '=', 'tbsubject.subject_prerequisite_id')
          // ->select('tbsubject.*','A.subject_code as subject_prerequisite_id','B.subject_code as subject_prerequisite_id')
          // ->get();
                
          // print_r($subject);
        
       
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
                'subject_code' => 'required',
                'subject_description' => 'required',
                'subject_unit' => 'required',
                // 'subject_prerequisite_id' => 'required'
            ]
        )->validate();

        $subject = new Subject();
        $subject->subject_code = $request->input('subject_code');
        $subject->subject_description = $request->input('subject_description');
        $subject->subject_unit = $request->input('subject_unit');
        $subject->subject_prerequisite_id = $request->input('subject_prerequisite_id');
        $subject->created_datetime = Carbon::now();
        $subject->created_by = Auth::user()->id;
    
        $subject->save();

        //return json based from the resource data
        return ( new Reference( $subject ))
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
        $subject = Subject::findOrFail($id);

        return ( new Reference( $subject ) )
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
        $subject = Subject::findOrFail($id);
        
        Validator::make($request->all(),
            [
                'subject_code' => 'required',
                'subject_description' => 'required',
                'subject_unit' => 'required',
                // 'subject_prerequisite_id' => 'required'
            ]
        )->validate();

    
        $subject->subject_code = $request->input('subject_code');
        $subject->subject_description = $request->input('subject_description');
        $subject->subject_unit = $request->input('subject_unit');
        $subject->subject_prerequisite_id = $request->input('subject_prerequisite_id');
        $subject->modified_datetime = Carbon::now();
        $subject->modified_by = Auth::user()->id;


        //update  based on the http json body that is sent
        $subject->save();

        return ( new Reference( $subject ) )
            ->response()
            ->setStatusCode(200);
    }
    public function delete($id)
    {   
        $subject = Subject::findOrFail($id);

        $subject->is_deleted = 1;
        $subject->deleted_datetime = Carbon::now();
        $subject->deleted_by = Auth::user()->id;

        //update classification based on the http json body that is sent
        $subject->save();

        return ( new Reference( $subject ) )
            ->response()
            ->setStatusCode(200);
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
    public function checkIfUsed($id)
    {
        $exists = 'false';
        return $exists;
    }
}
