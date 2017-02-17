<?php
namespace DPRMC\FileMunger;

use PHPUnit\Framework\TestCase;
use DPRMC\FileMunger\Engines\GS360JournalEntryToSentryFile;

// https://packagist.org/packages/mikey179/vfsStream
use org\bovigo\vfs\vfsStream;


class MungerTest extends TestCase {
    /**
     * @var string An arbitrary name given to the VFS filesystem's root directory.
     */
    protected $rootVfsDirectoryName = 'test';

    /**
     * @var string
     */
    protected $goodStorageDirectoryName = 'good_storage';

    /**
     * @var string
     */
    protected $badStorageDirectoryName = 'bad_storage';

    /**
     * @var string
     */
    protected $goodSourceFileName = 'good_source.csv';

    /**
     * @var string
     */
    protected $badSourceFileName = 'bad_source.csv';

    /**
     * @var string
     */
    protected $goodDestinationFileName = 'good_destination.csv';

    /**
     * @var string
     */
    protected $badDestinationFileName = 'bad_destination.csv';

    /**
     * @var \org\bovigo\vfs\vfsStreamDirectory
     */
    protected $rootVfsDirectory;

    /**
     * @var \org\bovigo\vfs\vfsStreamDirectory
     */
    protected $goodStorageDirectory;

    /**
     * @var \org\bovigo\vfs\vfsStreamDirectory
     */
    protected $badStorageDirectory;

    /**
     * @var \org\bovigo\vfs\vfsStreamDirectory
     */
    protected $goodSource;

    /**
     * @var \org\bovigo\vfs\vfsStreamDirectory
     */
    protected $badSource;

    /**
     * @var \org\bovigo\vfs\vfsStreamDirectory
     */
    protected $goodDestination;

    /**
     * @var \org\bovigo\vfs\vfsStreamDirectory
     */
    protected $badDestination;


    public function setUp() {
        $this->rootVfsDirectory = vfsStream::setup($this->rootVfsDirectoryName);
        $this->goodStorageDirectory = vfsStream::setup($this->goodStorageDirectory,
                                                       07000);
        $this->badStorageDirectory = vfsStream::setup($this->badStorageDirectory,
                                                      0000);

        vfsStream::newFile($this->goodSourceFileName,
                           0700)
                 ->at($this->goodStorageDirectory)
                 ->setContent('');
        vfsStream::newFile($this->goodDestinationFileName,
                           0700)
                 ->at($this->goodStorageDirectory)
                 ->setContent('');
        vfsStream::newFile($this->badSourceFileName,
                           0000)
                 ->at($this->goodStorageDirectory)
                 ->setContent('');
        vfsStream::newFile($this->badDestinationFileName,
                           0000)
                 ->at($this->goodStorageDirectory)
                 ->setContent('');

    }

    public function testSetDestination() {
        $engine = new GS360JournalEntryToSentryFile();
        $munger = new Munger($engine);
        $munger->setDestination($this->goodStorageDirectory . DIRECTORY_SEPARATOR . $this->goodDestinationFileName);
        $this->assertDirectoryIsWritable($this->goodStorageDirectory);
        /*$this->assertEquals($this->goodDestinationFile,
                            $munger->getDestination());*/
    }

    public function testGetSource() {
        $engine = new GS360JournalEntryToSentryFile();
        $munger = new Munger($engine);
        $munger->setSource();
        $source = '/not/a/real/path/file.csv';
        $returnedSource = $munger->getSource();
        $this->assertEquals($returnedSource,
                            $source);
    }


}