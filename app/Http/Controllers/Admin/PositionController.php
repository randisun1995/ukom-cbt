<?php

namespace App\Http\Controllers\Admin;

use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get positions
        $positions = Position::when(request()->q, function($positions) {
            $positions = $positions->where('title', 'like', '%'. request()->q . '%');
        })->latest()->paginate(5);

        //append query string to pagination links
        $positions->appends(['q' => request()->q]);

        //render with inertia
        return inertia('Admin/Positions/Index', [
            'positions' => $positions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //render with inertia
        return inertia('Admin/Positions/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate request
        $request->validate([
            'title' => 'required|string|unique:positions'
        ]);

        //create classroom
        Position::create([
            'title' => $request->title,
        ]);

        //redirect
        return redirect()->route('admin.positions.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //get classroom
        $position = Position::findOrFail($id);

        //render with inertia
        return inertia('Admin/Positions/Edit', [
            'position' => $position,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
        //validate request
        $request->validate([
            'title' => 'required|string|unique:positions,title,'.$position->id,
        ]);

        //update classroom
        $position->update([
            'title' => $request->title,
        ]);

        //redirect
        return redirect()->route('admin.positions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get classroom
        $position = Position::findOrFail($id);

        //delete classroom
        $position->delete();

        //redirect
        return redirect()->route('admin.positions.index');
    }
}