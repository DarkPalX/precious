<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use App\Helpers\ListingHelper;


use App\Models\Ecommerce\{
    ProductCategory, DeliveryStatus, SalesPayment, SalesDetail, SalesHeader, CouponSale, Product, Promo, ProductReview
};

use App\Models\User;
use App\Models\UsersSubscription;
use App\Models\CustomerLibrary;

use Auth;
use DB;
use \Carbon\Carbon;


class ReportsController extends Controller
{

    private $pageCount = 500;
    
    public function best_sellers(Request $request)
    {
        $startDate = $request->get('start', false);
        $endDate   = $request->get('end', false);

        $rs = SalesDetail::select('product_id',
                          DB::raw('SUM(qty) as total_quantity'),
                          DB::raw('SUM(net_amount) as total_net_amount'))
                 ->where('qty','<>', 0);

      
        if ($startDate && $endDate) {
            $rs->whereBetween('created_at', [$startDate . " 00:00:00", $endDate . " 23:59:59"]);
        }
        
        $rs = $rs->groupBy('product_id')->get();

        return view('admin.ecommerce.reports.best-sellers',compact('rs', 'startDate', 'endDate'));
    }

    public function sales_list(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate   = $request->get('end_date');
        $customer  = $request->get('customer');
        $product   = $request->get('product');
        $category  = $request->get('category');
        $status    = $request->get('del_status');

        if ($request->ajax() || $request->get('export') === 'csv') {
            $query = SalesDetail::join('ecommerce_sales_headers', 'ecommerce_sales_details.sales_header_id', '=', 'ecommerce_sales_headers.id')
                ->where(function($q) {
                    $q->where('ecommerce_sales_headers.order_source', '<>', 'Android')
                    ->orWhereNull('ecommerce_sales_headers.order_source', '<>', 'iOS')
                    ->orWhereNull('ecommerce_sales_headers.order_source');
                })
                ->where('ecommerce_sales_details.product_category', '<>', 0)
                ->whereNotNull('ecommerce_sales_headers.id')
                ->whereHas('header.user') // Enforces Blade template condition: isset($sale->header->user->id)
                ->with(['header.user', 'product.category', 'header.deliveries'])
                ->select([
                    'ecommerce_sales_details.*',
                    'ecommerce_sales_headers.order_number', 
                    'ecommerce_sales_headers.payment_method',
                    'ecommerce_sales_headers.created_at as header_created_at',
                    'ecommerce_sales_headers.delivery_status',
                    'ecommerce_sales_headers.customer_delivery_adress'
                ]);

            // Filters applied directly to server-side dataset execution
            if ($customer) {
                $query->where('ecommerce_sales_headers.customer_name', $customer);
            }
            if ($product) {
                $query->where('ecommerce_sales_details.product_name', $product);
            }
            if ($category) {
                $query->where('ecommerce_sales_details.product_category', $category);
            }
            if ($status) {
                $query->where('ecommerce_sales_headers.delivery_status', $status);
            }
            if ($startDate && $endDate) {
                $query->whereBetween('ecommerce_sales_headers.created_at', [
                    $startDate . " 00:00:00", 
                    $endDate . " 23:59:59"
                ]);
            }

            return datatables()->of($query)
                ->addColumn('date', function($sale) {
                    return \SettingHelper::datetimeFormat2($sale->header_created_at);
                })
                ->addColumn('order_number', function($sale) {
                    // If order_number is already a string like "INV-001", just return it. 
                    // If it's a numeric ID that needs padding, keep the str_pad.
                    return is_numeric($sale->order_number) 
                        ? str_pad($sale->order_number, 8, '0', STR_PAD_LEFT) 
                        : ($sale->order_number ?? $sale->header->order_number ?? '');
                })
                ->addColumn('customer_no', function($sale) {
                    return str_pad(($sale->header->user->id ?? 0), 8, '0', STR_PAD_LEFT);
                })
                ->addColumn('client_name', function($sale) {
                    return $sale->header->customer_name ?? '';
                })
                ->addColumn('category_name', function($sale) {
                    return $sale->product->category->name ?? 'Uncategorized';
                })
                ->addColumn('gross', function($sale) {
                    return number_format($sale->price * $sale->qty, 2);
                })
                ->addColumn('discount', function($sale) {
                    return number_format($sale->discount_amount, 2);
                })
                ->addColumn('net_price', function($sale) {
                    return number_format(($sale->price * $sale->qty) - $sale->discount_amount, 2);
                })
                ->addColumn('price_formatted', function($sale) {
                    return number_format($sale->price, 2);
                })
                ->addColumn('payment_method', function($sale) {
                    // Explicitly ensuring it is returned from either details or header table
                    return $sale->payment_method ?? $sale->header->payment_method ?? '';
                })
                ->addColumn('status_display', function($sale) {
                    if (in_array(strtolower($sale->product->book_type ?? ''), ['ebook', 'e-book'])) {
                        return 'Delivered';
                    }
                    if ($sale->cancellation_request == 1) {
                        return $sale->delivery_status . ' | ' . $sale->cancellation_reason . ' : ' . $sale->cancellation_remarks;
                    }
                    $lastDelivery = optional($sale->header->deliveries->last());
                    return $lastDelivery && $lastDelivery->remarks != '' 
                        ? $sale->delivery_status . ' | ' . $lastDelivery->remarks 
                        : $sale->delivery_status;
                })
                ->rawColumns(['status_display'])
                ->make(true);
        }

        return view('admin.ecommerce.reports.sales-transaction', compact(
            'startDate', 'endDate', 'customer', 'product', 'category', 'status'
        ));
    }

