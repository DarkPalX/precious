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

use Auth;
use DB;


class ReportsController extends Controller
{
    public function best_sellers(Request $request)
    {
        $rs = SalesDetail::select('product_id',
                          DB::raw('SUM(qty) as total_quantity'),
                          DB::raw('SUM(net_amount) as total_net_amount'))
                 ->groupBy('product_id')
                 ->get();


        return view('admin.ecommerce.reports.best-sellers',compact('rs'));

    }
    
    public function top_buyers(Request $request)
    {       
        $rs = SalesHeader::select('user_id', 
                         DB::raw('SUM(net_amount) as total_net_amount'), 
                         DB::raw('COUNT(*) as order_count'))
                 ->where('status', 'active')
                 ->groupBy('user_id')
                 ->get();


        return view('admin.ecommerce.reports.top-buyers',compact('rs'));

    }
    
    public function top_products(Request $request)
    {
        $rs = ProductReview::select('product_id',
                            DB::raw('AVG(rating) as average_rating'), 
                            DB::raw('COUNT(*) as review_count'))
                   ->groupBy('product_id')
                   ->get();  

        return view('admin.ecommerce.reports.top-products',compact('rs'));

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

    public function sales_list(Request $request)
    {
        $sales = SalesDetail::join('ecommerce_sales_headers', 'ecommerce_sales_details.sales_header_id', 'ecommerce_sales_headers.id')
            ->whereNotNull('ecommerce_sales_headers.id');


        $startDate = $request->get('start', false);
        $endDate   = $request->get('end', false);
        $customer  = $request->get('customer', false);
        $product   = $request->get('product', false);
        $category   = $request->get('category', false);
        $status    = $request->get('del_status', false);

        // dd($category);


        if(isset($customer) && $customer <> ''){
            $sales->where('ecommerce_sales_headers.customer_name', $customer);
        }

        if(isset($product) && $product <> ''){
            $sales->where('ecommerce_sales_details.product_name', $product);
        }

        if(isset($category) && $category <> ''){
            $sales->where('ecommerce_sales_details.product_category', $category);
        }

        if(isset($status) && $status <> ''){
            $sales->where('ecommerce_sales_headers.delivery_status', $status);
        }
      
        if(isset($startDate) && strlen($startDate)>=1){
            $sales->whereBetween('ecommerce_sales_headers.created_at',[$startDate." 00:00:00.000", $endDate." 23:59:59.999"]);  
        }

        $sales = $sales->orderBy('ecommerce_sales_headers.created_at', 'desc')->get();

        return view('admin.ecommerce.reports.sales-transaction',compact('sales', 'startDate', 'endDate', 'customer', 'product', 'status'));

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

       
        if(isset($_GET['coupon_code']) && $_GET['coupon_code']<>''){
            $qry.= " and cs.coupon_code = '".$_GET['coupon_code']."' ";
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

}
