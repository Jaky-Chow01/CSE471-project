<?php

namespace App\Http\Controllers;

use App\Models\diagonosticcenters;
use Illuminate\Http\Request;

class DiagonosticcentersController extends Controller
{
    public function index()
    {
        $centers = diagonosticcenters::all();
        return view('diagnostic-centers', compact('centers'));
    }

    public function addingnew(Request $request)
    {
        $diag=new diagonosticcenters();
        $diag->name=$request->name;
        $diag->description=$request->description;
        $diag->location=$request->location;
        $diag->contactno=$request->contactno;
        $diag->services=$request->services;
        $diag->prices=$request->prices;
        $diag->operating_hours=$request->operating_hours;
        $diag->emergency_services=$request->emergency_services ?? false;
        $diag->save() ;
        return response()->json('Added successfully!');
    }

    public function editingnew(Request $request)
    {
        $diag = diagonosticcenters::findOrFail($request->id);

        $diag->name = $request->name;
        $diag->description = $request->description;
        $diag->location = $request->location;
        $diag->contactno = $request->contactno;
        $diag->services = $request->services;
        $diag->prices = $request->prices;
        $diag->operating_hours = $request->operating_hours;
        $diag->emergency_services = $request->emergency_services ?? false;

        $diag->save();

        return response()->json('Updated successfully!');
    }

    public function deleting(Request $request)

    {
        $diag = diagonosticcenters::findOrFail($request->id)->delete();

        return response()->json('Deleted successfully!');

    }
    public function getting()
    {
        $diag = diagonosticcenters::all();
        return response()->json($diag);
    }
}
