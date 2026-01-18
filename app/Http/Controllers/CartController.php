<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $itemuser = $request->user();
        if (!$itemuser) {
            return redirect()->route('login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $itemcart = Cart::where('user_id', $itemuser->id)
            ->where('status_cart', 'aktif')
            ->first();

        $data = array(
            'title' => 'Halaman Keranjang',
            'itemcart' => $itemcart,
        );
        return view('cart.index', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $itemcart = Cart::findOrFail($id);
        $itemcart->update($request->all());
        return redirect()->back()->with('success', 'Cart berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $itemcart = Cart::findOrFail($id);
        if ($itemcart->detail->count() > 0) {
            return redirect()->back()->with('error', 'Cart tidak bisa dihapus karena masih ada isi');
        }
        $itemcart->delete();
        return redirect()->back()->with('success', 'Cart berhasil dihapus');
    }

    /**
     * Remove all items from the specified cart.
     */
    public function kosongkan($id)
    {
        $itemcart = Cart::findOrFail($id);
        $itemcart->detail()->delete();
        $itemcart->updatetotal($itemcart, -($itemcart->subtotal));
        return redirect()->back()->with('success', 'Keranjang berhasil dikosongkan');
    }

    public function checkout(Request $request)
    {
        $itemuser = $request->user();
        if (!$itemuser) {
            return redirect()->route('login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $itemcart = Cart::where('user_id', $itemuser->id)
            ->where('status_cart', 'aktif')
            ->first();

        if (!$itemcart || $itemcart->detail->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong');
        }

        $itemalamat = \App\Models\AlamatPengiriman::where('user_id', $itemuser->id)->get();

        $data = array(
            'title' => 'Checkout',
            'itemcart' => $itemcart,
            'itemalamat' => $itemalamat,
        );
        return view('cart.checkout', $data);
    }
}
