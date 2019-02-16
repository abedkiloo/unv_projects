<?php

namespace App\Http\Controllers\API;

use App\PhaseOfDisbursment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PhaseOfDisbursment::latest()->paginate(5);

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
            'phase_name' => 'required|string|max:191',
        ]);
        $new_phase= new PhaseOfDisbursment();
        $new_phase->phase_name = $request->all()['phase_name'];
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
        $phase = PhaseOfDisbursment::findOrFail($id);

        $this->validate($request, [
            'phase_name' => 'required|string|max:191',
        ]);
        $phase->update($request->all());
        return response(['message' => 'phase updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $phase = PhaseOfDisbursment::findOrFail($id);

        $phase->delete();

        return response(['message' => "User Deleted"]);
    }
}
