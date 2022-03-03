<?php

namespace App\Http\Controllers\Grades;

use App\Http\Controllers\Controller;
use App\Http\Requests\GradeRequest;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grades = Grade::get();
        return view('grades.grades', compact('grades'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GradeRequest $request)
    {
        // Grade::create([
        //     'name'=>$request->name,
        //     'notes' => $request->notes
        // ]);

        $grade = new Grade();

        // $grade->name=['en' => $request->name_en, 'ar' => $request->name];
        $grade->name = $request->name;
        $grade->notes = $request->notes;

        $grade->save();
        toastr()->success('Data has been saved successfully!');
        return redirect()->route('grades.index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(GradeRequest $request,$id)
    {
        $grade = Grade::findOrFail($id);
        if ($grade) {
            $grade->update([
                'name' => $request->name,
                'notes' => $request->notes
            ]);
            toastr()->success('Data has been saved successfully!');
            return redirect()->route('grades.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $grade = Grade::findOrFail($request->id);
        if ($grade) {
            $grade->delete();
            toastr()->error('Data has been deleted successfully!');
            return redirect()->route('grades.index');
        }
    }
}
