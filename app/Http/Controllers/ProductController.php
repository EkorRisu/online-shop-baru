<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $category_id = $request->query('category_id');
        $search = $request->query('search');

        $products = Product::query()->with('category');

        if ($category_id) {
            $products->where('category_id', $category_id);
        }

        if ($search) {
            $products->where('name', 'LIKE', "%{$search}%");
        }

        $products = $products->get();

        return view('products.index', compact('categories', 'products', 'category_id', 'search'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image',
        ]);

        $data = $request->all();

        if (empty($data['category_id'])) {
            $defaultCategory = Category::firstOrCreate(
                ['name' => 'Default'],
                ['created_at' => now(), 'updated_at' => now()]
            );
            $data['category_id'] = $defaultCategory->id;
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);
        return redirect('/admin/products')->with('success', 'Product created');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image',
        ]);

        $data = $request->all();

        if (empty($data['category_id'])) {
            $defaultCategory = Category::firstOrCreate(
                ['name' => 'Default'],
                ['created_at' => now(), 'updated_at' => now()]
            );
            $data['category_id'] = $defaultCategory->id;
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return redirect('/admin/products')->with('success', 'Product updated');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('/admin/products')->with('success', 'Product deleted');
    }

    public function searchByCategory(Request $request)
    {
        $category_id = $request->query('category_id');
        $categories = Category::all();

        if ($category_id) {
            $products = Product::where('category_id', $category_id)->get();
        } else {
            $products = Product::all();
        }

        return view('products.search', compact('products', 'categories', 'category_id'));
    }
}
