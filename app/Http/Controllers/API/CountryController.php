<?php

namespace App\Http\Controllers\API;

use App\Country;
use App\PhaseOfDisbursment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Country::latest()->paginate(5);

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
            'country_name' => 'required|string|max:191',
        ]);
        $new_country= new Country();
        $new_country->country_name = $request->all()['country_name'];
        $new_country->save();
        return response($new_country);
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
        $phase = Country::findOrFail($id);

        $this->validate($request, [
            'country_name' => 'required|string|max:191',
        ]);
        $phase->update($request->all());
        return response(['message' => 'country updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $phase = Country::findOrFail($id);

        $phase->delete();

        return response(['message' => "User Deleted"]);
    }
}
