<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class XmlStructureTest extends TestCase
{
    use RefreshDatabase;

    // Test to check if the XML file exists
    public function testFileExists(): void
    {
        $filePath = storage_path('app/uploads/feed.xml');
        $this->assertTrue(File::exists($filePath), "The XML file does not exist at path: $filePath");
    }

    // Test to check if the XML file is loaded successfully
    public function testFileLoadedSuccessfully(): void
    {
        $xml = simplexml_load_file(storage_path('app/uploads/feed.xml'));
        $this->assertNotFalse($xml, 'Failed to load the XML file.');
    }

    // Unit test to check if the XML can be converted to JSON
    public function testXmlToJsonConversion(): void
    {
        $xmlContent = file_get_contents(storage_path('app/uploads/feed.xml'));
        $xmlObject = simplexml_load_string($xmlContent);

        // Assert that XML content was loaded successfully
        $this->assertNotFalse($xmlObject, 'Failed to load XML content.');

        $jsonContent = json_encode($xmlObject);

        // Assert that the conversion to JSON was successful
        $this->assertNotFalse($jsonContent, 'Failed to convert XML to JSON.');
    }

}
