<?php

namespace App\Http\Controllers\API;

use App\PhaseOfDisbursment;
use App\ReadinessType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReadinessTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ReadinessType::latest()->paginate(5);

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
            'readiness_type_name' => 'required|string|max:191',
        ]);
        $new_phase= new ReadinessType();
        $new_phase->readiness_type_name = $request->all()['readiness_type_name'];
        $new_phase->save();
        return response($new_phase);
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
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $phase = ReadinessType::findOrFail($id);

        $this->validate($request, [
            'readiness_type_name' => 'required|string|max:191',
        ]);
        $phase->update($request->all());
        return response(['message' => 'Readiness Type updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $phase = ReadinessType::findOrFail($id);

        $phase->delete();

        return response(['message' => "Readiness Type Deleted"]);
    }
}
