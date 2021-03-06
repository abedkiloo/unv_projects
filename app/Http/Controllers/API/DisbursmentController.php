<?php

namespace App\Http\Controllers\API;

use App\Disbursment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DisbursmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        return Disbursment::latest()->paginate(5);
//        return Disbursment::latest()->with(['phase_id'])->paginate(5);
        return Disbursment::latest()->with(['phase_id','projects',])->paginate(5);

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
            'amount' => 'required|integer',
            'phase_id' => 'required|integer|max:191',
            'project_id' => 'required|integer|max:191',
        ]);
        $new_disburse = new Disbursment();
        $new_disburse->amount = $request->all()['amount'];
        $new_disburse->phase_id = $request->all()['phase_id'];
        $new_disburse->project_id = $request->all()['project_id'];
        $new_disburse->save();
        return response($new_disburse);
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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $phase = Disbursment::findOrFail($id);

        $this->validate($request, [
            'amount' => 'required|integer',
            'phase_id' => 'required|integer|max:191',
            'project_id' => 'required|integer|max:191',
        ]);
        $phase->update($request->all());
        return response(['message' => 'phase updated']);
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
