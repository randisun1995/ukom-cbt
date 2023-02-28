<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Level;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get lessons
        $levels = Level::when(request()->q, function($levels) {
            $levels = $levels->where('title', 'like', '%'. request()->q . '%');
        })->latest()->paginate(5);

        //append query string to pagination links
        $levels->appends(['q' => request()->q]);

        //render with inertia
        return inertia('Admin/Levels/Index', [
            'levels' => $levels,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Admin/Levels/Create');
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
            'title' => 'required|string|unique:levels',
        ]);

        //create lesson
        Level::create([
            'title' => $request->title,
        ]);

        //redirect
        return redirect()->route('admin.levels.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //get lesson
        $level = Level::findOrFail($id);

        //render with inertia
        return inertia('Admin/Levels/Edit', [
            'level' => $level,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Level $level)
    {
        //validate request
        $request->validate([
            'title' => 'required|string|unique:levels,title,'.$level->id,
        ]);

        //update lesson
        $level->update([
            'title' => $request->title,
        ]);

        //redirect
        return redirect()->route('admin.levels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get lesson
        $level = Level::findOrFail($id);

        //delete lesson
        $level->delete();

        //redirect
        return redirect()->route('admin.levels.index');
    }
}
