<?php

namespace DevFighters\Utils\Application\UseCase\Excel;

use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ImporterExcel
{

    private bool $firstRowAsHeader = false;
    private bool $useHeaderAsKey = false;
    private bool $clearFormulas = true;

    public function extractData(string $filePath, ?string $sheetName = null): array
    {
        $spreadsheet = IOFactory::load($filePath);

        $sheet = null;
        if (!is_null($sheetName)) {
            $sheet = $spreadsheet->getSheetByName($sheetName);
        }
        if (is_null($sheet)) {
            $sheet = $spreadsheet->getActiveSheet();
        }


        $sheetData = $this->extractSheetData($sheet);
        if ($this->firstRowAsHeader) {
            if ($this->useHeaderAsKey) {
                $this->transformDataWithHeaderKey($sheetData);
            } else {
                array_shift($sheetData);
            }

        }
        return $sheetData;
    }

    public function isFirstRowAsHeader(): bool
    {
        return $this->firstRowAsHeader;
    }

    public function setFirstRowAsHeader(bool $firstRowAsHeader): static
    {
        $this->firstRowAsHeader = $firstRowAsHeader;
        return $this;
    }

    public function isUseHeaderAsKey(): bool
    {
        return $this->useHeaderAsKey;
    }

    public function setUseHeaderAsKey(bool $useHeaderAsKey): static
    {
        $this->useHeaderAsKey = $useHeaderAsKey;
        return $this;
    }

    public function isClearFormulas(): bool
    {
        return $this->clearFormulas;
    }

    public function setClearFormulas(bool $clearFormulas): static
    {
        $this->clearFormulas = $clearFormulas;
        return $this;
    }


    private function extractSheetData(Worksheet $sheet): array
    {
        $sheetData = [];
        foreach ($sheet->getRowIterator() as $row) {
            $sheetData[] = $this->extractRowData($row);
        }
        return $sheetData;
    }

    private function extractRowData(Row $row): array
    {
        $rowData = [];
        foreach ($row->getCellIterator() as $cell) {
            $rowData[] = $this->extractCellData($cell);
        }
        return $rowData;
    }

    private function extractCellData(Cell $cell): string|float|int|bool|null
    {
        $cellData = $cell->getValue();
        if (is_string($cellData)) {
            $cellData = str_replace(array("\xc2\xa0", '_x000D_'), array(" ", ''), $cellData);
            $cellData = rtrim($cellData);
        }
        if ($this->clearFormulas && str_starts_with($cellData, '=')) {
            $cellData = null;
        }
        return $cellData;
    }

    private function transformDataWithHeaderKey(array &$data): void
    {
        $keys = array_shift($data);
        $data = array_map(static function ($row) use ($keys) {
            return array_combine($keys, $row);
        }, $data);
    }


}