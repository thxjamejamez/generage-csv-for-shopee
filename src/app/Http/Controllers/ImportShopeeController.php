<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ShopeeFormatLazadaExport;

class ImportShopeeController extends Controller
{
    public function transformToLazadaFormat(Request $request)
    {
        $file = $request->file('file');
        $content = file($file->getRealPath(), FILE_IGNORE_NEW_LINES);
        $firstRow = collect(explode(',', $content[0]));
        unset($content[0]);
        
        $start_col = $request->input('start_col', 10);
        $end_col = $firstRow->count();

        $slice_start = $start_col - 1;
        $number_of_end = $end_col - $slice_start;
        $itemRowData = $firstRow->slice($slice_start, $number_of_end);
        $header = $firstRow->slice(0, $slice_start);

        $data = collect($content)->map(function ($transactionData) use ($itemRowData, $header){
            $transaction = explode(',', $transactionData);
            return $itemRowData->map(function ($itemRow, $key) use ($transaction, $header) {
                $fixData = collect();
                $header->each(function ($i, $k) use ($fixData, $transaction) {
                    $fixData->push([$k => $transaction[$k]]);
                });

                $result = $fixData->flatten();
                $result['dynamic_name'] = $itemRow;
                $result['dynamic_value'] = $transaction[$key];
                
                return $result;
            });
        });

        $fileName = 'converted-shopee-data' . date('Y_m_d_H_i_s') . '.csv';

        return Excel::download(new ShopeeFormatLazadaExport($data, $header->toArray()), $fileName);
    }
}
