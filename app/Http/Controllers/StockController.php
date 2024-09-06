<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Auth::user()->stocks; 
        return Inertia::render('Home', [
            'stocks' => $stocks
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product' => 'required|string',
            'quantity' => 'required|string',
            'cost_price' => 'required|string',
            'selling_price' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        Auth::user()->stocks()->create($request->all());

        return back()->with('flash', ['success' => 'Product added successfully!']);
    }

    public function update(Request $request, Stock $product_id)
    {
        $request->validate([
            'product' => 'required|string',
            'quantity' => 'required',
            'cost_price' => 'required|string',
            'selling_price' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        $product_id->update($request->all());

        return back()->with('flash', ['success' => 'Product updated successfully!']);
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();

        return back()->with('flash', ['success' => 'Product deleted successfully!']);
    }
}
