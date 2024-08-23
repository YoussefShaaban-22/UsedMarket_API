<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductAttribute;
use App\Models\ProductDiscount;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $Product = Product::all();
        return $Product;
    }
    public function productColor()
    {
        $ProductColor = ProductColor::all();
        return $ProductColor;
    }
    public function newProduct()
    {
        $products = Product::orderBy('created_at', 'desc')->take(10)->get();
        return $products;
    }
    public function getProductsByCategory($categoryId)
    {
        $categories = $this->getAllSubcategories($categoryId);
        $categoryIds = $categories->pluck('id')->toArray();
        $products = Product::whereIn('category_id', $categoryIds)->get();
        return response()->json($products);
    }
    public function getProductsBybrand($brandId)
    {
        $products = Product::where('brand_id', $brandId)->get();
        return response()->json($products);
    }
    private function getAllSubcategories($parentId)
    {
        $parentCategory = ProductCategory::find($parentId);
        $subcategories = ProductCategory::where('parent_id', $parentId)->get();
        $allSubcategories = collect([$parentCategory]);
        $allSubcategories = $allSubcategories->merge($subcategories);
        foreach ($subcategories as $subcategory) {
            $allSubcategories = $allSubcategories->merge($this->getAllSubcategories($subcategory->id));
        }

        return $allSubcategories;
    }

    public function filter(Request $request, $categoryId)
    {
        $categories = $this->getAllSubcategories($categoryId);
        $categoryIds = $categories->pluck('id')->toArray();
        $query = Product::whereIn('category_id', $categoryIds);
        $brands = $request->input('brands', []);
        if (!empty($brands)) {
            $query->whereIn('brand_id', $brands);
        }
        $colors = $request->input('colors', []);
        if (!empty($colors)) {
            $query->whereIn('id', function ($subQuery) use ($colors) {
                $subQuery->select('product_id')
                    ->from('productcolor')
                    ->whereIn('color_id', $colors);
            });
        }
        $startPrice = $request->input('start_price', 0);
        $endPrice = $request->input('end_price', PHP_INT_MAX);
        $query->whereBetween('price', [$startPrice, $endPrice]);
        $products = $query->get();

        return response()->json($products);
    }
    public function filterofBrand(Request $request, $brandId)
    {
        $query = Product::where('brand_id', $brandId);
        $colors = $request->input('colors', []);
        if (!empty($colors)) {
            $query->whereIn('id', function ($subQuery) use ($colors) {
                $subQuery->select('product_id')
                    ->from('productcolor')
                    ->whereIn('color_id', $colors);
            });
        }
        $startPrice = $request->input('start_price', 0);
        $endPrice = $request->input('end_price', PHP_INT_MAX);
        $query->whereBetween('price', [$startPrice, $endPrice]);
        $products = $query->get();

        return response()->json($products);
    }
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'files.*' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $filePaths = [];
        $filePath = 'uploads/';

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path($filePath), $fileName);
                $filePaths[] = asset($filePath . $fileName);
            }
        }

        return response()->json(['paths' => $filePaths]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => 'required|string',
            "user_id" => 'required',
            "category_id" => 'required',
            "brand_id" => 'required',
            "thumbnail_image" => 'required',
            "image" => 'required|array',
            "image.*" => 'string',
            "tags" => 'required|array',
            "tags.*" => 'string',
            "short_description" => 'required',
            "description" => 'required',
            "price" => 'required',
            "quantity" => 'required',
            "status" => 'required',
            "feature_product" => 'required',
            "slug" => 'required',
            "colors" => 'required|array',
            "colors.*" => 'integer',
            "product_attributes" => 'required|array',
            "product_attributes.*.attribute_name" => 'required|string',
            "product_attributes.*.attribute_value" => 'nullable|string',
            "product_discount" => 'nullable',
            "product_discount.*.quantity" => 'nullable',
            "product_discount.*.To_quantity" => 'nullable',
            "product_discount.*.discount" => 'nullable',
        ]);

        $Product = Product::create([
            "name" => $request->name,
            "user_id" => $request->user_id,
            "category_id" => $request->category_id,
            "brand_id" => $request->brand_id,
            "seller_id" => $request->seller_id,
            "thumbnail_image" => $request->thumbnail_image,
            "image" => $request->image,
            "tags" => $request->tags,
            "short_description" => $request->short_description,
            "description" => $request->description,
            "price" => $request->price,
            "quantity" => $request->quantity,
            "status" => $request->status,
            "feature_product" => $request->feature_product,
            "slug" => $request->slug,
        ]);

        $productColors = [];
        foreach ($request->colors as $color_id) {
            $productColors[] = ProductColor::create([
                'product_id' => $Product->id,
                'color_id' => $color_id,
            ]);
        }
        $productAttributes = [];
        foreach ($request->product_attributes as $attribute) {
            $productAttributes[] =  ProductAttribute::create([
                'product_id' => $Product->id,
                'attribute_name' => $attribute['attribute_name'],
                'attribute_value' => $attribute['attribute_value'],
            ]);
        }

        $productDiscount = [];
        if (!empty($request->product_discount)) {
            foreach ($request->product_discount as $discount) {
                if (!is_null($discount['quantity']) && !is_null($discount['discount'])&& !is_null($discount['To_quantity'])) {
                    $productDiscount[] = ProductDiscount::create([
                        'product_id' => $Product->id,
                        'quantity' => $discount['quantity'],
                        'To_quantity' => $discount['To_quantity'],
                        'discount' => $discount['discount'],
                    ]);
                }
            }
        }

        $response = [
            "Product" => $Product,
            "Productcolor" => $productColors,
            "ProductAttributes" => $productAttributes,
            "productDiscount" => $productDiscount,
            "message" => "Product added successfully.",
        ];
        return response($response, 201);
    }

    public function show($slug)
    {
        $Product = Product::where('slug', $slug)->first();
        $product_id = $Product->id;
        $Product_color = ProductColor::where('product_id', $product_id)->get();
        $Product_attribute = ProductAttribute::where('product_id', $product_id)->get();
        $Product_discount = ProductDiscount::where('product_id', $product_id)->get();
        $response = [
            'Product' => $Product,
            'Product_color' => $Product_color,
            'Product_attribute' => $Product_attribute,
            'Product_discount' => $Product_discount,
        ];

        return response($response, 200);
    }

    public function showByID($id)
    {
        $Product = Product::find($id);
        return $Product;
    }

    public function showProductcolor($id)
    {
        $Product_color = ProductColor::where('product_id', $id)->get();
        return $Product_color;
    }

    public function showProductattribute($id)
    {
        $Product_attribute = ProductAttribute::where('product_id', $id)->get();
        return $Product_attribute;
    }

    public function showProductdiscount($id)
    {
        $Product_discount = ProductDiscount::where('product_id', $id)->get();
        return $Product_discount;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => 'required|string',
            "user_id" => 'required',
            "category_id" => 'required',
            "brand_id" => 'required',
            "thumbnail_image" => 'required',
            "image" => 'required|array',
            "image.*" => 'string',
            "tags" => 'required|array',
            "tags.*" => 'string',
            "short_description" => 'required',
            "description" => 'required',
            "price" => 'required',
            "quantity" => 'required',
            "status" => 'required',
            "feature_product" => 'required',
            "slug" => 'required',
            "colors" => 'required|array',
            "colors.*" => 'integer',
            "product_attributes" => 'array',
            "product_attributes.*.attribute_name" => 'required|string',
            "product_attributes.*.attribute_value" => 'nullable|string',
            "product_discount" => 'nullable',
            "product_discount.*.quantity" => 'nullable',
            "product_discount.*.To_quantity" => 'nullable',
            "product_discount.*.discount" => 'nullable',
        ]);
        $Product = Product::find($id);
        $Product->update([
            "name" => $request->name,
            "user_id" => $request->user_id,
            "category_id" => $request->category_id,
            "brand_id" => $request->brand_id,
            "thumbnail_image" => $request->thumbnail_image,
            "image" => $request->image,
            "tags" => $request->tags,
            "short_description" => $request->short_description,
            "description" => $request->description,
            "price" => $request->price,
            "quantity" => $request->quantity,
            "status" => $request->status,
            "feature_product" => $request->feature_product,
            "slug" => $request->slug,
        ]);
        ProductColor::where('product_id', $id)->delete();
        ProductAttribute::where('product_id', $id)->delete();
        ProductDiscount::where('product_id', $id)->delete();

        foreach ($request->colors as $color_id) {
            ProductColor::create([
                'product_id' => $Product->id,
                'color_id' => $color_id,
            ]);
        }

        foreach ($request->product_attributes as $attribute) {
            ProductAttribute::create([
                'product_id' => $Product->id,
                'attribute_name' => $attribute['attribute_name'],
                'attribute_value' => $attribute['attribute_value'],
            ]);
        }

        if (!empty($request->product_discount)) {
            foreach ($request->product_discount as $discount) {
                if (!is_null($discount['quantity']) && !is_null($discount['discount'])&& !is_null($discount['To_quantity'])) {
                    ProductDiscount::create([
                        'product_id' => $Product->id,
                        'quantity' => $discount['quantity'],
                        'To_quantity' => $discount['To_quantity'],
                        'discount' => $discount['discount'],
                    ]);
                }
            }
        }

        $response = [
            "Product" => $Product,
            "message" => "Product updated successfully.",
        ];
        return response($response, 200);
    }

    public function destroy($id)
    {
        $Product = Product::find($id);
        $Product->delete();
        $response = [
            "message" => "Product deleted successfully.",
        ];
        return response($response, 201);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $products = Product::where('name', 'LIKE', '%' . $searchTerm . '%')->get();

        return $products;
    }


    public function searchfilter(Request $request)
    {
        $searchTerm = $request->input('search', '');
        $query = Product::where('name', 'LIKE', '%' . $searchTerm . '%');

        $brands = $request->input('brands', []);
        if (!empty($brands)) {
            $query->whereIn('brand_id', $brands);
        }
        $colors = $request->input('colors', []);
        if (!empty($colors)) {
            $query->whereIn('id', function ($subQuery) use ($colors) {
                $subQuery->select('product_id')
                    ->from('productcolor')
                    ->whereIn('color_id', $colors);
            });
        }
        $startPrice = $request->input('start_price', 0);
        $endPrice = $request->input('end_price', PHP_INT_MAX);
        $query->whereBetween('price', [$startPrice, $endPrice]);
        $products = $query->get();

        return response()->json($products);
    }

    public function decreaseProductQuantity(Request $request)
    {
        $request->validate([
            'productId' => 'required|integer',
            'quantity' => 'required|integer',
        ]);

        $product = Product::find($request->productId);
        if ($product) {
            $product->quantity -= $request->quantity;
            $product->save();
            return response()->json(['message' => 'Product quantity updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }
}
