<?php

namespace App\Http\Controllers;

use App\Models\HeroImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'images'   => ['required', 'array', 'min:1'],
            'images.*' => ['file', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:4096'],
        ], [
            'images.required' => 'Pilih minimal satu gambar.',
            'images.*.mimes'  => 'Format harus jpg, jpeg, png, webp, gif, atau svg.',
        ]);

        $last = HeroImage::where('user_id', auth()->id())->max('sort_order') ?? 0;

        foreach ($request->file('images') as $file) {
            $last++;
            HeroImage::create([
                'user_id'    => auth()->id(),
                'image'      => $file->store('hero', 'public'),
                'sort_order' => $last,
            ]);
        }

        return back()->with('success', 'Ilustrasi hero berhasil diunggah.');
    }

    public function destroy(HeroImage $heroImage)
    {
        abort_if($heroImage->user_id !== auth()->id(), 403);

        if ($heroImage->image) {
            Storage::disk('public')->delete($heroImage->image);
        }
        $heroImage->delete();

        return back()->with('success', 'Ilustrasi hero berhasil dihapus.');
    }
}
