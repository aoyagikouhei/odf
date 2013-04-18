<?php
namespace OpenDocumentFormat;

class Spreadsheet
{
    private $xml;
    public function __construct($path=null) {
        if (!is_null($path))
        {
            $this->read($path);
        }
    }

    public function read($path)
    {
        $zip = new \ZipArchive();
        $zip->open($path);
        $fp = $zip->getStream('content.xml');
        $content = '';
        while (!feof($fp)) {
            $content .= fread($fp, 2);
        }
        fclose($fp);
        $this->xml = simplexml_load_string($content);
    }

    public function getTableCount()
    {
        $result = $this->xml->xpath('/office:document-content/office:body/office:spreadsheet/table:table');
        return count($result);
    }

    public function getTable($index) {
        $result = $this->xml->xpath('/office:document-content/office:body/office:spreadsheet/table:table');
        return new Table($result[$index]);
    }
}