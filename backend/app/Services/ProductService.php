<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Models\Product;

class ProductService
{
    protected $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list(array $filters = [])
    {
        return $this->repository->all($filters);
    }

    public function show($id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update(Product $product, array $data)
    {
        return $this->repository->update($product, $data);
    }

    public function delete(Product $product)
    {
        return $this->repository->delete($product);
    }
}
