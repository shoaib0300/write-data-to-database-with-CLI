<?php

// app/Console/Commands/InsertProductData.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\File;
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
        }catch(\Exception $e){
            $this->warn("Product is not successfully enterd in database". $e->getMessage());
        }
    }
}    