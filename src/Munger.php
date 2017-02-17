<?php
namespace DPRMC\FileMunger;

use DPRMC\FileMunger\MungEngine;

class Munger {

    /**
     * @var \MungEngineInterface
     */
    private $engine;

    /**
     * @var string Absolute file path of the source of the file to be munged.
     */
    private $source;

    /**
     * @var string Absolute file path to the destination of the munged file.
     */
    private $destination;


    /**
     * Munger constructor.
     * @param \DPRMC\FileMunger\MungEngine $engine
     */
    public function __construct(MungEngine $engine) {
        $this->engine = $engine;
    }


    /**
     * @param string $source The absolute file path of the source file to be munged.
     * @param string $destination The absolute file path to the destination of the munged file.
     * @return bool
     */
    public function mungAndSaveFile(string $source, string $destination, bool $overwriteDestination = true) {
        $this->setSource($source);
        $this->setDestination($destination);
        $this->engine->mungAndSaveFile($this->getSource(),
                                       $this->getDestination(),
                                       $overwriteDestination);
        return true;
    }

    /**
     *
     * @param string $destination Absolute file path to the destination of the munged file.
     * @param bool $overwriteDestinationFile Flag telling us to overwrite the destination file if it exists.
     * @throws \Exception
     */
    public function setDestination($destination, $overwriteDestinationFile = true) {
        if (file_exists($destination) && $overwriteDestinationFile == false) {
            throw new \Exception("The destination file located at '" . $destination . "' . exists, and you turned off the setting to overwrite destination files.");
        }

        $dir = dirname($destination);

        if (!is_writable($dir)) {
            throw new \Exception("The destination file's directory at '" . $dir . "' is not writable.");
        }
        $this->destination = $destination;
    }

    /**
     * @return string The absolute file path of the munged destination file.
     * @throws \Exception
     */
    public function getDestination() {
        if (file_exists($this->destination) && !is_readable($this->destination)) {
            throw new \Exception("The destination file at '" . $this->destination . "' exists, but is not readable.");
        }
        return $this->destination;
    }

    /**
     * @param string $source he absolute file path of the source file to be munged.
     * @throws \Exception If the source file is not readable.
     */
    public function setSource(string $source) {
        if (!is_readable($source)) {
            throw new \Exception("The source file at '" . $source . "' is not readable.");
        }

        $this->source = $source;
    }

    /**
     * @return string The absolute file path of the source file to be munged.
     */
    public function getSource() {
        if (!is_readable($this->source)) {
            throw new \Exception("The source file at '" . $this->source . "' . is not readable");
        }
        return $this->source;
    }


}