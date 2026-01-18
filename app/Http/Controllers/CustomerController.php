<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        if ($keyword) {
            $itemcustomer = \App\Models\User::where('role', 'customer')
                ->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%$keyword%")
                        ->orWhere('email', 'LIKE', "%$keyword%");
                })
                ->paginate(20);
        } else {
            $itemcustomer = \App\Models\User::where('role', 'customer')->paginate(20);
        }

        $data = array(
            'title' => 'Data Customer',
            'itemcustomer' => $itemcustomer
        );
        return view('customer.index', $data)->with('no', ($request->input('page', 1) - 1) * 20);
    }

    public function edit($id)
    {
        $itemcustomer = \App\Models\User::where('role', 'customer')->findOrFail($id);
        $data = array(
            'title' => 'Form Edit Customer',
            'itemcustomer' => $itemcustomer
        );
        return view('customer.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'alamat' => 'nullable',
            'status' => 'required',
        ]);

        $itemcustomer = \App\Models\User::where('role', 'customer')->findOrFail($id);
        $inputan = $request->all();
        $itemcustomer->update($inputan);

        return redirect()->route('customer.index')->with('success', 'Data berhasil diupdate');
    }
}
