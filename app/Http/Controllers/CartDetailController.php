<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Produk;
use App\Models\ProdukPromo;
use Illuminate\Http\Request;

class CartDetailController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required',
        ]);
        $itemuser = $request->user();
        if (!$itemuser) {
            return redirect()->route('login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $itemproduk = Produk::findOrFail($request->produk_id);

        // cek dulu apakah sudah ada pesanan di cart dengan status aktif
        $itemcart = Cart::where('user_id', $itemuser->id)
            ->where('status_cart', 'aktif')
            ->first();
        if ($itemcart) {
            $cart = $itemcart;
        } else {
            $no_invoice = Cart::where('user_id', $itemuser->id)->count();
            // buatkan record baru untuk table cart
            $inputancart['user_id'] = $itemuser->id;
            $inputancart['no_invoice'] = 'INV ' . str_pad(($no_invoice + 1), 3, '0', STR_PAD_LEFT);
            $inputancart['status_cart'] = 'aktif';
            $inputancart['status_pembayaran'] = 'belum';
            $inputancart['status_pengiriman'] = 'belum';
            $inputancart['subtotal'] = 0;
            $inputancart['ongkir'] = 0;
            $inputancart['diskon'] = 0;
            $inputancart['total'] = 0;
            $cart = Cart::create($inputancart);
        }

        // cek apakah produk sudah ada di cart detail
        $itemdetail = CartDetail::where('cart_id', $cart->id)
            ->where('produk_id', $itemproduk->id)
            ->first();

        $qty = $request->qty ? $request->qty : 1;
        $harga = $itemproduk->harga;
        // cek promo
        $itempromo = ProdukPromo::where('produk_id', $itemproduk->id)->first();
        $diskon = 0;
        if ($itempromo) {
            $harga = $itempromo->harga_awal;
            $diskon = $itempromo->diskon_nominal;
        }

        if ($itemdetail) {
            // update detail
            $itemdetail->updatedetail($itemdetail, $qty, $harga, $diskon);
        } else {
            // buat detail baru
            $inputandetail['cart_id'] = $cart->id;
            $inputandetail['produk_id'] = $itemproduk->id;
            $inputandetail['qty'] = $qty;
            $inputandetail['harga'] = $harga;
            $inputandetail['diskon'] = $diskon;
            $inputandetail['subtotal'] = ($harga - $diskon) * $qty;
            CartDetail::create($inputandetail);
        }

        // update total di cart
        $cart->updatetotal($cart, ($harga - $diskon) * $qty);

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $itemdetail = CartDetail::findOrFail($id);
        $itemcart = Cart::findOrFail($itemdetail->cart_id);
        $param = $request->param; // tambah atau kurang

        if ($param == 'tambah') {
            $qty = 1;
            $itemdetail->updatedetail($itemdetail, $qty, $itemdetail->harga, $itemdetail->diskon);
            $itemcart->updatetotal($itemcart, ($itemdetail->harga - $itemdetail->diskon) * $qty);
            return redirect()->back()->with('success', 'Item berhasil ditambah');
        }

        if ($param == 'kurang') {
            $qty = 1;
            // cek qty minimal 1
            if ($itemdetail->qty > 1) {
                $itemdetail->updatedetail($itemdetail, -($qty), $itemdetail->harga, $itemdetail->diskon);
                $itemcart->updatetotal($itemcart, -(($itemdetail->harga - $itemdetail->diskon) * $qty));
                return redirect()->back()->with('success', 'Item berhasil dikurangi');
            }
            return redirect()->back()->with('error', 'Item minimal 1');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $itemdetail = CartDetail::findOrFail($id);
        $itemcart = Cart::findOrFail($itemdetail->cart_id);

        // update total di cart dulu
        $itemcart->updatetotal($itemcart, -($itemdetail->subtotal));

        $itemdetail->delete();

        return redirect()->back()->with('success', 'Item berhasil dihapus');
    }
}
