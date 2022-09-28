<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Subkriteria;
use Illuminate\Http\Request;
use Session;

class KriteriaController extends Controller
{
    public function index()
    {
        $judul = 'Kelola Kriteria';
        $data = Kriteria::all();
        return view('admin.kriteria.index', compact('data', 'judul'));
    }

    public function tambah_index(Request $request)
    {
        if ($request->session()->get('is_edit')) {
            $request->session()->forget('kriteria');
            $request->session()->forget('subkriteria');
        }
        $request->session()->put('is_tambah', true);
        $request->session()->put('is_edit', false);
        $judul = 'Tambah Kriteria';
        if (empty($request->session()->get('subkriteria'))) {
            $request->session()->put('subkriteria', []);
        }
        if (empty($request->session()->get('kriteria'))) {
            $request->session()->put('kriteria', []);
        }
        $kriteria = $request->session()->get('kriteria');
        $subkriteria = $request->session()->get('subkriteria');
        $tipe = ['benefit' => 'Benefit', 'cost' => 'Cost'];
        $selected = $kriteria['tipe_kriteria'] ?? 'benefit';
        return view('admin.kriteria.tambah', compact('judul', 'tipe', 'kriteria', 'subkriteria', 'selected'));
    }

    public function ajax_modal_subkriteria(Request $request)
    {
        $subkriteria = $request->session()->get('subkriteria');
        $subkriteria = collect($subkriteria)->where('id', $request->id)->first();
        return Response()->json($subkriteria);
    }

    public function edit_index(Request $request, int $id)
    {
        if ($request->session()->get('is_tambah')) {
            $request->session()->forget('kriteria');
            $request->session()->forget('subkriteria');
        }
        $request->session()->put('is_tambah', false);
        $request->session()->put('is_edit', true);
        $judul = 'Edit Kriteria';
        $data_kriteria = Kriteria::find($id);
        if ($request->session()->get('edit_id') != $id) {
            $request->session()->forget('kriteria');
            $request->session()->forget('subkriteria');
        }
        $data_subkriteria = Subkriteria::where('kriteria_id', $id)->get();
        $tipe = ['benefit' => 'Benefit', 'cost' => 'Cost'];

        # Session
        $request->session()->put('edit_id', $id);
        if (empty($request->session()->get('subkriteria'))) {
            $request->session()->put('subkriteria', []);
        }
        if (empty($request->session()->get('kriteria'))) {
            $request->session()->put('kriteria', []);
        }
        $session_kriteria = $request->session()->get('kriteria');
        $session_subkriteria = $request->session()->get('subkriteria');
        if (empty($session_kriteria)) {
            $session_kriteria = [
                'id' => $data_kriteria->id,
                'nama_kriteria' => $data_kriteria->nama,
                'tipe_kriteria' => $data_kriteria->tipe,
                'bobot_kriteria' => $data_kriteria->bobot,
            ];
            $request->session()->put('kriteria', $session_kriteria);
        }
        if (empty($session_subkriteria)) {
            foreach ($data_subkriteria as $key => $value) {
                $session_subkriteria[$key] = [
                    'id' => $value->id,
                    'nama_subkriteria' => $value->nama,
                    'prioritas_subkriteria' => $value->prioritas,
                ];
            }
            $request->session()->put('subkriteria', $session_subkriteria);
        }
        $kriteria = $request->session()->get('kriteria');
        $subkriteria = $request->session()->get('subkriteria');
        $selected = $kriteria['tipe_kriteria'] ?? 'benefit';
        return view('admin.kriteria.edit', compact('judul', 'tipe', 'kriteria', 'subkriteria', 'selected'));
    }

