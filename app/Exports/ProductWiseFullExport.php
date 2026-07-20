<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class ProductWiseFullExport implements FromArray, ShouldAutoSize, WithStyles
{
    public function array(): array
    {
        $output = [];

        $products = Product::whereHas('orderItems')
            ->with(['orderItems.order'])
            ->get();

        foreach ($products as $product) {

            $output[] = ["Product: {$product->product_name}"];
            $output[] = ["Order ID", "Order Date", "Qty", "Price", "Subtotal", "Shipping"];

            $productTotal = 0;
            $shippingTotal = 0;

            foreach ($product->orderItems as $item) {

                $order = $item->order;
                if (!$order) continue;

                // Correct fields based on your OrderDetail table
                $qty = $item->quantity;
                $price = $item->offer_price;
                $subtotal = $qty * $price;

                $shipping = $order->shipping_amount ?? 0;

                $productTotal += $subtotal;
                $shippingTotal += $shipping;

                $output[] = [
                    $order->id,
                    $order->created_at->format('Y-m-d'),
                    $qty,
                    $price,
                    $subtotal,
                    $shipping,
                ];
            }

            $output[] = ["Product Total", $productTotal];
            $output[] = ["Shipping Total", $shippingTotal];
            $output[] = ["Grand Total", $productTotal + $shippingTotal];
            $output[] = [""];
        }

        return $output;
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        for ($row = 1; $row <= $highestRow; $row++) {

            $cellValue = $sheet->getCell("A{$row}")->getValue();

            if (is_string($cellValue) && str_contains($cellValue, "Product:")) {
                $sheet->getStyle("A{$row}")->getFont()->setBold(true)->setSize(12);
            }

            if ($cellValue === "Order ID") {
                $sheet->getStyle("A{$row}:E{$row}")->getFont()->setBold(true);
                $sheet->getStyle("A{$row}:E{$row}")->getAlignment()->setHorizontal('center');
            }

            $sheet->getStyle("A{$row}:E{$row}")
                ->getAlignment()
                ->setHorizontal('center');
        }
    }
}
