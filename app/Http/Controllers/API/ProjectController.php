<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Projects;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Projects::latest()->paginate(5);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'project_ref' => 'required|string',
            'project_title' => 'required|string|max:191',
            'date_of_gcf' => 'required|string|max:191',
            'start_date' => 'required|string',
            'duration' => 'required|string|max:191',
            'end_date' => 'required|string|max:191',
            'disbursement_id' => 'required|string',
//            'readiness_id' => 'required|string|max:191',
//            'readiness_or_nap' => 'required|string|max:191',
//            'status_id' => 'required|string|max:191',
        ]);
        $new_project = new Projects();
        $new_project->project_ref = $request->all()['project_ref'];
        $new_project->project_title = $request->all()['project_title'];
        $new_project->date_of_gcf = $request->all()['date_of_gcf'];
        $new_project->start_date = $request->all()['start_date'];
        $new_project->duration = $request->all()['duration'];
        $new_project->end_date = $request->all()['end_date'];
        $new_project->disbursement_id = $request->all()['disbursement_id'];
        $new_project->readiness_id = $request->all()['readiness_id'];
//        $new_project->readiness_or_nap = $request->all()['readiness_or_nap'];
        $new_project->status_id = $request->all()['status_id'];
        $new_project->save();
        return response($new_project);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
