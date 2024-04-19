<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Menu;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::where('pieces', '>', 0)->get();

        return inertia('Checkout/Index', [
            'menus' => $menus
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|numeric',
            'items.*.price' => 'required|numeric',
        ]);
        $free = $request->input('free');
        $items = $request->input('items');
        $totalRevenue = 0;

        foreach ($items as $item){
            $revenue = $item['quantity'] * $item['price'];
            $totalRevenue += $revenue;

            $menuItem = Menu::findOrFail($item['id']);
            $menuItem->pieces -= $item['quantity'];
            $menuItem->save();
        }

        $profit = $totalRevenue;

        $user = auth()->user();

        if($free === false) {
            $checkout = new Checkout();
            $checkout->user_id = $user->id;
            $checkout->profit = $profit;
            $checkout->save();
        }

        $updatedMenus = Menu::where('pieces', '>', 0)->get();

        return redirect()->route('checkout.index')->with(['updatedMenus' => $updatedMenus]);
    }
}
