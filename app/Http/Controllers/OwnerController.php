<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = Owner::orderBy('name')->paginate(15);

        return view('owners.index', compact('owners'));
    }

    public function create()
    {
        return view('owners.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'phone'             => ['required', 'string', 'max:50', 'unique:owners,phone'],
            'address'           => ['nullable', 'string'],
            'is_phone_verified' => ['nullable', 'boolean'],
        ], [
            // Custom error messages
            'name.required'        => 'Nama pemilik wajib diisi.',
            'name.string'          => 'Nama pemilik harus berupa text.',
            'name.max'             => 'Nama pemilik maksimal 255 karakter.',

            'phone.required'       => 'Nomor telepon wajib diisi.',
            'phone.string'         => 'Nomor telepon harus berupa text.',
            'phone.max'            => 'Nomor telepon maksimal 50 karakter.',
            'phone.unique'         => 'Nomor telepon sudah terdaftar. Gunakan nomor lain.',

            'address.string'       => 'Alamat harus berupa text.',
            'is_phone_verified.boolean' => 'Status verifikasi harus berupa true/false.',
        ]);

        $data['is_phone_verified'] = $request->boolean('is_phone_verified');
        $data['phone_verified_at'] = $data['is_phone_verified'] ? now() : null;

        Owner::create($data);

        return redirect()
            ->route('owners.index')
            ->with('success', 'Data pemilik berhasil ditambahkan.');
    }

    public function edit(Owner $owner)
    {
        return view('owners.edit', compact('owner'));
    }

    public function update(Request $request, Owner $owner)
    {
        $data = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'phone'             => ['required', 'string', 'max:50', 'unique:owners,phone,' . $owner->id],
            'address'           => ['nullable', 'string'],
            'is_phone_verified' => ['nullable', 'boolean'],
        ], [
            // Custom error messages
            'name.required'        => 'Nama pemilik wajib diisi.',
            'name.string'          => 'Nama pemilik harus berupa text.',
            'name.max'             => 'Nama pemilik maksimal 255 karakter.',

            'phone.required'       => 'Nomor telepon wajib diisi.',
            'phone.string'         => 'Nomor telepon harus berupa text.',
            'phone.max'            => 'Nomor telepon maksimal 50 karakter.',
            'phone.unique'         => 'Nomor telepon sudah digunakan pemilik lain.',

            'address.string'       => 'Alamat harus berupa text.',
            'is_phone_verified.boolean' => 'Status verifikasi harus berupa true/false.',
        ]);

        $data['is_phone_verified'] = $request->boolean('is_phone_verified');

        if ($data['is_phone_verified'] && ! $owner->phone_verified_at) {
            $data['phone_verified_at'] = now();
        } elseif (! $data['is_phone_verified']) {
            $data['phone_verified_at'] = null;
        }

        $owner->update($data);

        return redirect()
            ->route('owners.index')
            ->with('success', 'Data pemilik berhasil diperbarui.');
    }

    public function destroy(Owner $owner)
    {
        $owner->delete();

        return redirect()
            ->route('owners.index')
            ->with('success', 'Data pemilik berhasil dihapus.');
    }
}
