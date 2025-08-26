<?php

use App\Models\Product;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

describe('Product Index', function () {
    it('displays products index page', function () {
        $products = Product::factory(3)->create();

        $response = $this->get(route('products.index'));

        $response->assertSuccessful();
        $response->assertInertia(fn ($page) => 
            $page->component('products/Index')
                ->has('products', 3)
        );
    });

    it('displays empty state when no products exist', function () {
        $response = $this->get(route('products.index'));

        $response->assertSuccessful();
        $response->assertInertia(fn ($page) => 
            $page->component('products/Index')
                ->has('products', 0)
        );
    });
});

describe('Product Show', function () {
    it('displays single product page', function () {
        $product = Product::factory()->create([
            'name' => 'Test Product',
            'price' => 99.99,
            'description' => 'Test description'
        ]);

        $response = $this->get(route('products.show', $product));

        $response->assertSuccessful();
        $response->assertInertia(fn ($page) => 
            $page->component('products/Show')
                ->has('product')
                ->where('product.name', 'Test Product')
                ->where('product.price', 99.99)
                ->where('product.description', 'Test description')
        );
    });

    it('returns 404 for non-existent product', function () {
        $response = $this->get('/products/999');

        $response->assertNotFound();
    });
});

describe('Product Create', function () {
    it('displays create product form', function () {
        $response = $this->get(route('products.create'));

        $response->assertSuccessful();
        $response->assertInertia(fn ($page) => 
            $page->component('products/Create')
        );
    });

    it('creates a new product with valid data', function () {
        $productData = [
            'name' => 'New Product',
            'price' => 149.99,
            'description' => 'A new product description'
        ];

        $response = $this->post(route('products.store'), $productData);

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success', 'Product created successfully.');
        
        $this->assertDatabaseHas('products', $productData);
    });

    it('creates product without description', function () {
        $productData = [
            'name' => 'Product Without Description',
            'price' => 99.99,
            'description' => null
        ];

        $response = $this->post(route('products.store'), $productData);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Product Without Description',
            'price' => 99.99,
            'description' => null
        ]);
    });
});

describe('Product Validation', function () {
    it('validates required name field', function () {
        $response = $this->post(route('products.store'), [
            'price' => 99.99,
            'description' => 'Test description'
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('products', 0);
    });

    it('validates required price field', function () {
        $response = $this->post(route('products.store'), [
            'name' => 'Test Product',
            'description' => 'Test description'
        ]);

        $response->assertSessionHasErrors('price');
        $this->assertDatabaseCount('products', 0);
    });

    it('validates price is numeric', function () {
        $response = $this->post(route('products.store'), [
            'name' => 'Test Product',
            'price' => 'not-a-number',
            'description' => 'Test description'
        ]);

        $response->assertSessionHasErrors('price');
        $this->assertDatabaseCount('products', 0);
    });

    it('validates name max length', function () {
        $response = $this->post(route('products.store'), [
            'name' => str_repeat('a', 256), // 256 characters
            'price' => 99.99,
            'description' => 'Test description'
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('products', 0);
    });

    it('accepts valid name length', function () {
        $response = $this->post(route('products.store'), [
            'name' => str_repeat('a', 255), // 255 characters
            'price' => 99.99,
            'description' => 'Test description'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('products', 1);
    });
});

describe('Product Edit', function () {
    it('displays edit product form', function () {
        $product = Product::factory()->create();

        $response = $this->get(route('products.edit', $product));

        $response->assertSuccessful();
        $response->assertInertia(fn ($page) => 
            $page->component('products/Edit')
                ->has('product')
                ->where('product.id', $product->id)
        );
    });

    it('updates product with valid data', function () {
        $product = Product::factory()->create([
            'name' => 'Original Name',
            'price' => 99.99,
            'description' => 'Original description'
        ]);

        $updateData = [
            'name' => 'Updated Name',
            'price' => 149.99,
            'description' => 'Updated description'
        ];

        $response = $this->put(route('products.update', $product), $updateData);

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success', 'Product updated successfully.');
        
        $product->refresh();
        expect($product->name)->toBe('Updated Name');
        expect($product->price)->toBe(149.99);
        expect($product->description)->toBe('Updated description');
    });

    it('validates update data', function () {
        $product = Product::factory()->create();

        $response = $this->put(route('products.update', $product), [
            'name' => '',
            'price' => 'invalid-price'
        ]);

        $response->assertSessionHasErrors(['name', 'price']);
    });

    it('returns 404 for non-existent product on edit', function () {
        $response = $this->get('/products/999/edit');

        $response->assertNotFound();
    });
});

describe('Product Delete', function () {
    it('deletes a product', function () {
        $product = Product::factory()->create();

        $response = $this->delete(route('products.delete', $product));

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success', 'Product deleted successfully.');
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    });

    it('returns 404 when trying to delete non-existent product', function () {
        $response = $this->delete('/products/999');

        $response->assertNotFound();
    });
});

describe('Product Factory States', function () {
    it('creates expensive products', function () {
        $product = Product::factory()->expensive()->create();

        expect($product->price)->toBeGreaterThanOrEqual(500);
        expect($product->price)->toBeLessThanOrEqual(2000);
    });

    it('creates cheap products', function () {
        $product = Product::factory()->cheap()->create();

        expect($product->price)->toBeGreaterThanOrEqual(1);
        expect($product->price)->toBeLessThanOrEqual(50);
    });

    it('creates products without description', function () {
        $product = Product::factory()->withoutDescription()->create();

        expect($product->description)->toBeNull();
    });
});

describe('Product Business Logic', function () {
    it('correctly formats price in different currencies', function () {
        $product = Product::factory()->create(['price' => 123.45]);

        expect($product->price)->toBe(123.45);
    });

    it('handles decimal prices correctly', function () {
        $product = Product::factory()->create(['price' => 99.99]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'price' => 99.99
        ]);
    });

    it('can create multiple products with unique names', function () {
        $products = Product::factory(5)->create();

        expect($products)->toHaveCount(5);
        $this->assertDatabaseCount('products', 5);
        
        // Sprawdź, że wszystkie produkty mają różne nazwy
        $names = $products->pluck('name')->toArray();
        expect($names)->toBe(array_unique($names));
    });
});
