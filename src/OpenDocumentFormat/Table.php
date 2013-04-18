<?php
namespace OpenDocumentFormat;

class Table
{
    private $xml;
    public function __construct($xml) {
        $this->xml = $xml;
    }

    public function getName()
    {
        return $this->xml->attributes('urn:oasis:names:tc:opendocument:xmlns:table:1.0')->name;
    }

    public function getRow($rowIndex)
    {
        return $this->xml->xpath('table:table-row')[$rowIndex];
    }

    public function getCell($rowIndex, $cellIndex)
    {
        $row = $this->getRow($rowIndex);
        if (is_null($row))
        {
            return null;
        }
        $cells = $row->xpath('table:table-cell');
        $index = 0;
        $result = null;
        foreach ($cells as $cell) {
            $name = 'number-columns-repeated';
            $num = (int)$cell->attributes('urn:oasis:names:tc:opendocument:xmlns:table:1.0')->$name;
            if (is_numeric($num) && (0 !== $num))
            {
                $index += $num;
            } elseif ($index === $cellIndex) {
                $result = $cell;
                break;
            } else if ($index > $cellIndex) {
                break;
            } else {
                $index += 1;
            }
        }
        return $result;
    }

    public function getValue($rowIndex, $cellIndex)
    {
        $cell = $this->getCell($rowIndex, $cellIndex);
        if (is_null($cell))
        {
            return null;
        }
        $textSpans = $cell->xpath('text:p/text:span');
        $result = '';
        if (count($textSpans) === 0) {
            $nodes = $cell->xpath('text:p/text()');
            if (!empty($nodes)) {
                $result = $nodes[0];
            }
        } else {
            foreach ($textSpans as $textSpan) {
                $result .= $textSpan->xpath('text()')[0];
            }
        }
        return (string)$result;
    }
}