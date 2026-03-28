<?php

namespace App\Http\Controllers;

use App\Models\bloodbanks;
use Illuminate\Http\Request;

class BloodbanksController extends Controller
{
    public function addingbloodbank(Request $request)
    {
        $diag=new bloodbanks();
        $diag->name=$request->name; 
        $diag->location=$request->location;
        $diag->contactno=$request->contactno;
        $diag->save() ;
        return response()->json('Added successfully!');
    }

    public function editingbloodbank(Request $request)
    {
        $diag = bloodbanks::findOrFail($request->name);

        $diag->location = $request->location;
        $diag->contactno = $request->contactno;

        $diag->save();

        return response()->json('Updated successfully!');
    }
    public function deletingbloodbank(Request $request)

    {
        $diag = bloodbanks::findOrFail($request->name)->delete();



        return response()->json('Deleted successfully!');

    }
    public function gettingbloodbank()
    {
        $diag = bloodbanks::all();      
        return response()->json($diag); 
    }
}
