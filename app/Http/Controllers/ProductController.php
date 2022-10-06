<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function index(Product $product)
    {
        return view('product.index', compact('product'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $productCategoryIds = array_keys($product->categories->groupBy('id')->all());
        return view('product.edit', compact('product', 'categories', 'productCategoryIds'));
    }

    public function update(Product $product)
    {
        $data = request()->validate(
            [
                'name' => ['required', 'string'],
                'price' => ['required', 'numeric'],
                'description' => ['required', 'string'],
                'image' => ['image'],
                'category' => ['required']
            ]);

        if (request('image')) {
            $data['image']  = $this->resizeImageAndGetPath();
        }

        $product->update($data);
        $this->resolveEditedCategories($product,
            array_map(function ($e) { return (int) $e; }, $data['category'])
        );

        return redirect("product/$product->id");
    }

    /**
     * TODO: refactor
     * @param Product $product
     * @param array $selectedCategories
     * @return void
     */
    private function resolveEditedCategories(Product $product, array $selectedCategories): void
    {
        $allCategoryIds = array_keys(Category::all()->groupBy('id')->all());
        $productCategories = array_keys($product->categories->groupBy('id')->all());

        $unselectedCategories = array_diff($allCategoryIds, $selectedCategories);

        $categoriesToAttach = array_diff($selectedCategories, $productCategories);
        $categoriesToDetach = array_intersect($unselectedCategories, $productCategories);

        if ($categoriesToAttach) {
            $product->categories()->attach($categoriesToAttach);
        }

        if ($categoriesToDetach) {
            $product->categories()->detach($categoriesToDetach);
        }
    }


    public function store()
    {
        $data = request()->validate(
          [
              'name' => ['required', 'string', 'unique:products'],
              'price' => ['required', 'numeric'],
              'description' => ['required', 'string'],
              'image' => ['required', 'image'],
              'category' => ['required']
          ]);

        $data['image'] = $this->resizeImageAndGetPath();

        $product = Product::create($data);
        $product->categories()->toggle($data['category']);

        return redirect("product/$product->id");
    }

    public function resizeImageAndGetPath()
    {
        $oldImage = request('image');
        $imagePath = $oldImage->store('product_images', 'public');

        $newImage = Image::make(public_path('storage/' . $imagePath))->fit(1200, 1200);
        $newImage->save();

        return $imagePath;
    }
}
