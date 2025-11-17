<?php

namespace App\Http\Controllers;

use App\Models\Checkup;
use App\Models\Pet;
use App\Models\Treatment;
use Illuminate\Http\Request;

class CheckupController extends Controller
{
    public function index(Request $request)
    {
        $pets = Pet::with('owner')->orderBy('name')->get();

        $checkups = Checkup::with(['pet.owner', 'treatment'])
            ->when($request->pet_id, function ($q, $petId) {
                $q->where('pet_id', $petId);
            })
            ->when($request->date_from, function ($q, $from) {
                $q->whereDate('checkup_date', '>=', $from);
            })
            ->when($request->date_to, function ($q, $to) {
                $q->whereDate('checkup_date', '<=', $to);
            })
            ->orderByDesc('checkup_date')
            ->paginate(20);

        return view('checkups.index', compact('checkups', 'pets'));
    }

    public function create()
    {
        $pets = Pet::with('owner')->orderBy('name')->get();
        $treatments = Treatment::orderBy('name')->get();

        return view('checkups.create', compact('pets', 'treatments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pet_id'        => ['required', 'exists:pets,id'],
            'treatment_id'  => ['required', 'exists:treatments,id'],
            'checkup_date'  => ['required', 'date'],
            'weight'        => ['nullable', 'numeric', 'min:0'],
            'notes'         => ['nullable', 'string'],
        ], [
            // Custom error messages
            'pet_id.required'        => 'Hewan wajib dipilih.',
            'pet_id.exists'          => 'Hewan yang dipilih tidak valid.',

            'treatment_id.required'  => 'Treatment wajib dipilih.',
            'treatment_id.exists'    => 'Treatment yang dipilih tidak valid.',

            'checkup_date.required'  => 'Tanggal pemeriksaan wajib diisi.',
            'checkup_date.date'      => 'Format tanggal pemeriksaan tidak valid.',

            'weight.numeric'         => 'Berat hewan harus berupa angka.',
            'weight.min'             => 'Berat hewan tidak boleh negatif.',

            'notes.string'           => 'Catatan harus berupa text.',
        ]);

        // Ambil data hewan untuk mendapatkan berat default
        $pet = Pet::findOrFail($data['pet_id']);

        // Jika weight tidak diisi, ambil dari data hewan
        $weightAtCheckup = $data['weight'] ?? $pet->weight;

        $checkup = Checkup::create([
            'pet_id'            => $data['pet_id'],
            'treatment_id'      => $data['treatment_id'],
            'checkup_date'      => $data['checkup_date'],
            'weight_at_checkup' => $weightAtCheckup,
            'notes'             => $data['notes'] ?? null,
        ]);

        // Jika berat diisi manual (berbeda dari berat default), update berat di tabel pets
        if (!empty($data['weight']) && $data['weight'] != $pet->weight) {
            $pet->update([
                'weight' => $data['weight'],
            ]);
        }

        return redirect()
            ->route('checkups.index')
            ->with('success', 'Data pemeriksaan berhasil disimpan.');
    }

    public function edit(Checkup $checkup)
    {
        $pets = Pet::with('owner')->orderBy('name')->get();
        $treatments = Treatment::orderBy('name')->get();

        return view('checkups.edit', compact('checkup', 'pets', 'treatments'));
    }

    public function update(Request $request, Checkup $checkup)
    {
        $data = $request->validate([
            'pet_id'        => ['required', 'exists:pets,id'],
            'treatment_id'  => ['required', 'exists:treatments,id'],
            'checkup_date'  => ['required', 'date'],
            'weight'        => ['nullable', 'numeric', 'min:0'],
            'notes'         => ['nullable', 'string'],
        ], [
            // Custom error messages
            'pet_id.required'        => 'Hewan wajib dipilih.',
            'pet_id.exists'          => 'Hewan yang dipilih tidak valid.',

            'treatment_id.required'  => 'Treatment wajib dipilih.',
            'treatment_id.exists'    => 'Treatment yang dipilih tidak valid.',

            'checkup_date.required'  => 'Tanggal pemeriksaan wajib diisi.',
            'checkup_date.date'      => 'Format tanggal pemeriksaan tidak valid.',

            'weight.numeric'         => 'Berat hewan harus berupa angka.',
            'weight.min'             => 'Berat hewan tidak boleh negatif.',

            'notes.string'           => 'Catatan harus berupa text.',
        ]);

        // Ambil data hewan untuk mendapatkan berat default
        $pet = Pet::findOrFail($data['pet_id']);

        // Jika weight tidak diisi, ambil dari data hewan
        $weightAtCheckup = $data['weight'] ?? $pet->weight;

        $checkup->update([
            'pet_id'            => $data['pet_id'],
            'treatment_id'      => $data['treatment_id'],
            'checkup_date'      => $data['checkup_date'],
            'weight_at_checkup' => $weightAtCheckup,
            'notes'             => $data['notes'] ?? null,
        ]);

        // Jika berat diisi manual (berbeda dari berat sebelumnya), update berat di tabel pets
        if (!empty($data['weight']) && $data['weight'] != $pet->weight) {
            $pet->update([
                'weight' => $data['weight'],
            ]);
        }

        return redirect()
            ->route('checkups.index')
            ->with('success', 'Data pemeriksaan berhasil diperbarui.');
    }

    public function destroy(Checkup $checkup)
    {
        $checkup->delete();

        return redirect()
            ->route('checkups.index')
            ->with('success', 'Data pemeriksaan berhasil dihapus.');
    }
}
