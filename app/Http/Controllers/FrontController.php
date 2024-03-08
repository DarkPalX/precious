<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Facades\App\Helpers\ListingHelper;

use App\Http\Requests\ContactUsRequest;
use App\Helpers\Setting;

use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryAdminMail;
use App\Mail\InquiryMail;

use App\Models\Article;
use App\Models\Page;
use App\Models\User;

use App\Models\TemplateCategory;
use App\Models\Template;
use App\Models\EmailRecipient;
use App\Models\Ecommerce\{BannerAd, BannerAdPage, Product};

use Auth;




class FrontController extends Controller
{

    public function registration()
    {
        $categories = TemplateCategory::where('status','Active')->orderBy('name','asc')->get();
        $templates  = Template::where('status','Active')->get();
        return view('theme.template-registration',compact('categories','templates'));
    }

    public function request_for_demo($id)
    {
        $template = Template::find($id);
        
        return view('theme.demo',compact('template'));
    }

    public function home()
    {
        return $this->page('home');
    }

    public function privacy_policy(){

        $footer = Page::where('slug', 'footer')->where('name', 'footer')->first();

        $page = new Page();
        $page->name = 'Privacy Policy';

        $breadcrumb = $this->breadcrumb($page);

        return view('theme.pages.privacy-policy', compact('page', 'footer','breadcrumb'));

    }

    public function seach_result(Request $request)
    {
        $page = new Page();
        $page->name = 'Search Results';

        $breadcrumb = $this->breadcrumb($page);
        $pageLimit = 10;

        $searchtxt = $request->searchtxt; 
        session(['searchtxt' => $searchtxt]);

        $pages = Page::where('status', 'PUBLISHED')
            ->whereNotIn('slug', ['footer', 'home'])
            ->where(function ($query) use ($searchtxt) {
                $query->where('name', 'like', '%' . $searchtxt . '%')
                    ->orWhere('contents', 'like', '%' . $searchtxt . '%');
            })
            ->select('name', 'slug')
            ->orderBy('name', 'asc')
            ->get();

        $news = Article::where('status', 'PUBLISHED')
            ->where(function ($query) use ($searchtxt) {
                $query->where('name', 'like', '%' . $searchtxt . '%')
                    ->orWhere('contents', 'like', '%' . $searchtxt . '%');
            })
            ->select('name', 'slug')
            ->orderBy('name', 'asc')
            ->get();

        $products = Product::select('products.*')->leftJoin('product_additional_infos', 'products.id', '=', 'product_additional_infos.product_id')
        ->where('products.status', 'PUBLISHED')->get();

        $totalItems = $pages->count()+$news->count()+$products->count();

        $searchResult = collect($pages)->merge($news)->merge($products)->paginate(10);

        return view('theme.pages.search-result', compact('searchResult', 'totalItems', 'page','breadcrumb'));
    }

    public function page($slug = "home")
    {

        if (Auth::guest()) {
            $page = Page::where('slug', $slug)->where('status', 'PUBLISHED')->first();
        } else {
            $page = Page::where('slug', $slug)->first();
        }

        if ($page == null) {
            $view404 = 'theme.pages.404';
            if (view()->exists($view404)) {
                $page = new Page();
                $page->name = 'Page not found';
                return view($view404, compact('page'));
            }

            abort(404);
        }
        $breadcrumb = $this->breadcrumb($page);

        //FOR BANNER ADS
        $used_page = BannerAdPage::where('page_id', $page->id)->first();
        $banner_ads = BannerAd::where('id', $used_page->banner_ad_id ?? 0)->where('status', 1)->where('expiration_date', '>', now())->get();
        //END BANNER ADS

        $footer = Page::where('slug', 'footer')->where('name', 'footer')->first();

        if (!empty($page->template)) {
            return view('theme.pages.'.$page->template, compact('footer', 'page', 'breadcrumb', 'banner_ads'));
        }

        $parentPage = null;
        $parentPageName = $page->name;
        $currentPageItems = [];
        $currentPageItems[] = $page->id;
        if ($page->has_parent_page() || $page->has_sub_pages()) {
            if ($page->has_parent_page()) {
                $parentPage = $page->parent_page;
                $parentPageName = $parentPage->name;
                $currentPageItems[] = $parentPage->id;
                while ($parentPage->has_parent_page()) {
                    $parentPage = $parentPage->parent_page;
                    $currentPageItems[] = $parentPage->id;
                }
            } else {
                $parentPage = $page;
                $currentPageItems[] = $parentPage->id;
            }
        }

        return view('theme.page', compact('footer', 'page', 'parentPage', 'breadcrumb', 'currentPageItems', 'parentPageName', 'banner_ads'));
    }

    
    public function contact_us(Request $request)
    {
        $email_recipients  = EmailRecipient::all();
        $client = $request->all();

        \Mail::to($client['email'])->send(new InquiryMail(Setting::info(), $client));

        foreach ($email_recipients as $email_recipient) {
            \Mail::to($email_recipient->email)->send(new InquiryAdminMail(Setting::info(), $client, $email_recipient));
        }

        session()->flash('success', 'Email sent!');

        return redirect()->back();
    }

    // public function contact_us(ContactUsRequest $request)
    // {
    //     $admins  = User::where('role_id', 1)->get();
    //     $client = $request->all();

    //     Mail::to($client['email'])->send(new InquiryMail(Setting::info(), $client));

    //     foreach ($admins as $admin) {
    //         Mail::to($admin->email)->send(new InquiryAdminMail(Setting::info(), $client, $admin));
    //     }

    //     if (Mail::failures()) {
    //         return redirect()->back()->with('error','Failed to send inquiry. Please try again later.');
    //     }

    //     return redirect()->back()->with('success','Email sent!');
    // }

    public function breadcrumb($page)
    {
        return [
            'Home' => url('/'),
            $page->name => url('/').'/'.$page->slug
        ];
    }
}
