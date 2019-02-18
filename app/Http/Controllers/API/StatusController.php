<?php

namespace App\Http\Controllers\API;

use App\PhaseOfDisbursment;
use App\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Status::latest()->paginate(5);

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
            'status_name' => 'required|string|max:191',
        ]);
        $new_status= new Status();
        $new_status->status_name = $request->all()['status_name'];
        $new_status->save();
        return response($new_status);
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
        $phase = Status::findOrFail($id);

        $this->validate($request, [
            'status_name' => 'required|string|max:191',
        ]);
        $phase->update($request->all());
        return response(['message' => 'status updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $phase = Status::findOrFail($id);

        $phase->delete();

        return response(['message' => "status Deleted"]);
    }
}
