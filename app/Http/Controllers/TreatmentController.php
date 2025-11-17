<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    public function index()
    {
        $treatments = Treatment::orderBy('name')->paginate(15);

        return view('treatments.index', compact('treatments'));
    }

    public function create()
    {
        return view('treatments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price'       => ['nullable', 'integer', 'min:0'],
        ]);

        Treatment::create($data);

        return redirect()
            ->route('treatments.index')
            ->with('success', 'Data treatment berhasil ditambahkan.');
    }

    public function edit(Treatment $treatment)
    {
        return view('treatments.edit', compact('treatment'));
    }

    public function update(Request $request, Treatment $treatment)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price'       => ['nullable', 'integer', 'min:0'],
        ]);

        $treatment->update($data);

        return redirect()
            ->route('treatments.index')
            ->with('success', 'Data treatment berhasil diperbarui.');
    }

    public function destroy(Treatment $treatment)
    {
        $treatment->delete();

        return redirect()
            ->route('treatments.index')
            ->with('success', 'Data treatment berhasil dihapus.');
    }
}
