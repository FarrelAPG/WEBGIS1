const XLSX = require('xlsx');
const fs = require('fs');
const path = require('path');

const excelPath = path.resolve('C:/Users/tfath/.gemini/antigravity/brain/78079722-2ebb-44b1-ad08-dd0875d618fa/media_1793045694298_83c3c029.xlsx');
const outputPath = path.resolve('C:/Users/tfath/WEBGIS1/database/data/palembang_hotspots.json');

if (!fs.existsSync(excelPath)) {
  console.error('Excel file not found at', excelPath);
  process.exit(1);
}

const workbook = XLSX.readFile(excelPath);
const sheetName = workbook.SheetNames[0];
const sheet = workbook.Sheets[sheetName];
const rows = XLSX.utils.sheet_to_json(sheet, { defval: '' });

const filtered = rows.filter(row => row['Region'] === 'Palembang');

fs.writeFileSync(outputPath, JSON.stringify(filtered, null, 2), { encoding: 'utf8' });
console.log('Extracted', filtered.length, 'rows to', outputPath);

