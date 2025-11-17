<?php


namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PetController extends Controller
{
    public function index(Request $request)
    {
        $owners = Owner::orderBy('name')->get();

        $pets = Pet::with('owner')
            ->when($request->owner_id, function ($q, $ownerId) {
                $q->where('owner_id', $ownerId);
            })
            ->orderBy('name')
            ->paginate(15);

        return view('pets.index', compact('pets', 'owners'));
    }

    public function create()
    {
        // hanya owner yang sudah verifikasi yang bisa dipilih
        $owners = Owner::verified()
            ->orderBy('name')
            ->get();

        return view('pets.create', compact('owners'));
    }

    public function store(Request $request)
    {
        // 1. Validasi dasar
        $request->validate([
            'owner_id'  => ['required', 'exists:owners,id'],
            'pet_input' => ['required', 'string'], // misal: "Milo Kucing 2Th 4.5kg"
        ], [
            // Custom error messages
            'owner_id.required' => 'Pemilik hewan wajib dipilih.',
            'owner_id.exists'   => 'Pemilik yang dipilih tidak valid.',

            'pet_input.required' => 'Data hewan wajib diisi.',
            'pet_input.string'   => 'Data hewan harus berupa text.',
        ]);

        $ownerId  = (int) $request->input('owner_id');
        $rawInput = $request->input('pet_input');

        // 2. Pastikan owner sudah verifikasi
        $owner = Owner::where('id', $ownerId)
            ->where('is_phone_verified', true)
            ->first();

        if (! $owner) {
            return back()
                ->withErrors(['owner_id' => 'Pemilik belum terverifikasi, tidak bisa didaftarkan hewan.'])
                ->withInput();
        }

        // 3. Normalisasi spasi berlebih
        $normalized = preg_replace('/\s+/', ' ', trim($rawInput));

        // Pecah jadi 4 bagian: NAMA JENIS USIA BERAT
        $parts = explode(' ', $normalized, 4);

        if (count($parts) !== 4) {
            return back()
                ->withErrors(['pet_input' => 'Format input hewan harus: NAMA JENIS USIA BERAT (contoh: "Milo Kucing 2Th 4.5kg").'])
                ->withInput();
        }

        [$namePart, $typePart, $agePart, $weightPart] = $parts;

        // 4. UPPERCASE nama & jenis
        $name = Str::upper($namePart);
        $type = Str::upper($typePart);

        // 5. Parsing usia (2tahun, 2Thn, 2TH, 2th, dst → ambil angkanya)
        if (! preg_match('/(\d+)/', $agePart, $matchAge)) {
            return back()
                ->withErrors(['pet_input' => 'Format usia tidak valid, tidak ditemukan angka usia. Gunakan format seperti: 2th, 2thn, 2tahun.'])
                ->withInput();
        }
        $age = (int) $matchAge[1];

        // 6. Parsing berat yang lebih robust (4.5kg, 4,5kg, 4.5 KG, dst)
        $w = preg_replace('/\s+/', '', $weightPart); // hapus semua spasi
        $w = preg_replace('/kg$/i', '', $w); // hapus 'kg' atau 'KG' di akhir
        $w = str_replace(',', '.', $w); // koma ke titik

        if (!preg_match('/^\d+(\.\d+)?$/', $w)) {
            return back()
                ->withErrors(['pet_input' => 'Format berat tidak valid. Gunakan angka dengan satuan kg (contoh: 4.5kg, 4,5kg, 4.5 KG).'])
                ->withInput();
        }
        $weight = (float) $w;

        // 7. Cek duplikasi hewan (owner_id + name + type)
        $duplicate = Pet::where('owner_id', $ownerId)
            ->where('name', $name)
            ->where('type', $type)
            ->exists();

        if ($duplicate) {
            return back()
                ->withErrors(['pet_input' => 'Pemilik ini sudah memiliki hewan dengan nama & jenis yang sama. Silakan gunakan nama atau jenis yang berbeda.'])
                ->withInput();
        }

        // 8. Generate kode hewan: HHMMXXXXYYYY dengan validasi unik
        $HHMM = Carbon::now()->format('Hi'); // jam & menit
        $XXXX = str_pad($ownerId, 4, '0', STR_PAD_LEFT);

        $countPets = Pet::where('owner_id', $ownerId)->count();
        $sequence  = $countPets + 1;

        // Pastikan kode unik
        do {
            $YYYY = str_pad($sequence, 4, '0', STR_PAD_LEFT);
            $code = $HHMM . $XXXX . $YYYY;
            $codeExists = Pet::where('code', $code)->exists();

            if ($codeExists) {
                $sequence++;
            }
        } while ($codeExists);

        // 9. Simpan
        $pet = Pet::create([
            'owner_id'  => $ownerId,
            'code'      => $code,
            'name'      => $name,
            'type'      => $type,
            'age'       => $age,
            'weight'    => $weight,
            'raw_input' => $rawInput,
        ]);

        return redirect()
            ->route('pets.index')
            ->with('success', 'Data hewan berhasil disimpan dengan kode: ' . $pet->code);
    }

    public function edit(Pet $pet)
    {
        $owners = Owner::verified()
            ->orderBy('name')
            ->get();

        return view('pets.edit', compact('pet', 'owners'));
    }

    public function update(Request $request, Pet $pet)
    {
        $data = $request->validate([
            'owner_id' => ['required', 'exists:owners,id'],
            'name'     => ['required', 'string', 'max:255'],
            'type'     => ['required', 'string', 'max:255'],
            'age'      => ['nullable', 'integer', 'min:0'],
            'weight'   => ['nullable', 'numeric', 'min:0'],
        ], [
            // Custom error messages for update
            'owner_id.required' => 'Pemilik hewan wajib dipilih.',
            'owner_id.exists'   => 'Pemilik yang dipilih tidak valid.',

            'name.required'     => 'Nama hewan wajib diisi.',
            'name.string'       => 'Nama hewan harus berupa text.',
            'name.max'          => 'Nama hewan maksimal 255 karakter.',

            'type.required'     => 'Jenis hewan wajib diisi.',
            'type.string'       => 'Jenis hewan harus berupa text.',
            'type.max'          => 'Jenis hewan maksimal 255 karakter.',

            'age.integer'       => 'Usia hewan harus berupa angka.',
            'age.min'           => 'Usia hewan tidak boleh negatif.',

            'weight.numeric'    => 'Berat hewan harus berupa angka.',
            'weight.min'        => 'Berat hewan tidak boleh negatif.',
        ]);

        // Pastikan owner terverifikasi
        $owner = Owner::where('id', $data['owner_id'])
            ->where('is_phone_verified', true)
            ->first();

        if (! $owner) {
            return back()
                ->withErrors(['owner_id' => 'Pemilik belum terverifikasi, tidak bisa memiliki hewan.'])
                ->withInput();
        }

        $data['name'] = Str::upper($data['name']);
        $data['type'] = Str::upper($data['type']);

        // cek duplikasi kalau owner/nama/jenis berubah
        $isDuplicate = Pet::where('owner_id', $data['owner_id'])
            ->where('name', $data['name'])
            ->where('type', $data['type'])
            ->where('id', '!=', $pet->id)
            ->exists();

        if ($isDuplicate) {
            return back()
                ->withErrors(['name' => 'Pemilik ini sudah memiliki hewan dengan nama & jenis yang sama. Silakan gunakan nama atau jenis yang berbeda.'])
                ->withInput();
        }

        $pet->update($data);

        return redirect()
            ->route('pets.index')
            ->with('success', 'Data hewan berhasil diperbarui.');
    }

    public function destroy(Pet $pet)
    {
        $pet->delete();

        return redirect()
            ->route('pets.index')
            ->with('success', 'Data hewan berhasil dihapus.');
    }
}
