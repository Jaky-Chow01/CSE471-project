<?php

namespace App\Http\Controllers;

use App\Models\bloodtype;
use Illuminate\Http\Request;

class BloodtypeController extends Controller
{
    //
    public function adding(Request $request)
    {

        $items=new bloodtype();
        $items->blood_group=$request->blood_group ;
        $items->antigens_on_RBC=$request->antigens_on_RBC ;
        $items->antibodies_in_plasma=$request->antibodies_in_plasma;
        $items->can_donate_to=$request->can_donate_to;
        $items->can_receive_from=$request->can_receive_from;
        $items->save();
        return response()->json('Added successfully!');
       
        
    }
    public function edit(Request $request)
    {
        
        $bloodType = bloodtype::findOrFail($request->blood_group);

        $bloodType->antigens_on_RBC = $request->antigens_on_RBC;
        $bloodType->antibodies_in_plasma = $request->antibodies_in_plasma;
        $bloodType->can_donate_to = $request->can_donate_to;
        $bloodType->can_receive_from = $request->can_receive_from;

        $bloodType->save();

        return response()->json('Updated successfully!');
    }

    public function delete(Request $request)
    {
        
        $bloodType = bloodtype::findOrFail($request->blood_group);

        
        $bloodType->delete();

        return response()->json('Deleted successfully!');
    }

    public function show()
    {
        $items=Bloodtype::all();
        return response()->json($items);
    }

}