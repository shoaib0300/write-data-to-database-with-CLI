<?php

// app/Console/Commands/InsertProductData.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;

class InsertProductData extends Command
{
    protected $signature = 'product:insert';
    protected $description = 'Insert product data into the database';

    public function handle(): void
    {
        // Change the path or filename you want to add data into database
        $filePath = storage_path('app/uploads/feed.xml'); 
    
        if (!File::exists($filePath)) {
            $this->error('File not found: ' . $filePath);
            return;
        }
    
        $xml = simplexml_load_file($filePath);
    
        if ($xml === false) {
            $this->error('Failed to load XML file.');
            return;
        }
    
        $products = [];
    
        try{
            foreach ($xml->item as $item) {
                $productData = [
                    'entity_id' => $item->entity_id,
                    'category_name' => $item->CategoryName,
                    'sku' => $item->sku,
                    'name' => $item->name,
                    'description' => $item->description,
                    'short_desc' => $item->shortdesc,
                    'price' => $item->price,
                    'link' => $item->link,
                    'image' => $item->image,
                    'brand' => $item->Brand,
                    'rating' => $item->Rating,
                    'caffeine_type' => $item->CaffeineType,
                    'count' => $item->Count,
                    'flavored' => $item->Flavored,
                    'seasonal' => $item->Seasonal,
                    'instock' => $item->Instock,
                    'facebook' => $item->Facebook,
                    'isk_cup' => $item->IsKCup,
                ];
        
                $existingProduct = Product::where('entity_id', $productData['entity_id'])->first();
        
                if ($existingProduct) {
                    $this->warn("Product with entity_id {$productData['entity_id']} already exists. Skipped insertion.");
                    continue;
                }
                $products[] = $productData;
            }
        
            if(!empty($products)) {
                // Insert the products that are not duplicates
                Product::insert($products);
            }
            $this->info('Product data insertion completed.');
        } 
        catch (\FileNotFoundException $e) {
            Log::channel('custom')->info("File Not Found While inserting Data. Skipped insertion.");
            $this->error("File not found: " . $e->getMessage());
        } 
        catch (\Exception $e) {
            Log::channel('custom')->info("Product is not created see errors. " . $e->getMessage());
            Log::error("Product insertion failed: " . $e->getMessage());
            $this->warn("Product is not successfully entered in the database. Check the logs for details.");
        }
    }
}    