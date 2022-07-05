<?php

namespace App\Http\Controllers;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $hasil = Produk::latest()->paginate(10);
        return view('produk.index',compact('hasil'));
    }
    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_produk' => 'required',
            'keterangan' => 'required',
            'harga' => 'required',
            'jumlah' => 'required'
        ]);

        $produk = Produk::create([
            'nama_produk' => $request->nama_produk,
            'keterangan' => $request->keterangan,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah
        ]);
        
        if($produk){
            return redirect()->route('produk.index')->with(['success' => 'Data Berhasil Ditambahkan!']);
        }else {
            return redirect()->route('produk.index')->with(['gagal' => 'Data Gagal ditambahkan']);
        }
      
    }
    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $this->validate($request, [
            'nama_produk' => 'required',
            'keterangan' => 'required',
            'harga' => 'required',
            'jumlah' => 'required'
        ]);

        $produk = Produk::findOrFail($produk->id);

        $produk->update([
            'nama_produk'     => $request->nama_produk,
            'keterangan'   => $request->keterangan,
            'harga'   => $request->harga,
            'jumlah'   => $request->jumlah
        ]);
        if($produk){
            return redirect()->route('produk.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            return redirect()->route('produk.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    public function destroy($id)
    {
  $produk = Produk::findOrFail($id);
  $produk->delete();

  if($produk){
     //redirect dengan pesan sukses
     return redirect()->route('produk.index')->with(['success' => 'Data Berhasil Dihapus!']);
  }else{
    //redirect dengan pesan error
    return redirect()->route('produk.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }
}
