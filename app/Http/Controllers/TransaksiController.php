<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $itemuser = $request->user();
        if ($itemuser->role == 'admin') {
            $itemorder = \App\Models\Order::orderBy('created_at', 'desc')->paginate(20);
        } else {
            $itemorder = \App\Models\Order::where('user_id', $itemuser->id)->orderBy('created_at', 'desc')->paginate(20);
        }
        $data = array(
            'title' => 'Data Transaksi',
            'itemorder' => $itemorder
        );
        return view('transaksi.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'alamat_pengiriman_id' => 'required',
            'ekspedisi' => 'required',
        ]);

        $itemuser = $request->user();
        $itemcart = \App\Models\Cart::where('user_id', $itemuser->id)
            ->where('status_cart', 'aktif')
            ->first();

        if (!$itemcart || $itemcart->detail->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong');
        }

        // Simpan ke table orders
        $inputan['user_id'] = $itemuser->id;
        $inputan['alamat_pengiriman_id'] = $request->alamat_pengiriman_id;
        $inputan['no_invoice'] = $itemcart->no_invoice;
        $inputan['subtotal'] = $itemcart->subtotal;
        $inputan['diskon'] = $itemcart->diskon;
        $inputan['ongkir'] = $itemcart->ongkir;
        $inputan['total'] = $itemcart->total;
        $inputan['ekspedisi'] = $request->ekspedisi;
        $inputan['status_pembayaran'] = 'belum';
        $inputan['status'] = 'belum';

        $order = \App\Models\Order::create($inputan);

        // Simpan ke table order_details
        foreach ($itemcart->detail as $detail) {
            $inputandetail['order_id'] = $order->id;
            $inputandetail['produk_id'] = $detail->produk_id;
            $inputandetail['harga'] = $detail->harga;
            $inputandetail['diskon'] = $detail->diskon;
            $inputandetail['qty'] = $detail->qty;
            $inputandetail['subtotal'] = $detail->subtotal;
            \App\Models\OrderDetail::create($inputandetail);
        }

        // Update status cart
        $itemcart->update(['status_cart' => 'checkout']);

        return redirect()->route('transaksi.index')->with('success', 'Order berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = \App\Models\Order::findOrFail($id);
        $data = array(
            'title' => 'Detail Transaksi',
            'order' => $order
        );
        return view('transaksi.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = \App\Models\Order::findOrFail($id);
        $data = array(
            'title' => 'Form Edit Transaksi',
            'order' => $order
        );
        return view('transaksi.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = \App\Models\Order::findOrFail($id);
        $order->update($request->all());
        return back()->with('success', 'Data transaksi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
