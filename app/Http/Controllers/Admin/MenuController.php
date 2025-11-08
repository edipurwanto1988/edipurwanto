<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('order')->get();
        $pages = Page::where('status', 'published')->get();
        return view('admin.menus.index', compact('menus', 'pages'));
    }

    public function create()
    {
        $pages = Page::where('status', 'published')->get();
        return view('admin.menus.create', compact('pages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'page_id' => 'nullable|exists:pages,id',
            'target' => 'required|in:_blank,_self,_parent,_top',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Ensure either url or page_id is provided
        if (empty($validated['url']) && empty($validated['page_id'])) {
            return redirect()->back()
                ->with('error', 'Either URL or Page must be selected.')
                ->withInput();
        }

        // If page_id is selected, generate URL from page slug
        if (!empty($validated['page_id'])) {
            $page = Page::find($validated['page_id']);
            $validated['url'] = '/page/' . $page->slug;
        }

        // Generate slug from name
        $validated['slug'] = Str::slug($validated['name']);

        // Set default values
        $validated['id'] = Str::uuid()->toString();
        $validated['is_active'] = $request->has('is_active') ? true : false;

        Menu::create($validated);

        return redirect()->route('adminku.menus.index')
            ->with('success', 'Menu created successfully.');
    }

    public function edit(Menu $menu)
    {
        $pages = Page::where('status', 'published')->get();
        return view('admin.menus.edit', compact('menu', 'pages'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'page_id' => 'nullable|exists:pages,id',
            'target' => 'required|in:_blank,_self,_parent,_top',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Ensure either url or page_id is provided
        if (empty($validated['url']) && empty($validated['page_id'])) {
            return redirect()->back()
                ->with('error', 'Either URL or Page must be selected.')
                ->withInput();
        }

        // If page_id is selected, generate URL from page slug
        if (!empty($validated['page_id'])) {
            $page = Page::find($validated['page_id']);
            $validated['url'] = '/page/' . $page->slug;
        }

        // Generate slug from name if it changed
        if ($validated['name'] !== $menu->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Set default values
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $menu->update($validated);

        return redirect()->route('adminku.menus.index')
            ->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('adminku.menus.index')
            ->with('success', 'Menu deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $menuOrders = $request->input('menus', []);
        
        foreach ($menuOrders as $order => $menuId) {
            $menu = Menu::find($menuId);
            if ($menu) {
                $menu->update(['order' => $order]);
            }
        }

        return response()->json(['success' => true]);
    }
}