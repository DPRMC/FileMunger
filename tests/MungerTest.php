<?php
namespace DPRMC\FileMunger;

use PHPUnit\Exception;
use PHPUnit\Framework\TestCase;
use DPRMC\FileMunger\Engines\GS360JournalEntryToSentryFile;

class CUSIPTest extends TestCase {
    public $storage = './tests/storage';

    public function __construct($name = null, array $data = [], $dataName = '') {
        parent::__construct($name,
                            $data,
                            $dataName);

        $this->storage = realpath($this->storage);

        if (!is_writable($this->storage)) {
            throw new \Exception($this->storage . " is not writable.");
        }

    }

    public function testSetDestination() {
        $engine = new GS360JournalEntryToSentryFile();
        $munger = new Munger($engine);

        $destination = $this->storage . '/destination.csv';
        $munger->setDestination($destination);
        $this->assertEquals($destination,
                            $munger->getDestination());
    }

    public function testGetSource() {
        $engine = new GS360JournalEntryToSentryFile();
        $munger = new Munger($engine);
        $source = '/not/a/real/path/file.csv';
        $returnedSource = $munger->getSource();
        $this->assertEquals($returnedSource,
                            $source);
    }


}