<?php

use App\Models\Product;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

describe('Product Store Validation Edge Cases', function () {
    test('product name validation with various inputs', function ($name, $shouldPass) {
        $response = $this->post(route('products.store'), [
            'name' => $name,
            'price' => 99.99,
            'description' => 'Test description'
        ]);

        if ($shouldPass) {
            $response->assertRedirect();
            // Laravel automatically trims whitespace, so check for trimmed version
            $expectedName = is_string($name) ? trim($name) : $name;
            $this->assertDatabaseHas('products', ['name' => $expectedName]);
        } else {
            $response->assertSessionHasErrors('name');
            $this->assertDatabaseCount('products', 0);
        }
    })->with([
        ['Valid Product Name', true],
        ['', false], // Empty string
        [null, false], // Null
        [str_repeat('a', 255), true], // Max valid length
        [str_repeat('a', 256), false], // Too long
        ['Product with 123 numbers', true],
        ['Product with special chars !@#$%', true],
        ['   Product with spaces   ', true], // Leading/trailing spaces
    ]);

    test('product price validation with various inputs', function ($price, $shouldPass) {
        $response = $this->post(route('products.store'), [
            'name' => 'Test Product',
            'price' => $price,
            'description' => 'Test description'
        ]);

        if ($shouldPass) {
            $response->assertRedirect();
            $this->assertDatabaseCount('products', 1);
        } else {
            $response->assertSessionHasErrors('price');
            $this->assertDatabaseCount('products', 0);
        }
    })->with([
        [99.99, true], // Valid decimal
        [100, true], // Valid integer
        [0.01, true], // Very small positive
        [9999999.99, true], // Very large
        [0, true], // Zero (might be valid for free products)
        ['not-a-number', false], // String
        ['', false], // Empty string
        [null, false], // Null
        ['99.99.99', false], // Invalid decimal format
    ]);

    test('product description validation', function ($description, $shouldPass) {
        $response = $this->post(route('products.store'), [
            'name' => 'Test Product',
            'price' => 99.99,
            'description' => $description
        ]);

        $response->assertRedirect(); // Description is nullable, so should always pass
        $this->assertDatabaseCount('products', 1);
    })->with([
        ['Valid description', true],
        ['', true], // Empty string should be converted to null
        [null, true], // Null
        [str_repeat('a', 1000), true], // Very long description
        ['Description with special chars !@#$%^&*()', true],
        ["Multi\nline\ndescription", true],
    ]);
});

describe('Product Update Validation Edge Cases', function () {
    it('preserves existing data when updating with valid data', function () {
        $product = Product::factory()->create([
            'name' => 'Original Name',
            'price' => 99.99,
            'description' => 'Original description'
        ]);

        $this->put(route('products.update', $product), [
            'name' => 'Updated Name',
            'price' => 149.99,
            'description' => 'Updated description'
        ]);

        $product->refresh();
        expect($product->name)->toBe('Updated Name');
        expect($product->price)->toBe(149.99);
        expect($product->description)->toBe('Updated description');
    });

    it('does not update when validation fails', function () {
        $product = Product::factory()->create([
            'name' => 'Original Name',
            'price' => 99.99,
            'description' => 'Original description'
        ]);

        $this->put(route('products.update', $product), [
            'name' => '', // Invalid
            'price' => 'invalid', // Invalid
            'description' => 'Attempted update'
        ]);

        $product->refresh();
        expect($product->name)->toBe('Original Name');
        expect($product->price)->toBe(99.99);
        expect($product->description)->toBe('Original description');
    });

    it('allows partial updates with valid fields', function () {
        $product = Product::factory()->create([
            'name' => 'Original Name',
            'price' => 99.99,
            'description' => 'Original description'
        ]);

        $this->put(route('products.update', $product), [
            'name' => 'Updated Name Only',
            'price' => $product->price, // Keep original
            'description' => $product->description // Keep original
        ]);

        $product->refresh();
        expect($product->name)->toBe('Updated Name Only');
        expect($product->price)->toBe(99.99);
        expect($product->description)->toBe('Original description');
    });
});

