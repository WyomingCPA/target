<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\ShopItem;
use App\Models\ShopPurchase;

use App\Models\CoinTransaction;

class ShopItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = ShopItem::latest()->get();

        return view('shop.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shop.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ShopItem::create([
            'title' => $request->title,
            'price' => $request->price,
            'repeatable' => $request->boolean('repeatable'),
        ]);

        return redirect()->route('shop.main');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShopItem $item)
    {
        return view('shop.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShopItem $item)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $item->update($validated);

        return redirect()
            ->route('shop.main')
            ->with('success', 'Товар обновлён');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        ShopItem::findOrFail($id)->delete();
        return back()->with('success', 'Удалено');
    }
    public function buy(ShopItem $item)
    {
        $user = Auth::user();

        if ($user->coins < $item->price) {
            return back()->with('error', 'Недостаточно коинов');
        }

        $user->decrement('coins', $item->price);

        ShopPurchase::create([
            'user_id' => $user->id,
            'shop_item_id' => $item->id,
        ]);
        // Регистрируем транзакцию
        CoinTransaction::create([
            'user_id' => $user->id,
            'amount' => -$item->price,
            'type' => CoinTransaction::TYPE_SPEND,
            'description' => "Покупка на сумму {$item->price} coins",
        ]);

        return back()->with('success', 'Товар куплен');
    }
    public function myPurchases()
    {
        $user = Auth::user();
        $purchases = ShopPurchase::with('shopItem')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(20);

        return view('shop.purchases', compact('purchases'));
    }

    public function usePurchase(ShopPurchase $purchase)
    {
        $user = Auth::user();
        if ($purchase->user_id !== $user->id) {
            abort(403);
        }

        $purchase->update([
            'used' => true,
        ]);

        return back()->with('success', 'Возможность использована');
    }

    public function updateNotes(Request $request, ShopPurchase $purchase)
    {
        $request->validate([
            'notes' => 'nullable|string|max:5000',
        ]);

        $purchase->update([
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Заметка сохранена');
    }
}
