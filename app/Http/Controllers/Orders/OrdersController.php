<?php

namespace App\Http\Controllers\Orders;

use App\Client;
use App\Dish;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Order;
use App\Product;
use App\User;
use Illuminate\Http\Request;

class OrdersController extends Controller
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

        $usersIds = User::getIds();
        $usersNames = User::getNames();
        $clientsIds = Client::getIds();
        $clientsNames = Client::getNames();

        if (!empty($keyword)) {
            $orders = Order::where('time', 'LIKE', "%$keyword%")
				->orWhere('price', 'LIKE', "%$keyword%")
				->orWhere('client_id', 'LIKE', "%$keyword%")
				->orWhere('user_id', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $orders = Order::paginate($perPage);
        }

        return view('orders.index', compact('orders',
            'usersNames', 'usersIds',
            'clientsNames', 'clientsIds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $usersIds = User::getIds();
        $usersNames = User::getNames();
        $productsIds = Product::getIds();
        $productsNames = Product::getNames();
        $dishesIds = Dish::getIds();
        $dishesNames = Dish::getNames();
        $clientsIds = Client::getIds();
        $clientsNames = Client::getNames();

        return view('orders.create')->with(compact(
            'usersIds', 'usersNames',
            'productsIds', 'productsNames',
            'dishesIds', 'dishesNames',
            'clientsIds', 'clientsNames'));
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
			'price' => 'required',
			'client_id' => 'required',
			'user_id' => 'required'
		]);
        $requestData = $request->all();

        $order = Order::create($requestData);

        $products = $requestData['products'];
        $amounts = $requestData['p_amounts'];
        for ($i = 0; $i < count($products); $i++){
            $order->products()->attach($products[$i], ['amount' => $amounts[$i]]);
        }

        $dishes = $requestData['dishes'];
        $amounts = $requestData['d_amounts'];
        for ($i = 0; $i < count($dishes); $i++){
            $order->dishes()->attach($dishes[$i], ['amount' => $amounts[$i]]);
        }

        return redirect('orders')->with('flash_message', 'Order added!');
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
        $order = Order::findOrFail($id);

        return view('orders.show', compact('order'));
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
        $order = Order::findOrFail($id);
        $usersIds = User::getIds();
        $usersNames = User::getNames();
        $productsIds = Product::getIds();
        $productsNames = Product::getNames();
        $dishesIds = Dish::getIds();
        $dishesNames = Dish::getNames();
        $clientsIds = Client::getIds();
        $clientsNames = Client::getNames();

        return view('orders.edit', compact('order',
            'usersIds', 'usersNames',
            'productsIds', 'productsNames',
            'dishesIds', 'dishesNames',
            'clientsIds', 'clientsNames'));
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
			'price' => 'required',
			'client_id' => 'required',
			'user_id' => 'required'
		]);
        $requestData = $request->all();
        
        $order = Order::findOrFail($id);
        $order->update($requestData);

        $products = $requestData['products'];
        $amounts = $requestData['p_amounts'];
        for ($i = 0; $i < count($products); $i++){
            if ($order->products()->find($products[$i]) != null)
                $order->products()->updateExistingPivot($products[$i], ['amount' => $amounts[$i]]);
            else
                $order->products()->attach($products[$i], ['amount' => $amounts[$i]]);
        }

        $dishes = $requestData['dishes'];
        $amounts = $requestData['d_amounts'];
        for ($i = 0; $i < count($dishes); $i++){
            if ($order->dishes()->find($dishes[$i]) != null)
                $order->dishes()->updateExistingPivot($dishes[$i], ['amount' => $amounts[$i]]);
            else
                $order->dishes()->attach($dishes[$i], ['amount' => $amounts[$i]]);
        }

        return redirect('orders')->with('flash_message', 'Order updated!');
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
        $order = Order::find($id);
        $order->products()->detach();
        $order->dishes()->detach();
        $order->destroy($id);

        return redirect('orders')->with('flash_message', 'Order deleted!');
    }

    public function filter()
    {
        $user = request()->get('user');
        $client = request()->get('client');
        $perPage = 15;

        $usersIds = User::getIds();
        $usersNames = User::getNames();
        $clientsIds = Client::getIds();
        $clientsNames = Client::getNames();

        if (!empty($user)) {
            $orders = Order::where('user_id', '=', $user)
                ->paginate($perPage);
        } elseif (!empty($client)) {
            $orders = Order::where('client_id', '=', $client)
                ->paginate($perPage);
        } else {
            $orders = Order::paginate($perPage);
        }

        return view('orders.index', compact('orders',
            'clientsIds', 'clientsNames',
            'usersIds', 'usersNames'));
    }

    public function sort()
    {
        $id = request()->get('id');
        $time = request()->get('time');
        $price = request()->get('price');

        $usersIds = User::getIds();
        $usersNames = User::getNames();
        $clientsIds = Client::getIds();
        $clientsNames = Client::getNames();

        $perPage = 15;

        if (!empty($id)) {
            $orders = Order::orderBy('id', $id)->paginate($perPage);
        } elseif (!empty($time)){
            $orders = Order::orderBy('time', $time)->paginate($perPage);
        } elseif (!empty($price)){
            $orders = Order::orderBy('price', $price)->paginate($perPage);
        } else {
            $orders = Order::paginate($perPage);
        }

        return view('orders.index', compact('orders',
            'clientsIds', 'clientsNames',
            'usersIds', 'usersNames'));

    }
}
