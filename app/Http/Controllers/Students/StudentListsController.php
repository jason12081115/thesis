<?php

namespace App\Http\Controllers\Students;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Students\StudentList;
use App\Models\Curriculums\CurriculumYears;
use App\Models\Students\Gender;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;

class StudentListsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $data['students'] = StudentList::select(
        //     'students.*',
        //     'rp.curriculum_year' 
        //     )
        //     ->leftJoin('curriculum_year as rp', 'rp.curriculum_year_id', '=', 'students.curriculum_year_id')
        //     ->where('students.is_deleted', 0)
        //     ->get();

        $student = StudentList::where('is_deleted', 0)->orderBy('student_id', 'student_no')->get();
        return Reference::collection($student);

        // $data['curr_years'] = CurriculumYears::where('is_deleted', 0)->orderBy('curriculum_year_id')->get();


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
                'student_year' => 'required',
                'student_no' => 'required',
                'last_name' => 'required',
                'first_name' => 'required',
                'student_gender' => 'required',
            ]
        )->validate();

        $student = new StudentList();
        $student->student_year = $request->input('student_year');
        $student->student_no = $request->input('student_no');
        $student->last_name = $request->input('last_name');
        $student->first_name = $request->input('first_name');
        $student->middle_name = $request->input('middle_name');
        $student->student_gender = $request->input('student_gender');
        $student->student_address = $request->input('student_address');
        $student->student_contact = $request->input('student_contact');
        $student->curriculum_year_id = $request->input('curriculum_year_id');
        $student->created_datetime = Carbon::now();
        $student->created_by = Auth::user()->id;
    
        $student->save();

        //         $items = $request->input('items');

        //         $items_dataset = [];
        //     foreach($items as $item)
        //     {
        //         $items_dataset[] = [

        //         ];
        //     }

        //     DB::table('students')->insert($items_dataset);

        //     //return json based from the resource data
        //     $data['students'] = StudentList::select(
        //         'students.*',
        //         'rg.gender_name'
        // )
        //         ->leftJoin('ref_gender as rg', 'rg.gender_id', '=', 'students.gender_id')
        //         ->findOrFail($student->student_id);

        //return json based from the resource data
        return ( new Reference( $student ))
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
        $student = StudentList::findOrFail($id);

        return ( new Reference( $student ) )
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
        $student = StudentList::findOrFail($id);
        
        Validator::make($request->all(),
            [
                'student_year' => 'required',
                'student_no' => 'required',
                'last_name' => 'required',
                'first_name' => 'required',
                'student_gender' => 'required',
            ]
        )->validate();

       
        $student->student_year = $request->input('student_year');
        $student->student_no = $request->input('student_no');
        $student->last_name = $request->input('last_name');
        $student->first_name = $request->input('first_name');
        $student->middle_name = $request->input('middle_name');
        $student->student_gender = $request->input('student_gender');
        $student->student_address = $request->input('student_address');
        $student->student_contact = $request->input('student_contact');
        $student->curriculum_year_id = $request->input('curriculum_year_id');
        $student->modified_datetime = Carbon::now();
        $student->modified_by = Auth::user()->id;


        //update  based on the http json body that is sent
        $student->save();

        return ( new Reference( $student ) )
            ->response()
            ->setStatusCode(200);
    }
    public function delete($id)
    {   
        $student = StudentList::findOrFail($id);

        $student->is_deleted = 1;
        $student->deleted_datetime = Carbon::now();
        $student->deleted_by = Auth::user()->id;

        //update classification based on the http json body that is sent
        $student->save();

        return ( new Reference( $student ) )
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
