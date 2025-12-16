<?php

namespace DevFighters\Utils\Application\UseCase\Excel;

use DevFighters\Utils\Application\DTO\File\PhysicalFileDTO;
use DevFighters\Utils\Interface\Response\DownloadPhysicalFileResponse;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $this->spreadsheet->getCalculationEngine()?->disableCalculationCache();
    }

    public function exportExcel(string $fileName = 'export'): DownloadPhysicalFileResponse
    {
        $spreadsheet = $this->spreadsheet;
        $writer = new Xlsx($spreadsheet);
        $writer->setPreCalculateFormulas(false);

        $tempPath = sys_get_temp_dir() . '/' . uniqid('spreadsheet_', true) . '.xlsx';
        $writer->save($tempPath);
        $this->spreadsheet->garbageCollect();

        $physicalFileDto = new PhysicalFileDto()
            ->setPhysicalPath($tempPath)
            ->setName("$fileName.xlsx");

        return new DownloadPhysicalFileResponse(
            file: $physicalFileDto,
            headers: [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Cache-Control' => 'max-age=0',
            ]
        )->deleteFileAfterSend();
    }

    protected function importTable(array $data, bool $useKeyAsHeader = true): void
    {
        // More intuitive than relying on array_key_first().
        if ($useKeyAsHeader && empty($data)) {
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

    private function fillHeader(array $data, int &$row): void
    {
        $columns = array_keys($data[array_key_first($data)]);
        foreach ($columns as $index => $columnName) {
            // Switched column index logic to Coordinate::stringFromColumnIndex() (safe for any number of columns)
            $colLetter = Coordinate::stringFromColumnIndex($index + 1);
            $this->sheet->setCellValue("$colLetter$row", $columnName);
        }
        $row++;
    }

    private function fillData(array $data, int &$row): void
    {
        foreach ($data as $line) {
            foreach (array_values($line) as $index => $value) {
                // Switched column index logic to Coordinate::stringFromColumnIndex() (safe for any number of columns)
                $colLetter = Coordinate::stringFromColumnIndex($index + 1);
                $this->sheet->setCellValue("$colLetter$row", $value);
            }
            $row++;
        }
    }

    private function finalizeStyling(): void
    {
        $highestRow = $this->sheet->getHighestRow();
        $highestCol = $this->sheet->getHighestColumn();
        $range = "A1:$highestCol$highestRow";

        foreach (range('A', $highestCol) as $col) {
            $this->sheet->getColumnDimension($col)
                ->setAutoSize(true);
        }

        $this->sheet->getStyle($range)
            ->getAlignment()
            ->setWrapText(true)
            ->setVertical(Alignment::VERTICAL_CENTER);
    }

}