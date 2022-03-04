<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Grade;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classroom::with(['grade' => function ($q) {
            $q->select('id', 'name');
        }])->get();
        $grades = Grade::all();
        return view('classrooms.classrooms', compact(['classes', 'grades']));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $list_classes = $request->List_Classes;
        foreach ($list_classes as $list_classe) {
            Classroom::create([
                'name_class' => $list_classe['name_en'],
                'grade_id'   => $list_classe['grade_id']
            ]);
        }
        toastr()->success('add with success');
        return redirect()->route('classes.index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $classe = Classroom::findOrFail($request->id);
        if ($classe) {
            $classe->update([
                'name_class' => $request->name_en,
                'grade_id'   => $request->grade_id
            ]);
            toastr()->success('record updated');
            return redirect()->route('classes.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $classe = Classroom::findOrFail($request->id);
        if ($classe) {
            $classe->delete();
            toastr()->success('record deleted');
            return redirect()->route('classes.index');
        }
    }

    public function delete_all(Request $request)
    {

        $ids = explode(",", $request->delete_all_id); // kat7awlo l array
        Classroom::whereIn('id', $ids)->delete();
        toastr()->success('records deleted');
        return redirect()->route('classes.index');
    }

    public function filterByGrade(Request $request)
    {
        $classes = Classroom::where('grade_id', $request->grade_id)->get();
        $grades = Grade::all();
        return view('classrooms.classrooms', compact(['classes', 'grades']));
    }
}
