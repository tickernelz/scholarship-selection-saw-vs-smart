<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        // Get Data
        $data = Post::get();
        $judul = trans('auth.berita');

        return view('admin.berita.index', compact([
            'data',
            'judul'
        ]));
    }

    public function tambah_index()
    {
        $judul = trans('auth.tambah_berita');
        return view('admin.berita.tambah', compact([
            'judul'
        ]));
    }

    public function edit_index(int $id)
    {
        // Get Data
        $data = Post::find($id);
        $judul = trans('auth.edit_berita');

        return view('admin.berita.edit', compact([
            'data',
            'judul'
        ]));
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // Kirim Data ke Database
        $data = new Post();
        $data->title = $request->title;
        $data->slug = \Str::slug($request->title);
        $data->body = $request->body;
        $data->user_id = auth()->user()->id;
        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $request->file->move(public_path('files'), $fileName);
            $data->file = $fileName;
        }

        $simpan = $data->save();

        if ($simpan) {
            return back()->with('success', 'Data Berhasil Ditambahkan!');
        }

        return back()->with('error', 'Data Gagal Ditambahkan!');
    }

    public function edit(Request $request, int $id)
    {
        $data = Post::find($id);

        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // Kirim Data ke Database
        $data->title = $request->title;
        $data->slug = \Str::slug($request->title);
        $data->body = $request->body;
        $data->user_id = auth()->user()->id;
        // Cek apakah ada berkas?
        if ($request->hasFile('file')) {
            // Hapus Berkas Lama (Jika Ada)
            $namaberkas = $data->file;
            if (is_file(public_path('files') . '/' . $namaberkas)) {
                unlink(public_path('files') . '/' . $namaberkas);
            }
            // Upload File Baru
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $request->file->move(public_path('files'), $fileName);
            $data->file = $fileName;
        }
        $simpan = $data->save();

        if ($simpan) {
            return back()->with('success', 'Data Berhasil Ditambahkan!');
        }

        return back()->with('error', 'Data Gagal Ditambahkan!');
    }

    public function hapus(int $id)
    {
        $data = Post::find($id);
        $namaberkas = $data->file;

        // Hapus Berkas Lama (Jika Ada)
        if (is_file(public_path('files') . '/' . $namaberkas)) {
            unlink(public_path('files') . '/' . $namaberkas);
        }
        $data->delete();

        return back()
            ->with('success', 'Data Berhasil Dihapus!');
    }

    public function hapus_berkas(int $id)
    {
        $data = Post::find($id);
        $namaberkas = $data->file;

        // Hapus Berkas Lama ()
        unlink(public_path('files') . '/' . $namaberkas);
        $data->file = null;
        $data->save();

        return back()
            ->with('success', 'Berkas Berhasil Dihapus!');
    }
}
