<?php

namespace App\Jobs;

use App\Services\ProductService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dados;

    public function __construct(array $dados)
    {
        $this->dados = $dados;
    }

    public function handle(ProductService $productService)
    {
        // Cria ou atualiza produto
        $product = $productService->showByName($this->dados['name']);
        if ($product) {
            $productService->update($product, $this->dados);
        } else {
            $productService->create($this->dados);
        }
    }
}