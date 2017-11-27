<?php

namespace App\Http\Controllers\Products;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Measure;
use Illuminate\Http\Request;

class MeasuresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $measures = Measure::where('name', 'LIKE', "%$keyword%")
				->orWhere('value', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $measures = Measure::paginate($perPage);
        }

        return view('measures.index', compact('measures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('measures.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'name' => 'required',
			'value' => 'required'
		]);
        $requestData = $request->all();
        
        Measure::create($requestData);

        return redirect('measures')->with('flash_message', 'Measure added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $measure = Measure::findOrFail($id);

        return view('measures.show', compact('measure'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $measure = Measure::findOrFail($id);

        return view('measures.edit', compact('measure'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
			'name' => 'required',
			'value' => 'required'
		]);
        $requestData = $request->all();
        
        $measure = Measure::findOrFail($id);
        $measure->update($requestData);

        return redirect('measures')->with('flash_message', 'Measure updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Measure::destroy($id);

        return redirect('measures')->with('flash_message', 'Measure deleted!');
    }
}
