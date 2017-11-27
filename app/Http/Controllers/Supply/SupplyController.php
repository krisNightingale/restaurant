<?php

namespace App\Http\Controllers\Supply;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Product;
use App\Supplier;
use App\Supply;
use Illuminate\Http\Request;

class SupplyController extends Controller
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
            $supply = Supply::where('time', 'LIKE', "%$keyword%")
				->orWhere('price', 'LIKE', "%$keyword%")
				->orWhere('supplier_id', 'LIKE', "%$keyword%")
				->orWhere('is_paid', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $supply = Supply::paginate($perPage);
        }

        return view('supply.supply.index', compact('supply'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $suppliersIds = Supplier::getIds();
        $suppliersNames = Supplier::getNames();
        $productsIds = Product::getIds();
        $productsNames = Product::getNames();

        return view('supply.supply.create')->with(compact('suppliersIds', 'suppliersNames', 'productsIds', 'productsNames'));
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
			'time' => 'required',
			'price' => 'required',
			'supplier_id' => 'required',
			'is_paid' => 'required'
		]);
        $requestData = $request->all();
        
        $supply = Supply::create($requestData);

        $products = $requestData['products'];
        $amounts = $requestData['amounts'];
        for ($i = 0; $i < count($products); $i++){
            $supply->products()->attach($products[$i], ['amount' => $amounts[$i]]);
        }

        return redirect('supply/supply')->with('flash_message', 'Supply added!');
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
        $supply = Supply::findOrFail($id);

        return view('supply.supply.show', compact('supply'));
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
        $supply = Supply::findOrFail($id);

        $suppliersIds = Supplier::getIds();
        $suppliersNames = Supplier::getNames();
        $productsIds = Product::getIds();
        $productsNames = Product::getNames();

        return view('supply.supply.edit', compact('supply', 'suppliersNames', 'suppliersIds', 'productsNames', 'productsIds'));
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
			'time' => 'required',
			'price' => 'required',
			'supplier_id' => 'required',
			'is_paid' => 'required'
		]);
        $requestData = $request->all();
        
        $supply = Supply::findOrFail($id);
        $supply->update($requestData);

        $products = $requestData['products'];
        $amounts = $requestData['amounts'];
        for ($i = 0; $i < count($products); $i++){
            if ($supply->products()->find($products[$i]) != null)
                $supply->products()->updateExistingPivot($products[$i], ['amount' => $amounts[$i]]);
            else
                $supply->products()->attach($products[$i], ['amount' => $amounts[$i]]);
        }

        return redirect('supply/supply')->with('flash_message', 'Supply updated!');
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
        Supply::destroy($id);

        return redirect('supply/supply')->with('flash_message', 'Supply deleted!');
    }
}
