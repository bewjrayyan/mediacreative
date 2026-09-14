<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Http\UploadedFile;
use ZipArchive;
use SimpleXMLElement;

class ExcelImporter
{
    /**
     * Parse uploaded file (.xlsx or .csv) and import leads.
     */
    public function import(UploadedFile $file): array
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $rows = [];

        if ($extension === 'csv' || $extension === 'txt') {
            $rows = $this->parseCsv($file->getRealPath());
        } elseif ($extension === 'xlsx') {
            $rows = $this->parseXlsx($file->getRealPath());
        } else {
            return [
                'success' => false,
                'error' => 'Format fail tidak disokong. Sila muat naik fail .xlsx atau .csv.',
                'count' => 0,
            ];
        }

        if (empty($rows)) {
            return [
                'success' => false,
                'error' => 'Tiada rekod dijumpai dalam fail yang dimuat naik.',
                'count' => 0,
            ];
        }

        // Header mapping
        $headers = array_map(function ($h) {
            return strtolower(trim((string) $h));
        }, array_shift($rows));

        $nameIdx = $this->findHeaderIndex($headers, ['name', 'nama', 'full name', 'nama penuh']);
        $emailIdx = $this->findHeaderIndex($headers, ['email', 'e-mel', 'emel']);
        $phoneIdx = $this->findHeaderIndex($headers, ['phone', 'telefon', 'no phone', 'no. telefon', 'mobile', 'hp']);
        $companyIdx = $this->findHeaderIndex($headers, ['company', 'syarikat', 'organization', 'organisasi']);
        $sourceIdx = $this->findHeaderIndex($headers, ['source', 'sumber', 'channel']);
        $statusIdx = $this->findHeaderIndex($headers, ['status', 'peringkat']);
        $notesIdx = $this->findHeaderIndex($headers, ['notes', 'nota', 'catatan', 'remark']);

        if ($nameIdx === null) {
            // Fallback: If no recognized 'name' header, assume column 0 is Name if rows exist
            $nameIdx = 0;
        }

        $importedCount = 0;

        foreach ($rows as $row) {
            $name = isset($row[$nameIdx]) ? trim((string) $row[$nameIdx]) : '';
            if (empty($name)) {
                continue;
            }

            $email = ($emailIdx !== null && isset($row[$emailIdx])) ? trim((string) $row[$emailIdx]) : null;
            $phone = ($phoneIdx !== null && isset($row[$phoneIdx])) ? trim((string) $row[$phoneIdx]) : null;
            $company = ($companyIdx !== null && isset($row[$companyIdx])) ? trim((string) $row[$companyIdx]) : null;
            $source = ($sourceIdx !== null && isset($row[$sourceIdx])) ? trim((string) $row[$sourceIdx]) : 'Excel Import';
            $status = ($statusIdx !== null && isset($row[$statusIdx])) ? trim((string) $row[$statusIdx]) : 'New';
            $notes = ($notesIdx !== null && isset($row[$notesIdx])) ? trim((string) $row[$notesIdx]) : null;

            // Normalize status
            $status = $this->normalizeStatus($status);

            Lead::create([
                'name' => $name,
                'email' => $email ?: null,
                'phone' => $phone ?: null,
                'company' => $company ?: null,
                'source' => $source ?: 'Excel Import',
                'status' => $status,
                'notes' => $notes ?: null,
            ]);

            $importedCount++;
        }

        return [
            'success' => true,
            'count' => $importedCount,
            'message' => "Berjaya mengimport {$importedCount} rekod prospek lead.",
        ];
    }

    private function findHeaderIndex(array $headers, array $candidates): ?int
    {
        foreach ($headers as $idx => $header) {
            foreach ($candidates as $cand) {
                if (str_contains($header, $cand)) {
                    return $idx;
                }
            }
        }
        return null;
    }

    private function normalizeStatus(string $status): string
    {
        $s = strtolower($status);
        if (str_contains($s, 'contact') || str_contains($s, 'hubungi')) return 'Contacted';
        if (str_contains($s, 'qualifi') || str_contains($s, 'layak')) return 'Qualified';
        if (str_contains($s, 'convert') || str_contains($s, 'menang') || str_contains($s, 'pelanggan')) return 'Converted';
        if (str_contains($s, 'lost') || str_contains($s, 'gagal') || str_contains($s, 'batal')) return 'Lost';
        return 'New';
    }

    /**
     * Parse CSV file into rows array.
     */
    private function parseCsv(string $filePath): array
    {
        $rows = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            // Remove UTF-8 BOM if present
            $bom = fread($handle, 3);
            if ($bom !== "\xEF\xBB\xBF") {
                rewind($handle);
            }

            // Auto-detect delimiter (, or ;)
            $firstLine = fgets($handle);
            rewind($handle);
            if ($bom !== "\xEF\xBB\xBF") {
                // skip BOM again if re-reading
            }
            $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';

            while (($data = fgetcsv($handle, 10000, $delimiter)) !== false) {
                if (array_filter($data)) {
                    $rows[] = $data;
                }
            }
            fclose($handle);
        }
        return $rows;
    }

    /**
     * Native XLSX parser using ZipArchive + SimpleXML
     */
    private function parseXlsx(string $filePath): array
    {
        $zip = new ZipArchive();
        if ($zip->open($filePath) !== true) {
            return [];
        }

        // Shared strings
        $sharedStrings = [];
        $stringsXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($stringsXml !== false) {
            $xml = simplexml_load_string($stringsXml);
            if ($xml && isset($xml->si)) {
                foreach ($xml->si as $val) {
                    if (isset($val->t)) {
                        $sharedStrings[] = (string) $val->t;
                    } elseif (isset($val->r)) {
                        $str = '';
                        foreach ($val->r as $r) {
                            $str .= (string) $r->t;
                        }
                        $sharedStrings[] = $str;
                    } else {
                        $sharedStrings[] = '';
                    }
                }
            }
        }

        // Worksheet 1
        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        $zip->close();

        if ($sheetXml === false) {
            return [];
        }

        $xml = simplexml_load_string($sheetXml);
        if (!$xml || !isset($xml->sheetData->row)) {
            return [];
        }

        $rows = [];
        foreach ($xml->sheetData->row as $rowEl) {
            $rowValues = [];
            foreach ($rowEl->c as $cell) {
                $type = (string) $cell['t'];
                $value = (string) $cell->v;

                if ($type === 's' && isset($sharedStrings[(int)$value])) {
                    $val = $sharedStrings[(int)$value];
                } else {
                    $val = $value;
                }
                $rowValues[] = $val;
            }
            if (array_filter($rowValues)) {
                $rows[] = $rowValues;
            }
        }

        return $rows;
    }
}