    // public function sales_list(Request $request)
    // {
    //     $sales = SalesDetail::join('ecommerce_sales_headers', 'ecommerce_sales_details.sales_header_id', '=', 'ecommerce_sales_headers.id')
    //         ->where(function($query) {
    //             $query->where('order_source', '<>', 'Android')
    //                 ->orWhereNull('order_source');
    //         })
    //         ->where('product_category', '<>', 0)
    //         ->whereNotNull('ecommerce_sales_headers.id');

    //     $startDate = $request->get('start');
    //     $endDate   = $request->get('end');
    //     $customer  = $request->get('customer');
    //     $product   = $request->get('product');
    //     $category  = $request->get('category');
    //     $status    = $request->get('del_status');

    //     if ($customer) {
    //         $sales->where('ecommerce_sales_headers.customer_name', $customer);
    //     }

    //     if ($product) {
    //         $sales->where('ecommerce_sales_details.product_name', $product);
    //     }

    //     if ($category) {
    //         $sales->where('ecommerce_sales_details.product_category', $category);
    //     }

    //     if ($status) {
    //         $sales->where('ecommerce_sales_headers.delivery_status', $status);
    //     }

    //     // Date Filter Fix: Ensure dates exist before applying
    //     if ($startDate && $endDate) {
    //         $sales->whereBetween('ecommerce_sales_headers.created_at', [
    //             $startDate . " 00:00:00", 
    //             $endDate . " 23:59:59"
    //         ]);
    //     }

    //     $sales = $sales->orderBy('ecommerce_sales_headers.created_at', 'desc')
    //                 ->paginate($this->pageCount);

    //     return view('admin.ecommerce.reports.sales-transaction', compact(
    //         'sales', 'startDate', 'endDate', 'customer', 'product', 'category', 'status'
    //     ));
    // }

    public function top_buyers(Request $request)
    {       
        $startDate = $request->get('start', false);
        $endDate   = $request->get('end', false);

        $rs = SalesHeader::select('user_id', 
                         DB::raw('SUM(net_amount) as total_net_amount'), 
                         DB::raw('COUNT(*) as order_count'))
                 ->where('status', 'active')
                 ->where('order_source', '<>', 'Android')
                 ->orWhereNull('order_source');
      
        if ($startDate && $endDate) {
            $rs->whereBetween('created_at', [$startDate . " 00:00:00", $endDate . " 23:59:59"]);
        }
        
        $rs = $rs->groupBy('user_id')->get();

        return view('admin.ecommerce.reports.top-buyers',compact('rs', 'startDate', 'endDate'));

    }
    
    public function top_products(Request $request)
    {
        $startDate = $request->get('start', false);
        $endDate   = $request->get('end', false);

        $rs = ProductReview::select('product_id',
                            DB::raw('AVG(rating) as average_rating'), 
                            DB::raw('COUNT(*) as review_count'));
      
        if ($startDate && $endDate) {
            $rs->whereBetween('created_at', [$startDate . " 00:00:00", $endDate . " 23:59:59"]);
        }
        
        $rs = $rs->groupBy('product_id')->get();

        return view('admin.ecommerce.reports.top-products',compact('rs', 'startDate', 'endDate'));
    }

    public function product_list(Request $request)
    {
        $rs = Product::all();        

        return view('admin.ecommerce.reports.product-list',compact('rs'));

    }

    public function customer_list(Request $request)
    {
        $startDate = $request->get('start_date', $request->get('start'));
        $endDate = $request->get('end_date', $request->get('end'));
        $platform = strtolower(trim((string) $request->get('platform', '')));

        $query = User::where('role_id', 6)
            ->where('is_active', 1)
            ->select([
                'id', 'firstname', 'lastname', 'email', 'mobile', 'phone',
                'address_street', 'address_municipality',
                'address_city', 'address_zip', 'email_verified_at',
                'verification_code'
            ])
            ->when($startDate, function ($query) use ($startDate) {
                $query->where('email_verified_at', '>=', $startDate . ' 00:00:00');
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->where('email_verified_at', '<=', $endDate . ' 23:59:59');
            })
            ->when($platform === 'web', function ($query) {
                $query->whereNull('verification_code');
            })
            ->when($platform === 'mobile', function ($query) {
                $query->whereNotNull('verification_code');
            })
            ->orderByDesc('email_verified_at');

        $export = $request->get('export');
        if ($export === 'csv') {
            return response()->streamDownload(function () use ($query) {
                @set_time_limit(0);
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['Name', 'Email', 'Mobile', 'Address', 'Account Created', 'Platform']);

                foreach ($query->cursor() as $customer) {
                    fputcsv($handle, $this->customerExportRow($customer));
                }

                fclose($handle);
            }, 'customers-list.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
        }

        // Do not send all rows to DataTables for file exports. Production servers
        // commonly hit PHP/proxy limits when 49k rows are returned as one JSON body.
        if ($export === 'excel') {
            return $this->streamCustomerExcel($query);
        }

        if ($export === 'pdf') {
            return $this->streamCustomerPdf($query);
        }

        if ($request->ajax()) {

            return datatables()->of($query)
                ->addColumn('customer_name', function ($customer) {
                    return trim($customer->firstname . ' ' . $customer->lastname);
                })
                ->addColumn('address', function ($customer) {
                    return implode(', ', array_filter([
                        $customer->address_street,
                        $customer->address_municipality,
                        $customer->address_city,
                        $customer->address_zip,
                    ]));
                })
                ->addColumn('account_created', function ($customer) {
                    return optional($customer->email_verified_at)->format('Y-m-d H:i');
                })
                ->addColumn('platform', function ($customer) {
                    return is_null($customer->verification_code) ? 'Web' : 'Mobile';
                })
                ->make(true);
        }

        return view('admin.ecommerce.reports.customer-list', compact(
            'startDate', 'endDate', 'platform'
        ));

    }

