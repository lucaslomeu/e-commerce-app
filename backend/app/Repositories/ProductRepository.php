<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function all($filters = [])
    {
        $query = Product::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'ilike', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (isset($filters['has_image'])) {
            $filters['has_image']
                ? $query->whereNotNull('image_url')
                : $query->whereNull('image_url');
        }

        return $query->get();
    }

    public function find($id)
    {
        return Product::find($id);
    }

    public function findByName($name)
    {
        return Product::where('name', $name)->first();
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data)
    {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product)
    {
        return $product->delete();
    }
}
