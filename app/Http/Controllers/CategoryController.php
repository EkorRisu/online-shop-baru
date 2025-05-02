<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan halaman kategori dengan daftar kategori dan produk
    public function index(Request $request)
    {
        $categories = Category::all();
        $category_id = $request->query('category_id');
        $search = $request->query('search');

        $products = Product::query()->with('category'); // Eager load relasi category

        if ($category_id) {
            $products->where('category_id', $category_id);
        }

        if ($search) {
            $products->where('name', 'LIKE', "%{$search}%");
        }

        $products = $products->get();

        return view('categories.index', compact('categories', 'products', 'category_id', 'search'));
    }

    // Menampilkan form untuk membuat kategori baru (hanya admin)
    public function create()
    {
        return view('categories.create');
    }

    // Menyimpan kategori baru (hanya admin)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name',
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    // Menampilkan form untuk mengedit kategori (hanya admin)
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // Memperbarui kategori (hanya admin)
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id,
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    // Menghapus kategori (hanya admin)
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
