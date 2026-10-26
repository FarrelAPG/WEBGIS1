$excelPath = 'C:\Users\tfath\.gemini\antigravity\brain\78079722-2ebb-44b1-ad08-dd0875d618fa\media_1793045694298_83c3c029.xlsx'
$outputPath = 'C:\Users\tfath\WEBGIS1\database\data\palembang_hotspots.json'

$excel = New-Object -ComObject Excel.Application
$excel.Visible = $false
$workbook = $excel.Workbooks.Open($excelPath)
$sheet = $workbook.Worksheets.Item(1)
$used = $sheet.UsedRange
$rows = $used.Rows.Count
$cols = $used.Columns.Count

# Get headers
$header = @()
for($c=1;$c -le $cols;$c++){
    $header += $used.Cells.Item(1,$c).Text
}

$data = @()
for($r=2;$r -le $rows;$r++){
    $rowObj = @{}
    for($c=1;$c -le $cols;$c++){
        $rowObj[$header[$c-1]] = $used.Cells.Item($r,$c).Text
    }
    if($rowObj['Region'] -eq 'Palembang'){
        $data += $rowObj
    }
}

$json = $data | ConvertTo-Json -Depth 5
Set-Content -Path $outputPath -Value $json -Encoding utf8

$workbook.Close($false)
$excel.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($sheet) | Out-Null
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($workbook) | Out-Null
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($excel) | Out-Null

