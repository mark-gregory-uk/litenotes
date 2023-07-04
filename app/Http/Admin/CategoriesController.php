<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Client\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('created_at')->paginate(10);

        return view('admin.categories.index', ['categories' => $categories]);
    }

    public function show(Request $request, $category)
    {
    }

    public function create(Request $request)
    {
    }

    public function update(Request $request, $category)
    {
    }

    public function destroy(Request $request, $category)
    {
    }
}
