<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::where('user_id', auth()->id())
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('content.menus.index', compact('menuItems'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['user_id'] = auth()->id();

        // Taruh di urutan paling akhir jika tidak diisi
        $data['sort_order'] = $data['sort_order']
            ?? ((int) MenuItem::where('user_id', auth()->id())->max('sort_order') + 1);

        MenuItem::create($data);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * Simpan semua perubahan menu sekaligus (satu tombol).
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'items'              => 'array',
            'items.*.label'      => 'required|string|max:100',
            'items.*.url'        => 'required|string|max:255',
            'items.*.sort_order' => 'nullable|integer|min:0',
        ]);

        // Baca dari raw input agar checkbox is_active ikut terbaca
        $items = $request->input('items', []);

        foreach ($items as $id => $fields) {
            $menu = MenuItem::where('id', $id)
                ->where('user_id', auth()->id())
                ->first();

            if (! $menu) {
                continue;
            }

            $menu->update([
                'label'      => $fields['label'],
                'url'        => $fields['url'],
                'sort_order' => $fields['sort_order'] ?? $menu->sort_order,
                'is_active'  => isset($fields['is_active']),
            ]);
        }

        return redirect()->route('menus.index')->with('success', 'Semua perubahan menu berhasil disimpan!');
    }

    public function destroy(MenuItem $menu)
    {
        abort_if($menu->user_id !== auth()->id(), 403);

        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus!');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'label'      => 'required|string|max:100',
            'url'        => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
