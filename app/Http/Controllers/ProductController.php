<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil token JWT dari session
        $token = $request->session()->get('jwt_token');

        // Memeriksa apakah token JWT ada
        if (!$token) {
            return redirect('login')->with('danger', 'Anda harus login terlebih dahulu kedalam sistem!');
        }

        try {
            // Memverifikasi token JWT
            $user = Auth::user();

            if (!$user) {
                throw new \Exception('User tidak ditemukan');
            }

            if ($request->search) {
                $search = $request->search;
                $products = Product::where('name', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . ucfirst($search) . '%')
                    ->orWhere('buy_price', 'like', '%' . $search . '%')
                    ->orWhere('sell_price', 'like', '%' . $search . '%')
                    ->orWhere('stock', 'like', '%' . $search . '%')
                    ->paginate(10);
                $filter = null;
            } elseif ($request->filter) {
                $filter = $request->filter;
                $products = Product::where('category_id', $filter)
                    ->paginate(10);
                $search = null;
            } else {
                $products = Product::orderByDesc('id')->paginate(10);
                $search = null;
                $filter = null;
            }

            $categories = Category::all();

            return view('product.index', compact('products', 'categories', 'search', 'filter'));
        } catch (\Exception $e) {
            // Tangani kesalahan saat memverifikasi token JWT
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function exportToExcel(Request $request)
    {
        if ($request->filter !== null) {
            $products = Product::select('products.id', 'products.name', 'categories.name as category_name', 'products.buy_price', 'products.sell_price', 'products.stock')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->where('products.name', 'like', '%' . $request->filter . '%')
                ->orWhere('products.name', 'like', '%' . ucfirst($request->filter) . '%')
                ->orWhere('products.buy_price', 'like', '%' . $request->filter . '%')
                ->orWhere('products.sell_price', 'like', '%' . $request->filter . '%')
                ->orWhere('products.stock', 'like', '%' . $request->filter . '%')
                ->get();
        } else {
            $products = Product::select('products.id', 'products.name', 'categories.name as category_name', 'products.buy_price', 'products.sell_price', 'products.stock')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->get();
        }

        return Excel::download(new ProductsExport($products), 'products.xlsx');
    }

    public function create()
    {
        $categories = Category::all();

        return view('product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'category' => 'required',
            'name' => 'required|unique:products',
            'buy_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'required|image|mimes:jpg,png|max:100',
        ], [
            'category.required' => 'Kategori harus diisi.',
            'name.required' => 'Nama harus diisi.',
            'name.unique' => 'Nama sudah digunakan.',
            'buy_price.required' => 'Harga beli harus diisi.',
            'buy_price.numeric' => 'Harga beli harus berupa angka.',
            'sell_price.required' => 'Harga jual harus diisi.',
            'sell_price.numeric' => 'Harga jual harus berupa angka.',
            'stock.required' => 'Stok harus diisi.',
            'stock.numeric' => 'Stok harus berupa angka.',
            'image.required' => 'Gambar harus diunggah.',
            'image.image' => 'Berkas harus berupa gambar.',
            'image.mimes' => 'Format file harus jpg atau png.',
            'image.max' => 'Ukuran file tidak boleh lebih dari 100 KB.',
        ]);

        // Simpan gambar ke dalam direktori local
        // $image = $request->file('image');
        // $imagePath = $request->file('image')->move('product_images', rand(0, 99999999999) . '_' . str_replace(' ', '_', $image->getClientOriginalName()));

        // Simpan gambar ke cloudinary
        $imagePath = Cloudinary::upload($request->file('image')->getRealPath());

        // Buat instansiasi model untuk disimpan ke database
        $product = new Product();
        $product->category_id = $request->category;
        $product->name = $request->name;
        $product->buy_price = $request->buy_price;
        $product->sell_price = $request->sell_price;
        $product->stock = $request->stock;
        $product->image_path = $imagePath->getSecurePath();
        $product->image_public_id = $imagePath->getPublicId();

        // Simpan data ke database
        $product->save();

        // Redirect ke halaman lain atau tampilkan pesan sukses
        return redirect('/products')->with('success', 'Data produk berhasil disimpan.');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'category' => 'required',
            'name' => 'required',
            'buy_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'image|mimes:jpg,png|max:100',
        ]);

        $product = Product::findOrFail($id);

        $product->category_id = $request->category;
        $product->name = $request->name;
        $product->buy_price = $request->buy_price;
        $product->sell_price = $request->sell_price;
        $product->stock = $request->stock;

        // Check if image is uploaded
        if ($request->hasFile('image')) {
            $validatedData = $request->validate([
                'image' => 'required|image|mimes:jpg,png|max:100',
            ]);

            // Delete old image from local server
            // if (file_exists($product->image_path)) {
            //     unlink($product->image_path);
            // }

            if ($product->image_path !== null) {
                $response = Cloudinary::destroy($product->image_public_id);
            }

            // Save new image to local server
            // $imagePath = $request->file('image')->move('product_images', rand(0, 99999999999) . '_' . str_replace(' ', '_', $image->getClientOriginalName()));

            // Simpan gambar ke cloudinary
            $imagePath = Cloudinary::upload($request->file('image')->getRealPath());
            $product->image_path = $imagePath->getSecurePath();
            $product->image_public_id = $imagePath->getPublicId();
        }

        $product->update();

        return redirect('/products')->with('success', 'Data produk berhasil disimpan.');
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus file dari cloudinary
        if ($product->image_path !== null) {
            $response = Cloudinary::destroy($product->image_public_id);
        }

        // Hapus produk dari database
        $product->delete();

        return redirect('/products')->with('success', 'Data produk berhasil dihapus.');
    }
}
