<?php

namespace App\Http\Controllers;

use App\Models\MDLUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MDLUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $learningStyles = $this->getEnumValues('mdl_url', 'learning_style');

        $topik = $this->getEnumValues('mdl_url', 'topik');


        return view('url.create', compact('learningStyles', 'topik'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:mdl_course,id',
            'name' => 'required|string',
            'url_link' => 'required',
            'description' => 'required',
            'learning_style' => 'required|string',
            'topik' => 'required|string',
        ]);


        MDLurl::create([
            'course_id' => $request->course_id,
            'name' => $request->name,
            'url_link' => $request->url_link,
            'description' => $request->description,
            'learning_style' => $request->learning_style,
            'topik' => $request->topik,
            'created_at' => now(),
        ]);
        return redirect()->back()->with('success', 'File berhasil diunggah!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }

    private function getEnumValues($table, $column)
    {
        $type = DB::select("SHOW COLUMNS FROM {$table} WHERE Field = '{$column}'")[0]->Type;

        preg_match('/^enum\((.*)\)$/', $type, $matches);

        if (!isset($matches[1])) {
            return [];
        }

        $enum = str_getcsv($matches[1], ',', "'");

        return $enum;
    }
}
