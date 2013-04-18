<?php
class OdfTest extends PHPUnit_Framework_TestCase
{
    public function testInit()
    {
        $erd = new \OpenDocumentFormat\Spreadsheet("./tests/files/test.ods");
        $this->assertEquals(1, $erd->getTableCount());
        $table = $erd->getTable(0);
        $this->assertEquals('a', $table->getValue(0, 0));
        $this->assertEquals('b', $table->getValue(0, 1));
        $this->assertEquals('c', $table->getValue(1, 0));
        $this->assertEquals('d', $table->getValue(1, 1));
    }
}
