<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SimpleXMLElement;
use Illuminate\Support\Facades\File as LaravelFile;
use Illuminate\Support\Facades\Storage;

/**
 * XmlStructure Command
 *
 * This command inspects an XML file, outputs its structure in JSON format, and can be useful for debugging or understanding XML content.
 */

class XmlStructure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xml:inspect {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Here We can see the JSON Format of the uploaded file.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Retrieve the filename argument
        $file_name = $this->argument('filename');
        $file = storage_path('app/uploads/' . $file_name);

        if(!LaravelFile::exists($file)){
            $this->error('File Not Found: ' . $file);
            return;
        }

        $xml = simplexml_load_file($file);

        if($xml == false){
            $this->error('Failed to load XML File:');
            return;
        }

        // Output XML structure for debugging
        $this->info(print_r($xml, true));

        // Output the XML structure as JSON
        $this->info(json_encode($this->xmlToArray($xml), JSON_PRETTY_PRINT));
    }

    // Convert a SimpleXMLElement object representing XML to a nested associative array.
    protected function xmlToArray(SimpleXMLElement $xml): array
    {
        $array = [];

        foreach($xml->children() as $child){
            $item = [];
            foreach($child->attributes() as $key=> $value) {
                $item[$key] = (string) $value;
            }
            foreach ($child->children() as $key => $value) {
                $item[$key] = $value->count() > 0 ? $this->xmlToArray($value) : (string) $value;
            }
            $array[] = $item;
        }    
        return $array;
    }
}
