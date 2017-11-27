<?php

namespace App\Http\Controllers\Products;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Dish;
use App\Product;
use Illuminate\Http\Request;

class DishesController extends Controller
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
            $dishes = Dish::where('name', 'LIKE', "%$keyword%")
				->orWhere('price', 'LIKE', "%$keyword%")
				->orWhere('weight', 'LIKE', "%$keyword%")
				->orWhere('category_id', 'LIKE', "%$keyword%")
				->orWhere('description', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $dishes = Dish::paginate($perPage);
        }

        return view('dishes.index', compact('dishes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categoriesIds = Category::getIds();
        $categoriesNames = Category::getNames();
        $productsIds = Product::getIds();
        $productsNames = Product::getNames();

        return view('dishes.create')->with(compact('categoriesIds', 'categoriesNames', 'productsIds', 'productsNames'));
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
            'price' => 'required',
            'weight' => 'required',
            'category_id' => 'required'
        ]);
        $requestData = $request->all();

        $dish = Dish::create($requestData);

        $products = $requestData['products'];
        $amounts = $requestData['amounts'];
        for ($i = 0; $i < count($products); $i++){
            if ($products[$i] != 0)
                $dish->products()->attach($products[$i], ['amount' => $amounts[$i]]);
        }

        return redirect('dishes')->with('flash_message', 'Dish added!');
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
        $dish = Dish::findOrFail($id);

        return view('dishes.show', compact('dish'));
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
        $dish = Dish::findOrFail($id);
        $categoriesIds = Category::getIds();
        $categoriesNames = Category::getNames();
        $productsIds = Product::getIds();
        $productsNames = Product::getNames();

        return view('dishes.edit', compact('dish', 'categoriesIds', 'categoriesNames', 'productsNames', 'productsIds'));
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
			'price' => 'required',
			'weight' => 'required',
			'category_id' => 'required'
		]);
        $requestData = $request->all();
        
        $dish = Dish::findOrFail($id);
        $dish->update($requestData);

        $products = $requestData['products'];
        $amounts = $requestData['amounts'];
        for ($i = 0; $i < count($products); $i++){
            if ($dish->products()->find($products[$i]) != null)
                $dish->products()->updateExistingPivot($products[$i], ['amount' => $amounts[$i]]);
            else
                $dish->products()->attach($products[$i], ['amount' => $amounts[$i]]);
        }

        return redirect('dishes')->with('flash_message', 'Dish updated!');
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
        Dish::destroy($id);

        return redirect('dishes')->with('flash_message', 'Dish deleted!');
    }
}
