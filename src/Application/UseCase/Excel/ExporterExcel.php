<?php

namespace DevFighters\Utils\Application\UseCase\Excel;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

abstract class ExporterExcel
{
    private const string CACHE_MEMORY_LIMIT = '4096M';

    protected Spreadsheet $spreadsheet;
    protected Worksheet $sheet;

    public function __construct()
    {
        // Increase the memory limit for large datasets
        ini_set('memory_limit', self::CACHE_MEMORY_LIMIT);
        $this->spreadsheet = new Spreadsheet();
        $this->spreadsheet->getCalculationEngine()->disableCalculationCache();
    }

    public function exportExcel(string $fileName = 'export'): StreamedResponse
    {
        $spreadsheet = $this->spreadsheet;
        $writer = new Xlsx($spreadsheet);
        $writer->setPreCalculateFormulas(false);
        $response = new StreamedResponse(function () use ($writer): void {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$fileName.'.xlsx"');
        $response->headers->set('Cache-Control', 'max-age=0');

        $this->spreadsheet->garbageCollect();

        return $response;
    }

    public function saveExcel(string $path = '/tmp/export'): void
    {
        $spreadsheet = $this->spreadsheet;
        $writer = new Xlsx($spreadsheet);
        $writer->setPreCalculateFormulas(false);
        $writer->save($path);

        $this->spreadsheet->garbageCollect();
    }

    /**
     * @param array<int, array<int|string, mixed>> $data
     */
    protected function importTable(array $data, bool $useKeyAsHeader = true): void
    {
        // More intuitive than relying on array_key_first().
        if ($useKeyAsHeader && [] === $data) {
            return;
        }

        $this->sheet = $this->spreadsheet->getActiveSheet();
        $row = 1;

        if ($useKeyAsHeader) {
            $this->fillHeader($data, $row);
        }

        $this->fillData($data, $row);
        $this->finalizeStyling();
    }

    /**
     * @param array<int, array<int|string, mixed>> $data
     */
    protected function importTableNewSheet(
        array $data,
        string $sheetName,
        bool $useKeyAsHeader = true,
        bool $resetSheets = false,
    ): void {
        // More intuitive than relying on array_key_first().
        if ($useKeyAsHeader && [] === $data) {
            return;
        }

        // Remove all existing sheets if requested
        if ($resetSheets) {
            $sheetCount = $this->spreadsheet->getSheetCount();
            for ($i = $sheetCount - 1; $i >= 0; $i--) {
                $this->spreadsheet->removeSheetByIndex($i);
            }
            // Always create a fresh first sheet
            $this->sheet = $this->spreadsheet->createSheet(0);
        } else {
            // Create a new sheet after existing ones
            $this->sheet = $this->spreadsheet->createSheet();
        }

        $this->sheet->setTitle($sheetName);

        $row = 1;

        if ($useKeyAsHeader) {
            $this->fillHeader($data, $row);
        }

        $this->fillData($data, $row);
        $this->finalizeStyling();
    }

    protected function activateFirstSheet(): void
    {
        $this->spreadsheet->setActiveSheetIndex(0);
    }

    /**
     * @param array<int, array<int|string, mixed>> $data
     */
    private function fillHeader(array $data, int &$row): void
    {
        if ([] === $data) {
            return;
        }

        $firstLine = $data[array_key_first($data)];
        $columns = array_keys($firstLine);
        foreach ($columns as $index => $columnName) {
            // Switched column index logic to Coordinate::stringFromColumnIndex() (safe for any number of columns)
            $colLetter = Coordinate::stringFromColumnIndex($index + 1);
            $this->sheet->setCellValue("$colLetter$row", $columnName);
        }
        ++$row;
    }

    /**
     * @param array<int, array<int|string, mixed>> $data
     */
    private function fillData(array $data, int &$row): void
    {
        foreach ($data as $line) {
            foreach (array_values($line) as $index => $value) {
                // Switched column index logic to Coordinate::stringFromColumnIndex() (safe for any number of columns)
                $colLetter = Coordinate::stringFromColumnIndex($index + 1);
                $this->sheet->setCellValue("$colLetter$row", $value);
            }
            ++$row;
        }
    }

    private function finalizeStyling(): void
    {
        $highestRow = $this->sheet->getHighestRow();
        $highestCol = $this->sheet->getHighestColumn();
        $range = "A1:$highestCol$highestRow";

        foreach ($this->sheet->getColumnIterator() as $column) {
            $columnIndex = $column->getColumnIndex(); // e.g., A, B, C, AA, AB...
            $this->sheet->getColumnDimension($columnIndex)->setAutoSize(true);
        }

        $this->sheet->getStyle($range)
            ->getAlignment()
            ->setWrapText(true)
            ->setVertical(Alignment::VERTICAL_CENTER);
    }
}
