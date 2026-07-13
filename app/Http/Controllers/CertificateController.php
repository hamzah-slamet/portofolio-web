<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::where('user_id', auth()->id())
            ->orderBy('sort_order')
            ->orderByDesc('year')
            ->get();

        return view('content.certificates.index', compact('certificates'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('certificates', 'public');
        }

        Certificate::create($data);

        return redirect()->route('certificates.index')->with('success', 'Sertifikat berhasil ditambahkan!');
    }

    public function update(Request $request, Certificate $certificate)
    {
        abort_if($certificate->user_id !== auth()->id(), 403);

        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            if ($certificate->image) {
                Storage::disk('public')->delete($certificate->image);
            }
            $data['image'] = $request->file('image')->store('certificates', 'public');
        }

        $certificate->update($data);

        return redirect()->route('certificates.index')->with('success', 'Sertifikat berhasil diperbarui!');
    }

    public function destroy(Certificate $certificate)
    {
        abort_if($certificate->user_id !== auth()->id(), 403);

        if ($certificate->image) {
            Storage::disk('public')->delete($certificate->image);
        }
        $certificate->delete();

        return redirect()->route('certificates.index')->with('success', 'Sertifikat berhasil dihapus!');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'title'      => 'required|string|max:255',
            'issuer'     => 'required|string|max:255',
            'year'       => 'required|string|max:20',
            'url'        => 'nullable|url|max:500',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
        ]);
    }
}
