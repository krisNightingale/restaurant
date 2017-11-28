<?php

namespace App\Http\Controllers\Products;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Measure;
use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 15;

        $categoriesIds = Category::getIds();
        $categoriesNames = Category::getNames();
        $measuresIds = Measure::getIds();
        $measuresNames = Measure::getNames();

        if (!empty($keyword)) {
            $products = Product::where('name', 'LIKE', "%$keyword%")
				->orWhere('price', 'LIKE', "%$keyword%")
				->orWhere('measure_id', 'LIKE', "%$keyword%")
				->orWhere('category_id', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $products = Product::paginate($perPage);
        }

        return view('products.index', compact('products',
            'categoriesNames', 'categoriesIds',
            'measuresIds', 'measuresNames'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $measuresIds = Measure::getIds();
        $measuresNames = Measure::getNames();
        $categoriesIds = Category::getIds();
        $categoriesNames = Category::getNames();

        return view('products.create')->with(compact('measuresNames', 'measuresIds', 'categoriesNames', 'categoriesIds'));
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
			'measure_id' => 'required',
			'category_id' => 'required'
		]);
        $requestData = $request->all();
        
        Product::create($requestData);

        return redirect('products')->with('flash_message', 'Product added!');
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
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
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
        $product = Product::findOrFail($id);
        $measuresIds = Measure::getIds();
        $measuresNames = Measure::getNames();
        $categoriesIds = Category::getIds();
        $categoriesNames = Category::getNames();

        return view('products.edit', compact('product', 'measuresNames', 'measuresIds', 'categoriesNames', 'categoriesIds'));
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
			'measure_id' => 'required',
			'category_id' => 'required'
		]);
        $requestData = $request->all();
        
        $product = Product::findOrFail($id);
        $product->update($requestData);

        return redirect('products')->with('flash_message', 'Product updated!');
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
        Product::destroy($id);

        return redirect('products')->with('flash_message', 'Product deleted!');
    }

    public function filter()
    {
        $category = request()->get('category');
        $measure = request()->get('measure');
        $perPage = 15;

        $categoriesIds = Category::getIds();
        $categoriesNames = Category::getNames();
        $measuresIds = Measure::getIds();
        $measuresNames = Measure::getNames();

        if (!empty($category)) {
            $products = Product::where('category_id', '=', $category)
                ->paginate($perPage);
        } elseif (!empty($measure)) {
            $products = Product::where('measure_id', '=', $measure)
                ->paginate($perPage);
        } else {
            $products = Product::paginate($perPage);
        }

        return view('products.index', compact('products',
            'categoriesIds', 'categoriesNames',
            'measuresNames', 'measuresIds'));
    }

    public function sort()
    {
        $id = request()->get('id');
        $name = request()->get('name');
        $price = request()->get('price');

        $categoriesIds = Category::getIds();
        $categoriesNames = Category::getNames();
        $measuresIds = Measure::getIds();
        $measuresNames = Measure::getNames();

        $perPage = 15;

        if (!empty($id)) {
            $products = Product::orderBy('id', $id)->paginate($perPage);
        } elseif (!empty($name)){
            $products = Product::orderBy('name', $name)->paginate($perPage);
        } elseif (!empty($price)){
            $products = Product::orderBy('price', $price)->paginate($perPage);
        } else {
            $products = Product::paginate($perPage);
        }

        return view('products.index', compact('products',
            'categoriesNames', 'categoriesIds',
            'measuresNames', 'measuresIds'));

    }
}
