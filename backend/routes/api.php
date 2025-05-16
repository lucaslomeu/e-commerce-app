<?php

use App\Http\Controllers\Api\ProductController;

Route::apiResource('products', ProductController::class);


// Se eu quiser definir cada rota manualmente, posso fazer assim:
// Route::get('/products', [ProductController::class, 'meuIndex']);
// Route::get('/products/{id}', [ProductController::class, 'visualizar']);
// Route::post('/products', [ProductController::class, 'criar']);
// Route::put('/products/{id}', [ProductController::class, 'atualizar']);
// Route::delete('/products/{id}', [ProductController::class, 'remover']);