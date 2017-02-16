<?php
namespace DPRMC\FileMunger;
abstract class MungEngineCsv extends MungEngine {

    /**
     * http://php.net/manual/en/function.fgetcsv.php
     * Leave at zero for no limit on the length of lines read in by fgetcsv()
     * @var int
     */
    protected $csvSplitLength = 0;

    /**
     * @var string The delimiter character used in the source csv file.
     */
    protected $delimiter = ',';

    /**
     * @var string
     */
    protected $enclosure = '"';

    /**
     * @var string The escape character used by php's fgetcsv() function.
     */
    protected $escapeCharacter = "\\";

    /**
     * @var bool Should the readSourceFile() method read in blank lines in the source file?
     */
    protected $readBlankLines = false;


    /**
     * This method attempts to read in the source file from disk, and parse it
     * into a format that is digestible by the MungEngine.
     * @throws Exception
     */
    protected function readSourceFile() {

        $handle = fopen($this->getSourceFilePath(),
                        "r");
        if ($handle === false) {
            throw new Exception("We were unable to open the file at '" . $this->getSourceFilePath() . "' with the fopen() function.");
        }

        $rows = [];
        while (($data = fgetcsv($handle,
                                $this->getCsvSplitLength(),
                                $this->getDelimiter(),
                                $this->getEnclosure(),
                                $this->getEscapeCharacter())) !== FALSE) {

            /**
             * Only write to our list of rows if:
             *  - there is content in the row
             *  - we explicitly want to read blank lines.
             */
            if (!$this->isBlankLine($data) || $this->readBlankLines()) {
                $rows[] = $data;
            }
        }
        fclose($handle);

        $this->sourceContent = $rows;
    }

    /**
     * @param array $row
     * @return bool
     */
    protected function isBlankLine(array $row) {
        if (count($row) == 1 && $row[0] == null) {
            return true;
        }
        return false;
    }


    /**
     * @return string
     */
    protected function getEscapeCharacter(): string {
        return $this->escapeCharacter;
    }

    /**
     * @param string $escapeCharacter
     */
    public function setEscapeCharacter(string $escapeCharacter) {
        $this->escapeCharacter = $escapeCharacter;
    }

    /**
     * @return string
     */
    protected function getDelimiter(): string {
        return $this->delimiter;
    }

    /**
     * @param string $delimiter
     */
    public function setDelimiter(string $delimiter) {
        $this->delimiter = $delimiter;
    }

    /**
     * @return int
     */
    protected function getCsvSplitLength(): int {
        return $this->csvSplitLength;
    }

    /**
     * @param int $csvSplitLength
     */
    public function setCsvSplitLength(int $csvSplitLength) {
        $this->csvSplitLength = $csvSplitLength;
    }

    /**
     * @return string
     */
    protected function getEnclosure(): string {
        return $this->enclosure;
    }

    /**
     * @param string $enclosure
     */
    public function setEnclosure(string $enclosure) {
        $this->enclosure = $enclosure;
    }

    /**
     * @return bool
     */
    protected function readBlankLines(): bool {
        return $this->readBlankLines;
    }

    /**
     * @param bool $readBlankLines
     */
    public function setReadBlankLines(bool $readBlankLines) {
        $this->readBlankLines = $readBlankLines;
    }


}