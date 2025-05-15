<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;
use Exception;

class XmlDataController extends Controller
{
    public function generateProductCsv()
    {
        $xmlUrl = 'https://it-delta.ru/local/docs/yandex_not_sku.xml';
        $csvFileName = 'products.csv';

        try {
            $response = Http::get($xmlUrl);
            if ($response->failed()) {
                return response()->json(['error' => 'Failed to fetch XML data', 'status_code' => $response->status()], 400);
            }

            $xmlContent = $response->body();
            $xml = new SimpleXMLElement($xmlContent);

        } catch (Exception $e) {
            return response()->json(['error' => 'Error processing XML or HTTP request', 'message' => $e->getMessage()], 500);
        }

        $shop = $xml->shop;
        if (!isset($shop)) {
            return response()->json(['error' => 'Could not find <shop> element in XML.'], 400);
        }
        $categories = [];
        if (isset($shop->categories->category)) {
            foreach ($shop->categories->category as $category) {
                $categories[(string)$category['id']] = trim((string)$category);
            }
        }

        $productsData = [];
        $headers = [
            'Наименование категории',
            'Наименование товара',
            'Ссылка на товар',
            'Цена товара',
            'Описание товара',
            'Страна',
        ];

        $count = 0;
        if (!isset($shop->offers->offer)) {
             return response()->json(['error' => 'Could not find <offer> elements within <offers> in XML.'], 400);
        }

        foreach ($shop->offers->offer as $offer) {
            if ($count >= 10) {
                break;
            }

            $categoryId = isset($offer->categoryId) ? (string)$offer->categoryId : null;
            $categoryName = $categoryId && isset($categories[$categoryId]) ? $categories[$categoryId] : 'N/A';

            $productName = 'N/A';
            if (isset($offer->name) && !empty(trim((string)$offer->name))) {
                $productName = trim((string)$offer->name);
            }

            $productUrl = isset($offer->url) ? trim((string)$offer->url) : 'N/A';
            $productPrice = isset($offer->price) ? trim((string)$offer->price) : 'N/A';
            $productDescription = isset($offer->description) ? trim((string)$offer->description) : 'N/A';
            $productCountry = isset($offer->country_of_origin) ? trim((string)$offer->country_of_origin) : 'N/A';

            $productsData[] = [
                $categoryName,
                $productName,
                $productUrl,
                $productPrice,
                $productDescription,
                $productCountry,
            ];
            $count++;
        }

        if (count($productsData) === 0) {
            return response()->json(['message' => 'No product data.'], 200);
        }

        try {
            $stream = fopen('php://temp', 'r+');
            if ($stream === false) {
                 return response()->json(['error' => 'Could not open tmp:// stream.'], 500);
            }

            fputcsv($stream, $headers);
            foreach ($productsData as $row) {
                fputcsv($stream, $row);
            }

            rewind($stream);
            $csvContents = stream_get_contents($stream);
            fclose($stream);

            Storage::put($csvFileName, $csvContents);

        } catch (Exception $e) {
            if (isset($stream) && is_resource($stream)) {
                fclose($stream);
            }

            return response()->json(['error' => 'Error writing to CSV file', 'message' => $e->getMessage()], 500);
        }

        return response()->json([
            'message' => 'The first ' . count($productsData) . ' products written to CSV successfully.',
            'csv_path' => $csvFileName,
        ]);
    }
}
