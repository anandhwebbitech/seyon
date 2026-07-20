<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class OrdersExport implements FromArray, ShouldAutoSize, WithStyles
{
    protected $from;
    protected $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to   = $to;
    }

    public function array(): array
    {
        $data[] = [
            "Order ID", "Invoice No", "Customer", "Mobile No", "State", "Payment Method",
            "Total", "Shipping", "Status", "Category", "Product Name", "Date"
        ];

        $statusText = [
            0 => 'Pending',
            1 => 'Approved',
            2 => 'Cancelled',
        ];

        $orders = Order::whereBetween('created_at', [$this->from, $this->to])->get();

        foreach ($orders as $order) {
            // Get customer details
            $customerName = $order->user->name ?? '-';
            $customerMobile = $order->user->phone ?? '-';
            $customerState = $order->address->stateDetail->name ?? '-';

            // Loop through each product in the order
            foreach ($order->orderDetails as $detail) {
                $productName = $detail->product->product_name ?? '-';
                $categoryName = $detail->product->category->name ?? '-';

                $data[] = [
                    $order->id,
                    $order->payment_order_id ?? '-',
                    $customerName,
                    $customerMobile,
                    $customerState,
                    strtoupper($order->payment_method),
                    $order->total_amount,
                    $order->shipping_cost,
                    $statusText[$order->order_status] ?? 'Unknown',
                    $categoryName,
                    $productName,
                    $order->created_at->format('Y-m-d H:i'),
                ];
            }
        }

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        $sheet->getStyle("A1:G1")->getFont()->setBold(true);
        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal('center');

        $sheet->getStyle("A1:G{$highestRow}")
            ->getAlignment()
            ->setHorizontal('center');

        return [];
    }
}
