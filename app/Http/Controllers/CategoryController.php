<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'category_type' => 'required|in:Income,Expense,Transfer',
        ]);

        // Simpan kategori menggunakan mass assignment
        Category::create([
            'category_name' => $validated['category_name'],
            'category_type' => $validated['category_type'],
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('pages.budgets.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
