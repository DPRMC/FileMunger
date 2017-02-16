<?php
namespace DPRMC\FileMunger;
/**
 * Interface MungEngineInterface
 */
interface MungEngineInterface {

    /**
     * @param string $source The absolute file path of the source file to be munged.
     * @param string $destination The absolute file path to the destination of the munged file.
     * @return mixed
     */
    public function mungAndSaveFile(string $source, string $destination);

}