<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class InsertProductDataTest extends TestCase{
    use RefreshDatabase;

    // Check if the file path exists
    public function test_file_path_exists(): void
    {
        $filePath = $this->app->storagePath('app/uploads/feed.xml');

        if (file_exists($filePath)) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false, "File path doesn't exist: $filePath");
        }
    }
    // check if the product data exists
    public function test_product_data_exists(): void
    {
        $filePath = $this->app->storagePath('app/uploads/feed.xml');
        $xml = simplexml_load_file($filePath);

        if ($xml === false) {
            $this->assertTrue(false, 'Failed to load the XML file.');
        } else {
            $this->assertTrue(true, 'XML file loaded successfully.');
        }
    }
    // check if the product data is inserted into the database
    public function test_product_data_inserted(): void
    {
        $filePath = $this->app->storagePath('app/uploads/mock.xml');
        $xml = simplexml_load_file($filePath);
        $products = [];

        try {
            foreach ($xml->item as $item) {
                $productData = [
                    'entity_id' => $item->entity_id,
                    'category_name' => $item->CategoryName,
                    'sku' => $item->sku,
                    'name' => $item->name,
                    'description' => $item->description,
                    'short_desc' => $item->shortdesc,
                    'price' => (float)$item->price,
                    'link' => $item->link,
                    'image' => $item->image,
                    'brand' => $item->Brand,
                    'rating' => (float)$item->Rating,
                    'caffeine_type' => $item->CaffeineType,
                    'count' => (int)$item->Count,
                    'flavored' => $item->Flavored,
                    'seasonal' => $item->Seasonal,
                    'instock' => (bool)$item->Instock,
                    'facebook' => $item->Facebook,
                    'isk_cup' => (bool)$item->IsKCup,
                ];

                $existingProduct = Product::where('entity_id', $productData['entity_id'])->first();

                if ($existingProduct === null) {
                    $products[] = $productData;
                }
            }

            // Output the data before insertion for debugging
            dump($products);

            Product::insert($products);
            $this->assertTrue(true, 'Product data inserted successfully.');
        } catch (\Exception $e) {
            $this->assertTrue(false, 'Failed to insert product data.');
        }
    }
}