    private function customerExportRow($customer)
    {
        return [
            trim($customer->firstname . ' ' . $customer->lastname),
            $customer->email,
            $customer->mobile,
            trim(implode(', ', array_filter([
                $customer->address_street,
                $customer->address_municipality,
                $customer->address_city,
                $customer->address_zip,
            ]))),
            optional($customer->email_verified_at)->format('Y-m-d H:i'),
            is_null($customer->verification_code) ? 'Web' : 'Mobile',
        ];
    }

    private function streamCustomerExcel($query)
    {
        return response()->streamDownload(function () use ($query) {
            @set_time_limit(0);
            // Excel opens this streamed HTML workbook as an .xls file. It keeps
            // memory usage constant and does not require PhpSpreadsheet.
            echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><style>td,th{border:1px solid #ccc;padding:4px;}th{font-weight:bold;background:#eee;}</style></head><body><table>';
            echo '<tr><th>Name</th><th>Email</th><th>Mobile</th><th>Address</th><th>Account Created</th><th>Platform</th></tr>';
            foreach ($query->cursor() as $customer) {
                echo '<tr>';
                foreach ($this->customerExportRow($customer) as $value) {
                    echo '<td>' . e($value) . '</td>';
                }
                echo '</tr>';
            }
            echo '</table></body></html>';
        }, 'customers-list.xls', ['Content-Type' => 'application/vnd.ms-excel; charset=UTF-8']);
    }

    private function streamCustomerPdf($query)
    {
        return response()->streamDownload(function () use ($query) {
            @set_time_limit(0);
            $file = tempnam(sys_get_temp_dir(), 'customer-report-');
            $handle = fopen($file, 'w+b');
            $offsets = [0];
            fwrite($handle, "%PDF-1.4\n%\xE2\xE3\xCF\xD3\n");

            $writeObject = function ($number, $body) use ($handle, &$offsets) {
                $offsets[$number] = ftell($handle);
                fwrite($handle, $number . " 0 obj\n" . $body . "\nendobj\n");
            };

            // Object 1 points to the pages object, which is written after all
            // streamed pages have been discovered.
            $writeObject(1, '<< /Type /Catalog /Pages 2 0 R >>');
            $pageReferences = [];
            $pageNumber = 0;
            $rows = [];
            $writePage = function ($pageRows) use (&$pageNumber, &$pageReferences, $writeObject) {
                $pageNumber++;
                $pageObject = 4 + (($pageNumber - 1) * 2);
                $contentObject = $pageObject + 1;
                $pageReferences[] = $pageObject . ' 0 R';

                // Landscape Legal table: fixed widths keep every page aligned,
                // while clipping long values prevents cells from overflowing.
                $x = 24;
                $top = 588;
                $headerHeight = 18;
                $rowHeight = 12;
                $widths = [150, 190, 90, 300, 140, 90];
                $headers = ['Name', 'Email', 'Mobile', 'Address', 'Account Created', 'Platform'];
                $content = "0.75 w\n";
                $content .= "0.92 0.92 0.92 rg\n" . $x . ' ' . ($top - $headerHeight) . ' 960 ' . $headerHeight . " re f\n";
                // Reset both stroke and fill colors after the gray header fill;
                // otherwise all cell text inherits the light-gray fill color.
                $content .= "0 0 0 RG\n0 0 0 rg\n";

                $verticals = [$x];
                foreach ($widths as $width) {
                    $x += $width;
                    $verticals[] = $x;
                }
                foreach ($verticals as $vertical) {
                    $content .= $vertical . ' ' . ($top - $headerHeight - (count($pageRows) * $rowHeight)) . ' m ' . $vertical . ' ' . $top . " l S\n";
                }
                for ($line = 0; $line <= count($pageRows) + 1; $line++) {
                    $y = $top - ($line === 0 ? 0 : ($line === 1 ? $headerHeight : $headerHeight + (($line - 1) * $rowHeight)));
                    $content .= '24 ' . $y . ' m 984 ' . $y . " l S\n";
                }

                $drawCellText = function ($text, $cellX, $baseline, $cellWidth) {
                    $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', (string) $text);
                    $maxCharacters = max(1, floor(($cellWidth - 6) / 3.6));
                    if (strlen($text) > $maxCharacters) {
                        $text = substr($text, 0, max(1, $maxCharacters - 3)) . '...';
                    }
                    $text = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
                    return "BT\n/F1 6 Tf\n" . ($cellX + 3) . ' ' . $baseline . " Td\n(" . $text . ") Tj\nET\n";
                };

                $cellX = 24;
                foreach ($headers as $index => $header) {
                    $content .= $drawCellText($header, $cellX, $top - 13, $widths[$index]);
                    $cellX += $widths[$index];
                }
                foreach ($pageRows as $rowIndex => $row) {
                    $cellX = 24;
                    $baseline = $top - $headerHeight - ($rowIndex * $rowHeight) - 9;
                    foreach ($row as $columnIndex => $value) {
                        $content .= $drawCellText($value, $cellX, $baseline, $widths[$columnIndex]);
                        $cellX += $widths[$columnIndex];
                    }
                }
                $writeObject($contentObject, '<< /Length ' . strlen($content) . " >>\nstream\n" . $content . 'endstream');
                $writeObject($pageObject, '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 1008 612] /Resources << /Font << /F1 3 0 R >> >> /Contents ' . $contentObject . ' 0 R >>');
            };

            foreach ($query->cursor() as $customer) {
                $rows[] = $this->customerExportRow($customer);
                if (count($rows) === 45) {
                    $writePage($rows);
                    $rows = [];
                }
            }
            if ($rows || !$pageNumber) {
                $writePage($rows);
            }
            $writeObject(3, '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>');
            $writeObject(2, '<< /Type /Pages /Kids [' . implode(' ', $pageReferences) . '] /Count ' . count($pageReferences) . ' >>');

            $xref = ftell($handle);
            $maxObject = max(array_keys($offsets));
            fwrite($handle, "xref\n0 " . ($maxObject + 1) . "\n0000000000 65535 f \n");
            for ($i = 1; $i <= $maxObject; $i++) {
                fwrite($handle, sprintf("%010d 00000 n \n", $offsets[$i]));
            }
            fwrite($handle, "trailer\n<< /Size " . ($maxObject + 1) . " /Root 1 0 R >>\nstartxref\n" . $xref . "\n%%EOF");
            fflush($handle);
            rewind($handle);
            while (!feof($handle)) {
                echo fread($handle, 1024 * 1024);
            }
            fclose($handle);
            @unlink($file);
        }, 'customers-list.pdf', ['Content-Type' => 'application/pdf']);
    }

    // public function customer_list(Request $request)
    // {
        
    //     $rs = User::where('role_id','6')->get();

    //     return view('admin.ecommerce.reports.customer-list',compact('rs'));

    // }

    public function inventory_reorder_point(Request $request)
    {
        
        $rs = Product::where('reorder_point','>',0)->get();
        

        return view('admin.ecommerce.reports.inventory.inventory_reorder_point',compact('rs'));

    }

    public function inventory_list(Request $request)
    {
        
        $rs = Product::all();
        

        return view('admin.ecommerce.reports.inventory.list',compact('rs'));

    }

    public function sales_summary(Request $request)
    {
        
        $qry = "SELECT *,created_at as hcreated,id as hid FROM ecommerce_sales_headers where status<>'CANCELLED' and delivery_status<>'CANCELLED'";

       
        if(isset($_GET['customer']) && $_GET['customer']<>''){
            $qry.= " and customer_name='".$_GET['customer']."'";
        }
        if(isset($_GET['delivery_status']) && $_GET['delivery_status']<>''){
            $qry.= " and delivery_status='".$_GET['delivery_status']."'";
        }    
      
       

        if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
            $qry.= " and created_at >='".$_GET['startdate']." 00:00:00.000' and created_at <='".$_GET['enddate']." 23:59:59.999'";
        }
        //dd($qry);

        $rs = DB::select($qry);

        return view('admin.reports.sales.summary',compact('rs'));

    }

