<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ProductService;
use Illuminate\Support\Facades\Http;

class ImportProducts extends Command
{
    protected $signature = 'products:import {--id=}';
    protected $description = 'Importa produtos da Fake Store API';

    protected $productService;

    public function __construct(ProductService $productService)
    {
        parent::__construct();
        $this->productService = $productService;
    }

    public function handle()
    {
        $id = $this->option('id');
        $url = $id
            ? "https://fakestoreapi.com/products/{$id}"
            : "https://fakestoreapi.com/products";

        $this->info("Importando de $url");

        $response = Http::get($url);

        if (!$response->successful()) {
            $this->error('Falha ao buscar dados da Fake Store API');
            return 1;
        }

        $produtos = $id ? [$response->json()] : $response->json();

        foreach ($produtos as $item) {
            // Normaliza os dados para o formato do seu banco
            $dados = [
                'name' => $item['title'] ?? '',
                'price' => $item['price'] ?? 0,
                'description' => $item['description'] ?? '',
                'category' => $item['category'] ?? '',
                'image_url' => $item['image'] ?? null,
            ];

            // Ignora se faltar campos obrigatórios
            if (empty($dados['name']) || empty($dados['price']) || empty($dados['description']) || empty($dados['category'])) {
                $this->warn("Produto ignorado (campos obrigatórios faltando): " . json_encode($dados));
                continue;
            }

            // Usa ProductService para criar ou atualizar (baseado no name)
            // Dispara um Job para importar o produto
            dispatch(new \App\Jobs\ImportProductJob($dados));
            $this->info("Job disparado para: " . $dados['name']);
        }

        $this->info("Importação finalizada.");
        return 0;
    }
}
