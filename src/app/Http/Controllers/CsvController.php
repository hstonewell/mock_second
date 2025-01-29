<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\Shop;

class CsvController extends Controller
{
    public function upload()
    {
        return view ('upload');
    }

    public function importCsv(Request $request)
    {
        $file = $request->file('csvFile');

        if ($file) {
            $path = $file->getRealPath();
            $fp = fopen($path, 'r');
            $header = fgetcsv($fp);

            $errors = [];
            $validData = [];
            $lineNumber = 1;

            while (($row = fgetcsv($fp)) !== false) {
                $lineNumber++;
                $rowData = array_combine($header, $row);

                if ($rowData === false) {
                    $errors[] = [
                        'line' => $lineNumber,
                        'row' => implode(', ', $row),
                        'errors' => ['header' => 'CSVヘッダーとデータ列の数が一致しません。']
                    ];
                    continue;
                }

                // バリデーション
                $validator = Validator::make($rowData, [
                    'shop_name' => ['required', 'string', 'max:50'],
                    'area' => ['required', 'string', 'in:東京都,大阪府,福岡県'],
                    'genre' => ['required', 'string', 'in:寿司,焼肉,イタリアン,居酒屋,ラーメン'],
                    'detail' => ['required', 'string', 'max:400'],
                    'image' => ['required', 'url', 'regex:/\.(jpeg|png|jpg)$/i'],
                ]);

                if ($validator->fails()) {
                    $errors[] = [
                        'line' => $lineNumber,
                        'row' => implode(', ', $rowData),
                        'errors' => $validator->errors()->toArray(),
                    ];
                    continue;
                }

                $validData[] = [
                    'shop_name' => $rowData['shop_name'],
                    'area_id' => $this->convertAreaNameToId($rowData['area']),
                    'genre_id' => $this->convertGenreNameToId($rowData['genre']),
                    'detail' => $rowData['detail'],
                    'image' => $rowData['image'],
                ];
            }

            fclose($fp);

            if (!empty($errors)) {
                return back()->with('import_errors', $errors);
            }

            foreach ($validData as $data) {
                Shop::create($data);
            }

            return back()->with('success', 'CSVインポートが完了しました。');
        }

        // ファイル未選択時のエラー処理
        return redirect()
            ->back()
            ->withErrors(['file' => 'CSVファイルを選択してください。']);
    }

    private function convertAreaNameToId($name)
    {
        return [
            '東京都' => 13,
            '大阪府' => 27,
            '福岡県' => 40,
        ][$name] ?? null;
    }

    private function convertGenreNameToId($name)
    {
        return [
            '寿司' => 1,
            '焼肉' => 2,
            'イタリアン' => 3,
            '居酒屋' => 4,
            'ラーメン' => 5,
        ][$name] ?? null;
    }
}
