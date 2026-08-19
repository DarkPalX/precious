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
        
        $rs = $rs->groupBy('product_id')->paginate($this->pageCount);

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

        if ($request->ajax()) {
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
        
        $rs = $rs->groupBy('user_id')->paginate($this->pageCount);

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
        
        $rs = $rs->groupBy('product_id')->paginate($this->pageCount);

        return view('admin.ecommerce.reports.top-products',compact('rs', 'startDate', 'endDate'));
    }

    public function product_list(Request $request)
    {
        $rs = Product::all();        

        return view('admin.ecommerce.reports.product-list',compact('rs'));

    }

    public function customer_list(Request $request)
    {
        
        $rs = User::where('role_id','6')->get();        

        return view('admin.ecommerce.reports.customer-list',compact('rs'));

    }

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
                          DB::raw('SUM(qty) as total_quantity'),
                          DB::raw('SUM(net_amount) as total_net_amount'))
                 ->where('qty', 0);

      
        if ($startDate && $endDate) {
            $rs->whereBetween('created_at', [$startDate . " 00:00:00", $endDate . " 23:59:59"]);
        }
        
        $rs = $rs->groupBy('product_id')->paginate($this->pageCount);

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
        
        $rs = $rs->groupBy('user_id', 'customer_name')->paginate($this->pageCount);

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
        
        $rs = $rs->groupBy('product_id')->paginate($this->pageCount);

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

        $rs = Product::query();
      
        if ($startDate && $endDate) {
            $rs->whereBetween('created_at', [$startDate . " 00:00:00", $endDate . " 23:59:59"]);
        }
        
        $rs = $rs->paginate($this->pageCount);

        return view('admin.ecommerce.reports-mobile.downloads',compact('rs', 'startDate', 'endDate'));

    }
    
    public function customer_downloads(Request $request, $product_id)
    {
        $product = Product::withTrashed()->find($product_id);
        $rs = CustomerLibrary::where('product_id', $product_id)->paginate(100);

        return view('admin.ecommerce.reports-mobile.customer-downloads',compact('rs', 'product'));

    }

    public function read_counts(Request $request)
    {
        $startDate = $request->get('start', false);
        $endDate   = $request->get('end', false);

        if ($request->ajax()) {
            $query = Product::select(['sku', 'name', 'read_count'])
                ->where('sku', '<>', '');

            // Exclude 0 read counts ONLY during file export or print
            if ($request->get('is_export') == 1) {
                $query->where('read_count', '>', 0);
            }

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [
                    $startDate . ' 00:00:00',
                    $endDate . ' 23:59:59'
                ]);
            }

            return datatables()->of($query)->make(true);
        }

        return view('admin.ecommerce.reports-mobile.read-counts', compact('startDate', 'endDate'));
    }

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
