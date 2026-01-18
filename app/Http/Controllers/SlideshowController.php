<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slideshow;
use Illuminate\Support\Facades\Storage;

class SlideshowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $itemslideshow = Slideshow::orderBy('created_at', 'desc')->paginate(20);
        $data = array(
            'title' => 'Data Slideshow',
            'itemslideshow' => $itemslideshow
        );
        return view('slideshow.index', $data)->with('no', ($request->input('page', 1) - 1) * 20);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = array('title' => 'Form Slideshow');
        return view('slideshow.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'caption_title' => 'required',
        ]);

        $itemuser = $request->user();
        $fileupload = $request->file('image');
        $path = $fileupload->store('assets/images', 'public');

        $inputan = $request->all();
        $inputan['user_id'] = $itemuser->id;
        $inputan['foto'] = $path;

        Slideshow::create($inputan);

        return redirect()->route('slideshow.index')->with('success', 'Slideshow berhasil ditambah');
    }

    public function edit($id)
    {
        $itemslideshow = Slideshow::findOrFail($id);
        $data = array(
            'title' => 'Form Edit Slideshow',
            'itemslideshow' => $itemslideshow
        );
        return view('slideshow.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'caption_title' => 'required',
        ]);

        $itemslideshow = Slideshow::findOrFail($id);
        $inputan = $request->all();

        if ($request->hasFile('image')) {
            $fileupload = $request->file('image');
            $path = $fileupload->store('assets/images', 'public');
            $inputan['foto'] = $path;

            // Delete old image
            Storage::disk('public')->delete($itemslideshow->foto);
        }

        $itemslideshow->update($inputan);

        return redirect()->route('slideshow.index')->with('success', 'Slideshow berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $itemslideshow = Slideshow::findOrFail($id);

        // Hapus file fisik dari storage
        Storage::disk('public')->delete($itemslideshow->foto);

        // Hapus data dari database
        if ($itemslideshow->delete()) {
            return back()->with('success', 'Data berhasil dihapus');
        } else {
            return back()->with('error', 'Data gagal dihapus');
        }
    }
}