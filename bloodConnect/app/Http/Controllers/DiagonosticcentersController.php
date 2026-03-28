<?php

namespace App\Http\Controllers;

use App\Models\diagonosticcenters;
use Illuminate\Http\Request;

class DiagonosticcentersController extends Controller
{
    public function addingnew(Request $request)
    {
        $diag=new diagonosticcenters();
        $diag->name=$request->name; 
        $diag->location=$request->location;
        $diag->contactno=$request->contactno;
        $diag->save() ;
        return response()->json('Added successfully!');
    }

    public function editingnew(Request $request)
    {
        $diag = diagonosticcenters::findOrFail($request->name);

        $diag->location = $request->location;
        $diag->contactno = $request->contactno;

        $diag->save();

        return response()->json('Updated successfully!');
    }

    public function deleting(Request $request)

    {
        $diag = diagonosticcenters::findOrFail($request->name)->delete();



        return response()->json('Deleted successfully!');

    }
    public function getting()
    {
        $diag = diagonosticcenters::all();      
        return response()->json($diag); 
    }
}
