<?php

namespace App\Http\Controllers\Curriculums;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\References\Subject;
use App\Models\Curriculums\CurriculumYears;
use App\Models\Curriculums\CurriculumLists;
use App\Models\Curriculums\CurriculumItems;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class CurriculumListsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['curriculums'] = CurriculumLists::select(
            'curriculum_list.*',
            'rp.curriculum_year'
            
)
            ->leftJoin('curriculum_year as rp', 'rp.curriculum_year_id', '=', 'curriculum_list.curriculum_year_id')
            ->where('curriculum_list.is_deleted', 0)
            ->get();
    
        $data['subjects'] = Subject::where('is_deleted', 0)->orderBy('subject_id')->get();
        $data['curr_years'] = CurriculumYears::where('is_deleted', 0)->orderBy('curriculum_year_id')->get();


return $data;
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
            'curriculum_year_id' => 'required'
        ]
    )->validate();
    $curriculums = new CurriculumLists();
    $curriculums->curriculum_year_id = $request->input('curriculum_year_id');
    $curriculums->created_datetime = Carbon::now();
    $curriculums->created_by = Auth::user()->id;

    $curriculums->save();

    
    $items = $request->input('items');
    

    $items_dataset = [];
    foreach($items as $item)
    {
        $items_dataset[] = [
            'curriculum_list_id'=>$curriculums->curriculum_list_id,
            'subject_id'=>$item['subject_id']
    
        ];
    }

    DB::table('curriculum_item')->insert($items_dataset);

    //return json based from the resource data
    $data = CurriculumLists::select(
        'curriculum_list.*',
        'rp.curriculum_year'
        )

        ->leftJoin('curriculum_year as rp', 'rp.curriculum_year_id', '=', 'curriculum_list.curriculum_year_id')
        ->findOrFail($curriculums->curriculum_list_id);

    return ( new Reference( $data ) )
        ->response()
        ->setStatusCode(200);
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
        $data['curriculums'] = CurriculumLists::select(
            'curriculum_list.*',
            'rp.curriculum_year'
        )

            ->leftJoin('curriculum_year as rp', 'rp.curriculum_year_id', '=', 'curriculum_list.curriculum_year_id')
            ->findOrFail($id);

            $data['curriculumitems'] = CurriculumItems::select(
                'curriculum_item.*',
                'rs.subject_code',
                'rs.subject_description',
                'rs.subject_unit',
                'rs.subject_prerequisite_id'
            )
                ->leftJoin('tbsubject as rs', 'rs.subject_id', '=', 'curriculum_item.subject_id')
                ->where('rs.is_deleted', 0)
                ->where('curriculum_list_id', $id)
                ->get();


return $data;
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
        Validator::make($request->all(),
        [
            'curriculum_year_id' => 'required'
        ]
    )->validate();
   
    $curriculums->curriculum_year_id = $request->input('curriculum_year_id');
    $curriculums->modified_datetime = Carbon::now();
    $curriculums->modified_by = Auth::user()->id;

    $curriculums->save();

    $items = $request->input('items');
    $olditems = CurriculumItems :: where ('curriculum_list_id', $curriculums->curriculum_list_id);
    $olditems->delete();

    $items_dataset = [];
    foreach($items as $item)
    {
        $items_dataset[] = [
            'curriculum_list_id'=>$curriculums->curriculum_list_id,
            'subject_id'=>$item['subject_id'],
            'subject_code'=>$item['subject_code'],
            'subject_description'=>$item['subject_description'],
            'subject_unit'=>$item['subject_unit'],
            'subject_prerequisite_id'=>$item['subject_prerequisite_id']
           
        ];
    }

    DB::table('curriculum_item')->insert($items_dataset);

        //update  based on the http json body that is sent
        $curriculums = CurriculumLists::select(
            'curriculum_list.*',
            'rp.subject_id'
        )

            ->leftJoin('tbsubject as rp', 'rp.subject_id', '=', 'curriculum_list.subject_id')
            ->findOrFail($id);

        return ( new Reference( $curriculums ) )
            ->response()
            ->setStatusCode(200);
    }

    //
    //
    //
    //

    public function delete($id)
    {   
        $curriculums = CurriculumLists::findOrFail($id);
        $curriculums->is_deleted = 1;
        $curriculums->deleted_datetime = Carbon::now();
        $curriculums->deleted_by = Auth::user()->id;

        //update classification based on the http json body that is sent
        $curriculums->save();

        return ( new Reference( $curriculums ) )
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
