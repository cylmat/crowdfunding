<?php

namespace Classes;

class RecordTest extends \PHPUnit\Framework\TestCase
{
    function testAlpha()
    {
        $record = new Record();
        $this->assertInstanceOf(Record::class, $record);

        //throw exception
        $this->expectException('\InvalidArgumentException');
        $record->caractere = 'huit';
    }
}