    public function tambah(Request $request)
    {
        switch ($request->input('action')) {
            case 'is_subkriteria':
                $request->validate([
                    'nama_subkriteria' => 'required',
                    'prioritas_subkriteria' => 'required|numeric',
                ]);
                $subkriteria = $request->session()->get('subkriteria');
                if ($subkriteria !== null) {
                    foreach ($subkriteria as $item) {
                        if ($item['prioritas_subkriteria'] === $request->input('prioritas_subkriteria')) {
                            return redirect()->back()->with('error', 'Prioritas subkriteria sudah ada');
                        }
                        if ($item['nama_subkriteria'] === $request->input('nama_subkriteria')) {
                            return redirect()->back()->with('error', 'Nama subkriteria sudah ada');
                        }
                    }
                }
                if ($request->prioritas_subkriteria === "0") {
                    return redirect()->back()->with('error', 'Prioritas subkriteria tidak boleh 0');
                }
                $subkriteria[] = [
                    'id' => count($subkriteria) + 1,
                    'nama_subkriteria' => $request->nama_subkriteria,
                    'prioritas_subkriteria' => $request->prioritas_subkriteria,
                ];
                $kriteria = $request->session()->get('kriteria');
                $kriteria['nama_kriteria'] = $request->nama_kriteria;
                $kriteria['tipe_kriteria'] = $request->tipe_kriteria;
                $kriteria['bobot_kriteria'] = $request->bobot_kriteria;
                $request->session()->put('subkriteria', $subkriteria);
                $request->session()->put('kriteria', $kriteria);
                if ($request->session()->get('is_edit') === true) {
                    return redirect()->route('get.admin.kriteria.edit', $request->session()->get('edit_id'))->with('success', 'Subkriteria berhasil diubah');
                }
                return redirect()->route('get.admin.kriteria.tambah')->with('success', 'Subkriteria berhasil ditambahkan');

            case 'edit_subkriteria':
                $request->validate([
                    'edit_nama_subkriteria' => 'required',
                    'edit_prioritas_subkriteria' => 'required|numeric',
                ]);
                $edit_id = (int)$request->edit_id;
                $subkriteria = $request->session()->get('subkriteria');
                if ($subkriteria !== null) {
                    foreach ($subkriteria as $index => $item) {
                        if ((int)$item['prioritas_subkriteria'] === (int)$request->edit_prioritas_subkriteria && (int)$item['id'] !== $edit_id) {
                            return redirect()->back()->with('error', 'Prioritas subkriteria sudah ada');
                        }
                        if ($item['nama_subkriteria'] === $request->edit_nama_subkriteria && (int)$item['id'] !== $edit_id) {
                            return redirect()->back()->with('error', 'Nama subkriteria sudah ada');
                        }
                        if ((int)$item['id'] === $edit_id) {
                            $item['nama_subkriteria'] = $request->edit_nama_subkriteria;
                            $item['prioritas_subkriteria'] = $request->edit_prioritas_subkriteria;
                            $subkriteria[$index] = $item;
                        }
                    }
                    Session::put('subkriteria', $subkriteria);
                }
                $kriteria = $request->session()->get('kriteria');
                $kriteria['nama_kriteria'] = $request->nama_kriteria;
                $kriteria['tipe_kriteria'] = $request->tipe_kriteria;
                $kriteria['bobot_kriteria'] = $request->bobot_kriteria;
                $request->session()->put('kriteria', $kriteria);
                if ($request->session()->get('is_edit') === true) {
                    return redirect()->route('get.admin.kriteria.edit', $request->session()->get('edit_id'))->with('success', 'Subkriteria berhasil diubah');
                }
                return redirect()->route('get.admin.kriteria.tambah')->with('success', 'Subkriteria berhasil diubah');

            case 'save':
                $request->validate([
                    'nama_kriteria' => 'required',
                    'tipe_kriteria' => 'required',
                    'bobot_kriteria' => 'required|numeric',
                ]);
                $data_kriteria = Kriteria::all();
                $total_bobot = $data_kriteria->sum('bobot');
                $kriteria = $request->session()->get('kriteria');
                $kriteria['nama_kriteria'] = $request->nama_kriteria;
                $kriteria['tipe_kriteria'] = $request->tipe_kriteria;
                $kriteria['bobot_kriteria'] = $request->bobot_kriteria;
                if ($total_bobot + $kriteria['bobot_kriteria'] > 100) {
                    return redirect()->back()->with('error', 'Total bobot kriteria tidak boleh lebih dari 100');
                }
                $request->session()->put('kriteria', $kriteria);
                $subkriteria = $request->session()->get('subkriteria');
                if (count($subkriteria) === 0) {
                    return redirect()->back()->with('error', 'Subkriteria tidak boleh kosong');
                }
                $kriteria = Kriteria::create([
                    'nama' => $kriteria['nama_kriteria'],
                    'tipe' => $kriteria['tipe_kriteria'],
                    'bobot' => $kriteria['bobot_kriteria'],
                ]);
                foreach ($subkriteria as $item) {
                    Subkriteria::create([
                        'kriteria_id' => $kriteria->id,
                        'nama' => $item['nama_subkriteria'],
                        'prioritas' => $item['prioritas_subkriteria'],
                    ]);
                }
                $request->session()->forget('subkriteria');
                $request->session()->forget('kriteria');
                return redirect()->route('get.admin.kriteria.tambah')->with('success', 'Kriteria berhasil ditambahkan');

            case 'save_edit':
                $request->validate([
                    'nama_kriteria' => 'required',
                    'tipe_kriteria' => 'required',
                    'bobot_kriteria' => 'required|numeric',
                ]);
                $data_kriteria = Kriteria::all();
                $total_bobot = $data_kriteria->sum('bobot');
                if ($total_bobot + $request->bobot_kriteria - $request->session()->get('kriteria')['bobot_kriteria'] > 100) {
                    return redirect()->back()->with('error', 'Total bobot kriteria tidak boleh lebih dari 100');
                }
                $subkriteria = $request->session()->get('subkriteria');
                if (count($subkriteria) === 0) {
                    return redirect()->back()->with('error', 'Subkriteria tidak boleh kosong');
                }
                $kriteria = Kriteria::find($request->id_kriteria);
                $kriteria->update([
                    'nama' => $request->nama_kriteria,
                    'tipe' => $request->tipe_kriteria,
                    'bobot' => $request->bobot_kriteria,
                ]);
                $kriteria->subkriteria()->delete();
                foreach ($subkriteria as $item) {
                    Subkriteria::create([
                        'kriteria_id' => $kriteria->id,
                        'nama' => $item['nama_subkriteria'],
                        'prioritas' => $item['prioritas_subkriteria'],
                    ]);
                }
                $request->session()->forget('subkriteria');
                $request->session()->forget('kriteria');
                return redirect()->route('get.admin.kriteria.edit', $request->id_kriteria)->with('success', 'Kriteria berhasil diubah');
        }
    }

    public function hapus_subkriteria(Request $request, int $id)
    {
        $subkriteria = $request->session()->get('subkriteria');
        if ($subkriteria !== null) {
            foreach ($subkriteria as $index => $item) {
                if ($item['id'] === $id) {
                    unset($subkriteria[$index]);
                }
            }
            Session::put('subkriteria', $subkriteria);
        }
        return redirect()->back()->with('success', 'Subkriteria berhasil dihapus');
    }

    public function hapus(int $id)
    {
        $kriteria = Kriteria::find($id);
        if ($kriteria !== null) {
            $kriteria->delete();
            return redirect()->back()->with('success', 'Kriteria berhasil dihapus');
        }
        return redirect()->back()->with('error', 'Kriteria tidak ditemukan');
    }
}