    public function sales_payments(Request $request)
    {
        $qry = "SELECT h.*,d.*,h.created_at as hcreated           
                    FROM `ecommerce_sales_payments` d 
                    left join ecommerce_sales_headers h on h.id=d.sales_header_id 
                    where h.payment_status='PAID'
                     ";
        if(isset($_GET['start']) && strlen($_GET['start'])>=1){
            $qry.= " and d.payment_date >='".$_GET['start']."' and d.payment_date <='".$_GET['end']."'";
        }
            $rs = DB::select($qry);
    

        return view('admin.reports.sales.payment',compact('rs'));

    }


    public function delivery_report($id)
    {
        $rs = SalesHeader::whereId((int) $id)->first();
        
        return view('admin.ecommerce.reports.delivery_report',compact('rs'));

    }
    public function delivery_status(Request $request)
    {
        $rs = '';
       // if(isset($_GET['act'])){

            $rs = DB::select("SELECT h.*,d.*,h.created_at as hcreated           
                    FROM `ecommerce_sales_details` d 
                    left join ecommerce_sales_headers h on h.id=d.sales_header_id 
                    where h.payment_status='PAID'
                     ");

        //}

        return view('admin.reports.delivery_status',compact('rs'));

    }

    public function coupon_list(Request $request)
    {
        $qry = "SELECT h.*,c.*, cs.coupon_code, cs.customer_id FROM `coupon_sales` cs 
            left join ecommerce_sales_headers h on h.id = cs.sales_header_id 
            left join coupons c on c.id = cs.coupon_id
            where cs.id > 0";

       
        // if(isset($_GET['coupon_code']) && $_GET['coupon_code']<>''){
        //     $qry.= " and cs.coupon_code = '".$_GET['coupon_code']."' ";
        // }
        
        if(isset($_GET['coupon_code']) && $_GET['coupon_code']<>''){
            $qry.= " and cs.coupon_code = '".$_GET['coupon_code']."' and cs.order_status = 'PAID' ";
        }

        if(isset($_GET['customer']) && strlen($_GET['customer'])>=1){
            $qry.= " and cs.customer_id = '".$_GET['customer']."' ";
        }

        if(isset($_GET['start']) && strlen($_GET['start'])>=1){
            $qry.= " and h.created_at >='".$_GET['start']."' and h.created_at <='".$_GET['end']."'";
        }
   
      
        $rs = DB::select($qry);

        return view('admin.ecommerce.reports.coupon.list',compact('rs'));
    }

    // public function coupon_list(Request $request)
    // {
    //     $qry = "SELECT h.*,c.*, cs.coupon_code, cs.customer_id FROM `coupon_sales` cs 
    //         left join ecommerce_sales_headers h on h.id = cs.sales_header_id 
    //         left join coupons c on c.id = cs.coupon_id
    //         where cs.id > 0";

       
    //     if(isset($_GET['coupon_code']) && $_GET['coupon_code']<>''){
    //         $qry.= " and cs.coupon_code = '".$_GET['coupon_code']."' ";
    //     }

    //     if(isset($_GET['customer']) && strlen($_GET['customer'])>=1){
    //         $qry.= " and cs.customer_id = '".$_GET['customer']."' ";
    //     }

    //     if(isset($_GET['start']) && strlen($_GET['start'])>=1){
    //         $qry.= " and h.created_at >='".$_GET['start']."' and h.created_at <='".$_GET['end']."'";
    //     }
   
      
    //     $rs = DB::select($qry);

    //     return view('admin.ecommerce.reports.coupon.list',compact('rs'));
    // }

    public function promo_list(Request $request)
    {
        $promos = Promo::whereNotNull('id');

        $startDate = $request->get('start', false);
        $endDate   = $request->get('end', false);

        if(isset($startDate) && strlen($startDate) >= 1){
            $promos->whereBetween('promo_start',[$startDate." 00:00:00.000", $endDate." 23:59:59.999"]);  
        }

        $promos = $promos->orderBy('promo_start', 'asc')->get();

        return view('admin.ecommerce.reports.promo-list', compact('promos', 'startDate', 'endDate'));
    }

    public function payment_list(Request $request)
    {
        $payments = SalesPayment::whereNotNull('id');

        $startDate = $request->get('start', false);
        $endDate   = $request->get('end', false);

        if(isset($startDate) && strlen($startDate) >= 1){
            $payments->whereBetween('payment_date', [$startDate." 00:00:00.000", $endDate." 23:59:59.999"]);  
        }

        $payments = $payments->orderBy('created_at', 'desc')->get();

        return view('admin.ecommerce.reports.payment-list', compact('payments', 'startDate', 'endDate'));
    }


    

    // FOR MOBILE REPORTS
    
    public function best_sellers_mobile(Request $request)
    {
        $startDate = $request->get('start', false);
        $endDate   = $request->get('end', false);

        $rs = SalesDetail::select('product_id',
                          DB::raw('SUM(CASE WHEN qty = 0 THEN 1 ELSE qty END) as total_quantity'),
                          DB::raw('SUM(net_amount) as total_net_amount'))
                 ->where('qty', 0);

      
        if ($startDate && $endDate) {
            $rs->whereBetween('created_at', [$startDate . " 00:00:00", $endDate . " 23:59:59"]);
        }
        
        $rs = $rs->groupBy('product_id')->get();

        return view('admin.ecommerce.reports-mobile.best-sellers',compact('rs', 'startDate', 'endDate'));

    }

    public function sales_list_mobile(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate   = $request->get('end_date');
        $customer  = $request->get('customer');
        $product   = $request->get('product');
        $category  = $request->get('category');
        $status    = $request->get('del_status');

        if ($request->ajax()) {
            $query = SalesDetail::join('ecommerce_sales_headers', 'ecommerce_sales_details.sales_header_id', '=', 'ecommerce_sales_headers.id')
                ->where(function($q) {
                    // FIXED: Replaced the broken orWhereNull syntax with clean logical matching conditions
                    $q->where('ecommerce_sales_headers.order_source', 'Android')
                    ->orWhere('ecommerce_sales_headers.order_source', 'iOS');
                })
                // ->where('ecommerce_sales_details.product_category', '<>', 0) // Safely removed
                ->whereNotNull('ecommerce_sales_headers.id')
                ->whereHas('header.user') 
                ->with(['header.user', 'product.category', 'header.deliveries'])
                ->select([
                    'ecommerce_sales_details.*',
                    'ecommerce_sales_headers.order_number', 
                    'ecommerce_sales_headers.payment_method',
                    'ecommerce_sales_headers.created_at as header_created_at',
                    'ecommerce_sales_headers.delivery_status',
                    'ecommerce_sales_headers.customer_delivery_adress'
                ]);

            // Filters applied directly to server-side dataset execution
            if ($customer) {
                $query->where('ecommerce_sales_headers.customer_name', $customer);
            }
            if ($product) {
                $query->where('ecommerce_sales_details.product_name', $product);
            }
            if ($category) {
                $query->where('ecommerce_sales_details.product_category', $category);
            }
            if ($status) {
                $query->where('ecommerce_sales_headers.delivery_status', $status);
            }
            if ($startDate && $endDate) {
                $query->whereBetween('ecommerce_sales_headers.created_at', [
                    $startDate . " 00:00:00", 
                    $endDate . " 23:59:59"
                ]);
            }

            return datatables()->of($query)
                ->editColumn('qty', function($sale) {
                    // Ebook transactions must display and export at least one item.
                    return max(1, (int) $sale->qty);
                })
                ->addColumn('date', function($sale) {
                    return \SettingHelper::datetimeFormat2($sale->header_created_at);
                })
                ->addColumn('order_number', function($sale) {
                    return is_numeric($sale->order_number) 
                        ? str_pad($sale->order_number, 8, '0', STR_PAD_LEFT) 
                        : ($sale->order_number ?? $sale->header->order_number ?? '');
                })
                ->addColumn('customer_no', function($sale) {
                    return str_pad(($sale->header->user->id ?? 0), 8, '0', STR_PAD_LEFT);
                })
                ->addColumn('client_name', function($sale) {
                    return $sale->header->customer_name ?? '';
                })
                ->addColumn('category_name', function($sale) {
                    // FIXED: Added null-safe navigation to handle instances where product or category is null/0
                    return $sale->product->category->name ?? 'Uncategorized';
                })
                ->addColumn('gross', function($sale) {
                    return number_format($sale->price * $sale->qty, 2);
                })
                ->addColumn('discount', function($sale) {
                    return number_format($sale->discount_amount, 2);
                })
                ->addColumn('net_price', function($sale) {
                    return number_format(($sale->price * $sale->qty) - $sale->discount_amount, 2);
                })
                ->addColumn('price_formatted', function($sale) {
                    return number_format($sale->price, 2);
                })
                ->addColumn('payment_method', function($sale) {
                    return $sale->payment_method ?? $sale->header->payment_method ?? '';
                })
                ->addColumn('status_display', function($sale) {
                    if (in_array(strtolower($sale->product->book_type ?? ''), ['ebook', 'e-book'])) {
                        return 'Delivered';
                    }
                    if ($sale->cancellation_request == 1) {
                        return $sale->delivery_status . ' | ' . $sale->cancellation_reason . ' : ' . $sale->cancellation_remarks;
                    }
                    $lastDelivery = optional($sale->header->deliveries->last());
                    return $lastDelivery && $lastDelivery->remarks != '' 
                        ? $sale->delivery_status . ' | ' . $lastDelivery->remarks 
                        : $sale->delivery_status;
                })
                ->rawColumns(['status_display'])
                ->make(true);
        }

        return view('admin.ecommerce.reports-mobile.sales-transaction', compact(
            'startDate', 'endDate', 'customer', 'product', 'category', 'status'
        ));
    }

    // public function sales_list_mobile(Request $request)
    // {
    //     $sales = SalesDetail::join('ecommerce_sales_headers', 'ecommerce_sales_details.sales_header_id', 'ecommerce_sales_headers.id')
    //     // Grouping the source logic ensures it doesn't "leak" into the date filter
    //     ->where(function($query) {
    //         $query->where('order_source', '<>', 'Android')
    //             ->orWhereNull('order_source');
    //     })
    //     ->whereNotNull('ecommerce_sales_headers.id');


    //     // 1. Start the query with grouped OR logic
    //     // $sales = SalesDetail::join('ecommerce_sales_headers', 'ecommerce_sales_details.sales_header_id', '=', 'ecommerce_sales_headers.id')
    //     //     ->where(function($query) {
    //     //         $query->where('order_source', '<>', 'Android')
    //     //             ->orWhereNull('order_source');
    //     //     })
    //     //     ->whereNotNull('ecommerce_sales_headers.id');

    //     // 2. Capture inputs (using null as default for cleaner checks)
    //     $startDate = $request->input('start');
    //     $endDate   = $request->input('end');
    //     $customer  = $request->input('customer');
    //     $product   = $request->input('product');
    //     $category  = $request->input('category');
    //     $status    = $request->input('del_status');

    //     // 3. Apply Filters conditionally
    //     if ($customer) {
    //         $sales->where('ecommerce_sales_headers.customer_name', $customer);
    //     }

    //     if ($product) {
    //         $sales->where('ecommerce_sales_details.product_name', $product);
    //     }

    //     if ($category) {
    //         $sales->where('ecommerce_sales_details.product_category', $category);
    //     }

    //     if ($status) {
    //         $sales->where('ecommerce_sales_headers.delivery_status', $status);
    //     }
    
    //     // 4. Date Filter - Now applies to the results of the group above
    //     if ($startDate && $endDate) {
    //         $sales->whereBetween('ecommerce_sales_headers.created_at', [
    //             $startDate . " 00:00:00", 
    //             $endDate . " 23:59:59"
    //         ]);  
    //     }

    //     // 5. Finalize
    //     $sales = $sales->orderBy('ecommerce_sales_headers.created_at', 'desc')
    //                 ->paginate($this->pageCount);

    //     return view('admin.ecommerce.reports-mobile.sales-transaction', compact(
    //         'sales', 'startDate', 'endDate', 'customer', 'product', 'category', 'status'
    //     ));
    // }

    // public function sales_list_mobile(Request $request)
    // {
    //     $sales = SalesDetail::join('ecommerce_sales_headers', 'ecommerce_sales_details.sales_header_id', 'ecommerce_sales_headers.id')
    //         ->where('order_source', '<>', 'Android')
    //         ->orWhereNull('order_source')
    //         ->whereNotNull('ecommerce_sales_headers.id');


    //     $startDate = $request->get('start', false);
    //     $endDate   = $request->get('end', false);
    //     $customer  = $request->get('customer', false);
    //     $product   = $request->get('product', false);
    //     $category   = $request->get('category', false);
    //     $status    = $request->get('del_status', false);


    //     if(isset($customer) && $customer <> ''){
    //         $sales->where('ecommerce_sales_headers.customer_name', $customer);
    //     }

    //     if(isset($product) && $product <> ''){
    //         $sales->where('ecommerce_sales_details.product_name', $product);
    //     }

    //     if(isset($category) && $category <> ''){
    //         $sales->where('ecommerce_sales_details.product_category', $category);
    //     }

    //     if(isset($status) && $status <> ''){
    //         $sales->where('ecommerce_sales_headers.delivery_status', $status);
    //     }
      
    //     if(isset($startDate) && strlen($startDate)>=1){
    //         $sales->whereBetween('ecommerce_sales_headers.created_at',[$startDate." 00:00:00.000", $endDate." 23:59:59.999"]);  
    //     }

    //     $sales = $sales->orderBy('ecommerce_sales_headers.created_at', 'desc')->paginate($this->pageCount);

    //     return view('admin.ecommerce.reports-mobile.sales-transaction',compact('sales', 'startDate', 'endDate', 'customer', 'product', 'category', 'status'));

    // }

    // public function sales_list_mobile(Request $request)
    // {
    //     $sales = SalesDetail::join('ecommerce_sales_headers', 'ecommerce_sales_details.sales_header_id', 'ecommerce_sales_headers.id')
    //         ->where('order_source', 'Android')
    //         ->whereNotNull('ecommerce_sales_headers.id');


    //     $startDate = $request->get('start', false);
    //     $endDate   = $request->get('end', false);
    //     $customer  = $request->get('customer', false);
    //     $product   = $request->get('product', false);
    //     $category   = $request->get('category', false);
    //     $status    = $request->get('del_status', false);


    //     if(isset($customer) && $customer <> ''){
    //         $sales->where('ecommerce_sales_headers.customer_name', $customer);
    //     }

    //     if(isset($product) && $product <> ''){
    //         $sales->where('ecommerce_sales_details.product_name', $product);
    //     }

    //     if(isset($category) && $category <> ''){
    //         $sales->where('ecommerce_sales_details.product_category', $category);
    //     }

    //     if(isset($status) && $status <> ''){
    //         $sales->where('ecommerce_sales_headers.delivery_status', $status);
    //     }
      
    //     if(isset($startDate) && strlen($startDate)>=1){
    //         $sales->whereBetween('ecommerce_sales_headers.created_at',[$startDate." 00:00:00.000", $endDate." 23:59:59.999"]);  
    //     }

    //     $sales = $sales->orderBy('ecommerce_sales_headers.created_at', 'desc')->paginate($this->pageCount);

    //     return view('admin.ecommerce.reports-mobile.sales-transaction',compact('sales', 'startDate', 'endDate', 'customer', 'product', 'category', 'status'));

    // }
    
    public function top_buyers_mobile(Request $request)
    {       
        
        $startDate = $request->get('start', false);
        $endDate   = $request->get('end', false);

        $rs = SalesHeader::select('user_id', 'customer_name',
                         DB::raw('SUM(net_amount) as total_net_amount'), 
                         DB::raw('COUNT(*) as order_count'))
                 ->where('status', 'active')
                 ->where('order_source', 'Android');
      
        if ($startDate && $endDate) {
            $rs->whereBetween('created_at', [$startDate . " 00:00:00", $endDate . " 23:59:59"]);
        }
        
        $rs = $rs->groupBy('user_id', 'customer_name')->get();

        return view('admin.ecommerce.reports-mobile.top-buyers',compact('rs','startDate','endDate'));
    }
    
    public function top_products_mobile(Request $request)
    {
        $startDate = $request->get('start', false);
        $endDate   = $request->get('end', false);

        $rs = ProductReview::select('product_id',
                            DB::raw('AVG(rating) as average_rating'), 
                            DB::raw('COUNT(*) as review_count'));
      
        if ($startDate && $endDate) {
            $rs->whereBetween('created_at', [$startDate . " 00:00:00", $endDate . " 23:59:59"]);
        }
        
        $rs = $rs->groupBy('product_id')->get();

        return view('admin.ecommerce.reports-mobile.top-products',compact('rs','startDate','endDate'));
    }

    public function subscribers_mobile(Request $request)
    {

        $rs = UsersSubscription::all();
        // $userIds = $subscribers->pluck('user_id');

        
        // $rs = User::whereIn('id', $userIds)->where('role_id', '6')->get();
        
        // $rs = UsersSubscription::leftJoin('users', 'users.id', '=', 'users_subscriptions.user_id')
        // ->select('users_subscriptions.*', 'users_subscriptions.user_id', 'users.*') // Adjust fields as needed
        // ->get();


        // dd($rs);

        return view('admin.ecommerce.reports-mobile.subscribers',compact('rs'));

    }
    
    public function downloads(Request $request)
    {
        $startDate = $request->get('start', false);
        $endDate   = $request->get('end', false);

        $rs = Product::query()
            ->whereNotNull('name')
            ->whereRaw("TRIM(name) <> ''");
      
        if ($startDate && $endDate) {
            $rs->whereBetween('created_at', [$startDate . " 00:00:00", $endDate . " 23:59:59"]);
        }
        
        $rs = $rs->get();

        return view('admin.ecommerce.reports-mobile.downloads',compact('rs', 'startDate', 'endDate'));

    }
    
    public function customer_downloads(Request $request, $product_id)
    {
        $product = Product::withTrashed()->find($product_id);
        $rs = CustomerLibrary::where('product_id', $product_id)->get();

        return view('admin.ecommerce.reports-mobile.customer-downloads',compact('rs', 'product'));

    }

    public function read_counts(Request $request)
    {
        // Keep date filters separate from DataTables' reserved `start` offset.
        $startDate = $request->get('start_date', $request->get('start', false));
        $endDate   = $request->get('end_date', $request->get('end', false));

        if ($request->ajax() || $request->get('export') === 'csv') {

            // $query = Product::query()
            //     ->select('products.sku', 'products.name', 'products.author')
            //     ->selectRaw('COALESCE(SUM(readcount_details.read_count), 0) as read_count')
            //     ->leftJoin('readcount_details', function ($join) use ($startDate, $endDate) {
            //         $join->on('products.id', '=', 'readcount_details.product_id')
            //             ->whereNull('readcount_details.deleted_at');

            //         // Apply date range filter to readcount_details creation date
            //         if ($startDate && $endDate) {
            //             $join->whereBetween('readcount_details.created_at', [
            //                 $startDate . ' 00:00:00',
            //                 $endDate . ' 23:59:59'
            //             ]);
            //         }
            //     })
            //     ->where('products.sku', '<>', '')
            //     ->groupBy('products.id', 'products.sku', 'products.name', 'products.author');


                
            // When no date range is provided, include product.old_read_count in the total.
            // When a date range is provided, only sum the readcount_details within that range.
            if ($startDate && $endDate) {
                $readCountSelect = 'COALESCE(SUM(readcount_details.read_count), 0) as read_count';
                $havingCondition = 'COALESCE(SUM(readcount_details.read_count), 0) > 0';
            } else {
                // The join produces one row per read-count detail, so aggregate the
                // product-level historical count as well. This keeps the query valid
                // with MySQL's ONLY_FULL_GROUP_BY mode enabled.
                $readCountSelect = 'COALESCE(SUM(readcount_details.read_count), 0) + COALESCE(MAX(products.old_read_count), 0) as read_count';
                $havingCondition = 'COALESCE(SUM(readcount_details.read_count), 0) + COALESCE(MAX(products.old_read_count), 0) > 0';
            }

            $query = Product::query()
                ->select('products.sku', 'products.name', 'products.author')
                ->selectRaw($readCountSelect)
                ->leftJoin('readcount_details', function ($join) use ($startDate, $endDate) {
                    $join->on('products.id', '=', 'readcount_details.product_id')
                        ->whereNull('readcount_details.deleted_at');

                    // Apply date range filter to readcount_details creation date
                    if ($startDate && $endDate) {
                        $join->whereBetween('readcount_details.created_at', [
                            $startDate . ' 00:00:00',
                            $endDate . ' 23:59:59'
                        ]);
                    }
                })
                // Only include ebook product types (case-insensitive, accepts e-book, EBook, etc.)
                ->whereRaw("LOWER(REPLACE(products.book_type, '-', '')) = 'ebook'")
                ->where('products.sku', '<>', '')
                ->groupBy('products.id', 'products.sku', 'products.name', 'products.author');

            // $query = Product::query()
            //     ->select('products.sku', 'products.name', 'products.author')
            //     ->selectRaw($readCountSelect)
            //     ->leftJoin('readcount_details', function ($join) use ($startDate, $endDate) {
            //         $join->on('products.id', '=', 'readcount_details.product_id')
            //             ->whereNull('readcount_details.deleted_at');

            //         if ($startDate && $endDate) {
            //             $join->whereBetween('readcount_details.created_at', [
            //                 $startDate . ' 00:00:00',
            //                 $endDate . ' 23:59:59'
            //             ]);
            //         }
            //     })
            //     ->whereRaw("LOWER(REPLACE(products.book_type, '-', '')) = 'ebook'")
            //     ->where('products.sku', '<>', '')
            //     // Group only by SKU, Name, and Author to remove redundancy
            //     ->groupBy('products.sku', 'products.name', 'products.author');

            // Exclude products with total read_count of 0 during export
            if ($request->get('is_export') == 1) {
                // $query->havingRaw('COALESCE(SUM(readcount_details.read_count), 0) > 0');
                $query->havingRaw($havingCondition);
            }

            // Stream CSV exports directly from the server. This avoids loading
            // every row into the browser and does not affect table pagination.
            if ($request->get('export') === 'csv') {
                $query->havingRaw($havingCondition);

                return response()->streamDownload(function () use ($query) {
                    $handle = fopen('php://output', 'w');
                    fputcsv($handle, ['Code', 'Name', 'Author', 'Read Counts']);

                    foreach ($query->orderBy('products.sku')->cursor() as $row) {
                        fputcsv($handle, [
                            $row->sku,
                            $row->name,
                            $row->author,
                            $row->read_count,
                        ]);
                    }

                    fclose($handle);
                }, 'read-counts.csv', [
                    'Content-Type' => 'text/csv; charset=UTF-8',
                ]);
            }

            return datatables()->of($query)->make(true);
        }

        return view('admin.ecommerce.reports-mobile.read-counts', compact('startDate', 'endDate'));
    }

    // FOR ADDING THE CURRENT READ COUNTS OF PRODUCTS BUT TAKE NOTE THE DATE RANGE WONT TAKE EFFECT FOR THIS

    // INSERT INTO readcount_details (product_id, read_count, created_at)
    // SELECT 
    //     id, 
    //     read_count, 
    //     NOW()
    // FROM products
    // WHERE read_count > 0;


    

    // public function read_counts(Request $request)
    // {
    //     $startDate = $request->get('start', false);
    //     $endDate   = $request->get('end', false);

    //     if ($request->ajax()) {
    //         $query = Product::select(['sku', 'name', 'read_count'])
    //             ->where('sku', '<>', '');

    //         // Exclude 0 read counts ONLY during file export or print
    //         if ($request->get('is_export') == 1) {
    //             $query->where('read_count', '>', 0);
    //         }

    //         if ($startDate && $endDate) {
    //             $query->whereBetween('created_at', [
    //                 $startDate . ' 00:00:00',
    //                 $endDate . ' 23:59:59'
    //             ]);
    //         }

    //         return datatables()->of($query)->make(true);
    //     }

    //     return view('admin.ecommerce.reports-mobile.read-counts', compact('startDate', 'endDate'));
    // }

    // public function read_counts(Request $request)
    // {
    //     $startDate = $request->get('start', false);
    //     $endDate   = $request->get('end', false);

    //     if ($request->ajax()) {
    //         // Query excluding empty SKUs and products with 0 read counts
    //         $query = Product::select(['sku', 'name', 'read_count'])
    //             ->where('sku', '<>', '')
    //             ->where('read_count', '>', 0); // Exclude 0 read counts

    //         // Apply date filters if selected
    //         if ($startDate && $endDate) {
    //             $query->whereBetween('created_at', [
    //                 $startDate . ' 00:00:00',
    //                 $endDate . ' 23:59:59'
    //             ]);
    //         }

    //         return datatables()->of($query)->make(true);
    //     }

    //     return view('admin.ecommerce.reports-mobile.read-counts', compact('startDate', 'endDate'));
    // }

    // public function read_counts(Request $request)
    // {
    
    //     $startDate = $request->get('start', false);
    //     $endDate   = $request->get('end', false);

    //     // dd($startDate);
    //     if ($request->ajax()) {
    //         $query = Product::select(['sku', 'name', 'read_count'])->where('sku', '<>', '');

    //         if ($startDate && $endDate) {
    //             $query->whereBetween('created_at', [
    //                 $startDate . ' 00:00:00',
    //                 $endDate . ' 23:59:59'
    //             ]);
    //         }
    //         return datatables()->of($query)->make(true);
    //     }

    //     return view('admin.ecommerce.reports-mobile.read-counts', compact('startDate', 'endDate'));
    // }

    
    // public function read_counts(Request $request)
    // {
    //     $startDate = $request->get('start', false);
    //     $endDate   = $request->get('end', false);

    //     $rs = Product::query();
      
    //     if ($startDate && $endDate) {
    //         $rs->whereBetween('created_at', [$startDate . " 00:00:00", $endDate . " 23:59:59"]);
    //     }
        
    //     $rs = $rs->paginate($this->pageCount);

    //     return view('admin.ecommerce.reports-mobile.read-counts',compact('rs', 'startDate', 'endDate'));

    // }


}
