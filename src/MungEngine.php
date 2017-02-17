<?php
namespace DPRMC\FileMunger;

abstract class MungEngine implements MungEngineInterface {

    /**
     * @var string Absolute file path of the source of the file to be munged.
     */
    protected $sourceFilePath;

    /**
     * @var string Absolute file path to the destination of the munged file.
     */
    protected $destinationFilePath;

    /**
     * @var string
     */
    protected $sourceContent = '';

    /**
     * @var bool
     */
    protected $overwriteDestinationFile = true;



    /**
     * @return string The absolute path of the munged file.
     */
    protected abstract function mung();

    public function mungAndSaveFile(string $source, string $destination, bool $overwriteDestinationFile = true) {
        $this->setSourceFilePath($source);
        $this->setDestinationFilePath($destination,
                                      $overwriteDestinationFile);
        $this->readSourceFile();
        $this->mung();
        return $this->getDestinationFilePath();
    }

    /**
     * @param string $destination The absolute file path to the destination of the munged file.
     */
    protected function setDestinationFilePath($destination, $overwriteDestinationFile = true) {
        if ($overwriteDestinationFile) {
            $this->destinationFilePath = $destination;
        }


    }

    /**
     * @return string The absolute file path of the munged file.
     */
    protected function getDestinationFilePath(): string {
        return $this->destinationFilePath;
    }

    /**
     * @param string $source The absolute file path of the source file to be munged.
     */
    protected function setSourceFilePath(string $source) {
        $this->sourceFilePath = $source;
    }

    /**
     * @return string The absolute file path of the source file to be munged.
     */
    protected function getSourceFilePath() {
        return $this->sourceFilePath;
    }


    /**
     * This is the default implementation of the readSourceFile() method. It's
     * entirely possible that we will encounter some exotic file type where
     * the below code won't work. In that case, the custom MungEngine class
     * that extends this abstract class will need to write it's own
     * readSourceFile() method.
     * Assuming that the file at sourceFilePath exists, this method attempts to
     * read the contents of the file into an array.
     * @throws Exception If php's file() function returns false because it couldn't read in the file.
     */
    protected function readSourceFile() {
        // http://php.net/manual/en/filesystem.configuration.php#ini.auto-detect-line-endings
        $this->sourceContent = file_get_contents($this->getSourceFilePath());
        if ($this->sourceContent === false) {
            throw new Exception("We were unable to read the file at '" . $this->sourceFilePath . "' into a local string.");
        }
    }

    /**
     * @return bool
     */
    public function overwriteDestinationFile(): bool {
        return $this->overwriteDestinationFile;
    }

    /**
     * @param bool $overwriteDestinationFile
     */
    public function setOverwriteDestinationFile(bool $overwriteDestinationFile) {
        $this->overwriteDestinationFile = $overwriteDestinationFile;
    }

}