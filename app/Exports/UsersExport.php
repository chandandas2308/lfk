<?php

namespace App\Exports;

use App\Models\Delivery;
use App\Models\product;
use App\Models\UserOrder;
use App\Models\UserOrderItem;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements WithCustomValueBinder, WithStyles, FromView, ShouldAutoSize, WithColumnWidths, ToModel, WithHeadingRow, WithMappedCells
{



    public function mapping(): array
    {
        return [
            'name'  => 'G1',
            'email' => 'B2',
        ];
    }

    public function model(array $row)
    {
        return new UserOrderItem([
            'name' => $row['product_name'],
            'email' => $row['email'],
        ]);
    }
    public function columnWidths(): array
    {
        return [
            'A' => 10,

        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [


            // Styling a specific cell by coordinate.
            'A4:E4' => ['font' =>  ['bold' => true], ['size' => 14]],

        ];
    }

    protected $id;
    protected $date;

    function __construct($id, $date)
    {


        $this->id = $id;
        $this->date = $date;
    }

    public function view(): View
    {
        $id = $this->id;
        $date = $this->date;
        $products = product::get();
        $data = Delivery::join('notifications', 'notifications.consolidate_order_no', '=', 'deliveries.order_no')
            ->join('user_orders', 'user_orders.consolidate_order_no', '=', 'notifications.consolidate_order_no')
            ->join('user_order_items', 'user_order_items.consolidate_order_no', '=', 'notifications.consolidate_order_no')
            ->select('notifications.delivery_date as delivery_date_is', 'deliveries.*', 'notifications.payment_mode', 'user_orders.final_price', 'user_orders.name', 'user_orders.mobile_no', 'user_orders.address', 'user_order_items.product_name')
            ->where('deliveries.delivery_man_user_id', $id);
        if (!empty($date)) {
            $data->where('notifications.delivery_date', $date);
        }
        $data->groupBy('notifications.consolidate_order_no');
        $data = $data->get();
        return view('superadmin.reports.deliveryReport', [
            'invoices'  => $data,
            'data'      => $products,
            'driver_id' => $id,
            'date'      => $date
        ]);
    }
}
