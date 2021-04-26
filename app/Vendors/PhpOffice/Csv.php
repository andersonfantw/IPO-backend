<?php
namespace App\Vendors\PhpOffice;

use PhpOffice\PhpSpreadsheet\Reader\Csv as _Csv;
use PhpOffice\PhpSpreadsheet\Shared\StringHelper;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Csv extends _Csv
{

    public function getReader(): Csv
    {
        return $this;
    }

    protected function openFileOrMemory($pFilename): void
    {
        // Open file
        $fhandle = $this->canRead($pFilename);
        if (!$fhandle) {
            throw new Exception($pFilename . ' is an Invalid Spreadsheet file.');
        }
        $this->openFile($pFilename);
        if ($this->getInputEncoding() !== 'UTF-8') {
            fclose($this->fileHandle);
            $entireFile = file_get_contents($pFilename);
            $this->fileHandle = fopen('php://memory', 'r+b');
            $data = StringHelper::convertEncoding($entireFile, 'UTF-8', $this->getInputEncoding());
            fwrite($this->fileHandle, $data);
            $this->skipBOM();
        }
    }

    public function loadIntoExisting($pFilename, Spreadsheet $spreadsheet): Spreadsheet
    {
        $lineEnding = ini_get('auto_detect_line_endings');
        ini_set('auto_detect_line_endings', true);

        // Open file
        $this->openFileOrMemory($pFilename);
        $fileHandle = $this->fileHandle;

        // Skip BOM, if any
        $this->skipBOM();
        $this->checkSeparator();
        $this->inferSeparator();

        // Create new PhpSpreadsheet object
        while ($spreadsheet->getSheetCount() <= $this->getSheetIndex()) {
            $spreadsheet->createSheet();
        }
        $sheet = $spreadsheet->setActiveSheetIndex($this->getSheetIndex());

        // Set our starting row based on whether we're in contiguous mode or not
        $currentRow = 1;
        $outRow = 0;

        // Loop through each line of the file in turn
        while (($rowData = $this->_fgetcsv($fileHandle, 0, $this->getDelimiter(), $this->getEnclosure(), $this->getEscapeCharacter())) !== false) {
            $noOutputYet = true;
            $columnLetter = 'A';
            foreach ($rowData as $rowDatum) {
                if ($rowDatum != '' && $this->readFilter->readCell($columnLetter, $currentRow)) {
                    if ($this->getContiguous()) {
                        if ($noOutputYet) {
                            $noOutputYet = false;
                            ++$outRow;
                        }
                    } else {
                        $outRow = $currentRow;
                    }
                    // Set cell value
                    $sheet->getCell($columnLetter . $outRow)->setValue($rowDatum);
                }
                ++$columnLetter;
            }
            ++$currentRow;
        }

        // Close file
        fclose($fileHandle);

        ini_set('auto_detect_line_endings', $lineEnding);

        // Return
        return $spreadsheet;
    }

    public function _fgetcsv(&$handle, int $length = null, String $d = ",", String $e = '"')
    {
        $d = preg_quote($d);
        $e = preg_quote($e);
        $_line = "";
        $eof = false;
        while ($eof != true) {
            $_line .= (empty($length) ? fgets($handle) : fgets($handle, $length));
            $itemcnt = preg_match_all('/' . $e . '/', $_line, $dummy);
            if ($itemcnt % 2 == 0) {
                $eof = true;
            }
        }

        $_csv_line = preg_replace('/(?: |[ ])?$/', $d, trim($_line));

        $_csv_pattern = '/(' . $e . '[^' . $e . ']*(?:' . $e . $e . '[^' . $e . ']*)*' . $e . '|[^' . $d . ']*)' . $d . '/';
        preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
        $_csv_data = $_csv_matches[1];

        for ($_csv_i = 0; $_csv_i < count($_csv_data); $_csv_i++) {
            $_csv_data[$_csv_i] = preg_replace("/^" . $e . "(.*)" . $e . "$/s", "$1", $_csv_data[$_csv_i]);
            $_csv_data[$_csv_i] = str_replace($e . $e, $e, $_csv_data[$_csv_i]);
        }

        return empty($_line) ? false : $_csv_data;
    }

}
