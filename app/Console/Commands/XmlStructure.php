<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SimpleXMLElement;
use Illuminate\Support\Facades\File as LaravelFile;
use Illuminate\Support\Facades\Storage;

class XmlStructure extends Command
{
    protected $signature = 'xml:inspect {filename}';
    protected $description = 'Inspect XML file structure';

    public function handle(): void
    {
        $filename = $this->argument('filename');
        $file = storage_path('app/uploads/' . $filename);

        if (!LaravelFile::exists($file)) {
            $this->error('File not found: ' . $file);
            return;
        }

        $xml = simplexml_load_file($file);

        if ($xml === false) {
            $this->error('Failed to load XML file.');
            return;
        }

        // Output XML structure for debugging
        $this->info(print_r($xml, true));

        // Output the XML structure as JSON
        $this->info(json_encode($this->xmlToArray($xml), JSON_PRETTY_PRINT));
    }

    protected function xmlToArray(SimpleXMLElement $xml): array
    {
        $array = [];

        foreach ($xml->children() as $child) {
            $item = [];
            foreach ($child->attributes() as $key => $value) {
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