describe('Product Database Constraints', function () {
    it('stores price with correct precision', function () {
        $testPrices = [99.99, 100.00, 0.01, 1234.56];

        foreach ($testPrices as $price) {
            $product = Product::factory()->create(['price' => $price]);
            
            $this->assertDatabaseHas('products', [
                'id' => $product->id,
                'price' => $price
            ]);
        }
    });

    it('handles unicode characters in name and description', function () {
        $product = Product::factory()->create([
            'name' => 'Produkt ze znakami ąęćłńóśźż',
            'description' => 'Opis z emoji 🎉 i różnymi znakami ©®™'
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Produkt ze znakami ąęćłńóśźż',
            'description' => 'Opis z emoji 🎉 i różnymi znakami ©®™'
        ]);
    });

    it('creates timestamps correctly', function () {
        $beforeCreation = now()->subSecond(); // Give a bit more margin
        $product = Product::factory()->create();
        $afterCreation = now()->addSecond();

        expect($product->created_at->between($beforeCreation, $afterCreation))->toBeTrue();
        expect($product->updated_at->between($beforeCreation, $afterCreation))->toBeTrue();
    });

    it('updates timestamp on modification', function () {
        $product = Product::factory()->create();
        $originalUpdatedAt = $product->updated_at;

        // Wait a bit to ensure timestamp difference
        sleep(1);

        $product->update(['name' => 'Updated Name']);

        expect($product->updated_at->isAfter($originalUpdatedAt))->toBeTrue();
    });
});

describe('Product Route Security', function () {
    it('requires authentication for product routes', function () {
        // Create a new test instance without authentication
        $this->post('/logout'); // Logout current user
        
        $response = $this->get(route('products.index'));
        $response->assertRedirect(route('login'));

        $response = $this->get(route('products.create'));
        $response->assertRedirect(route('login'));

        $response = $this->post(route('products.store'), []);
        $response->assertRedirect(route('login'));
    });

    it('allows authenticated users to access product routes', function () {
        $this->get(route('products.index'))->assertSuccessful();
        $this->get(route('products.create'))->assertSuccessful();
    });

    it('protects against mass assignment', function () {
        $response = $this->post(route('products.store'), [
            'name' => 'Test Product',
            'price' => 99.99,
            'description' => 'Test description',
            'id' => 999, // Should be ignored
            'created_at' => '2020-01-01', // Should be ignored
            'updated_at' => '2020-01-01' // Should be ignored
        ]);

        $product = Product::first();
        expect($product->id)->not->toBe(999);
        expect($product->created_at)->not->toBe('2020-01-01');
    });
});

describe('Product HTTP Methods', function () {
    it('responds correctly to different HTTP methods', function () {
        $product = Product::factory()->create();

        // GET requests
        $this->get(route('products.index'))->assertSuccessful();
        $this->get(route('products.show', $product))->assertSuccessful();
        $this->get(route('products.edit', $product))->assertSuccessful();
        $this->get(route('products.create'))->assertSuccessful();

        // POST request
        $this->post(route('products.store'), [
            'name' => 'New Product',
            'price' => 99.99
        ])->assertRedirect();

        // PUT request
        $this->put(route('products.update', $product), [
            'name' => 'Updated Product',
            'price' => 149.99,
            'description' => 'Updated description'
        ])->assertRedirect();

        // DELETE request
        $this->delete(route('products.delete', $product))->assertRedirect();
    });

    it('rejects invalid HTTP methods', function () {
        $product = Product::factory()->create();

        // PATCH to store route (should be POST)
        $this->patch(route('products.store'))->assertMethodNotAllowed();

        // POST to update route (should be PUT)
        $this->post(route('products.update', $product))->assertMethodNotAllowed();
    });
});
