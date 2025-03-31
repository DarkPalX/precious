<?php

namespace App\Http\Controllers\Ecommerce;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BannerAdRequest;
use Facades\App\Helpers\FileHelper;
use Facades\App\Helpers\ListingHelper;
use App\Models\Ecommerce\{BannerAd, BannerAdPage};
use App\Models\{Page};

class BannerAdController extends Controller
{
    private $searchFields = ['name'];

    public function index(){
        // $ads = BannerAd::all();
        $ads  = ListingHelper::simple_search(BannerAd::class, $this->searchFields);
        $filter = ListingHelper::get_filter($this->searchFields);
        $searchType = 'simple_search';;

        return view('admin.ecommerce.ads.index', compact('ads', 'filter', 'searchType'));
    }

    public function create(){

        // Query for pages that are not in the $usedPageIds array and have status PUBLISHED
        $usedPageIds = BannerAdPage::pluck('page_id');
        
        $usedPageIds = BannerAdPage::join('banner_ads', 'banner_ad_pages.banner_ad_id', '=', 'banner_ads.id')
        ->whereNull('banner_ads.deleted_at')
        ->pluck('banner_ad_pages.page_id')
        ->toArray();

        $pages = Page::whereNotIn('id', $usedPageIds)->where('status', 'PUBLISHED')->get();

        $mobile_pages_array = [
            'Home',
            'Dashboard',
            'Profile',
            'Subscription',
            'Transactions',
            'Ecredits',
            'Messages',
            'Products',
            'Settings'
        ];
        
        $mobile_pages = array_diff($mobile_pages_array, $usedPageIds);
        
        return view('admin.ecommerce.ads.create', compact('pages', 'mobile_pages'));
    }

    public function store(BannerAdRequest $request){

        $newData = $request->validated();

        $fileUrls = [];
        $mobileFileUrls = [];

        if ($request->hasFile('file_url')) {
            foreach ($request->file('file_url') as $file) {
                $fileUrls[] = FileHelper::move_to_product_file_folder($file, 'storage/ads/files')['url'];
            }
        }

        if ($request->hasFile('mobile_file_url')) {
            foreach ($request->file('mobile_file_url') as $file) {
                $mobileFileUrls[] = FileHelper::move_to_product_file_folder($file, 'storage/ads/mobile_files')['url'];
            }
        }

        $newData['file_url'] = json_encode($fileUrls) ?? "";
        $newData['mobile_file_url'] = json_encode($mobileFileUrls) ?? "";

        // $newData['file_url'] = $request->hasFile('file_url') ? FileHelper::move_to_product_file_folder($request->file('file_url'), 'storage/ads/files')['url'] : "";
        // $newData['mobile_file_url'] = $request->hasFile('mobile_file_url') ? FileHelper::move_to_product_file_folder($request->file('mobile_file_url'), 'storage/ads/mobile_files')['url'] : "";
        $newData['status'] = $request->status ? 1 : 0;

        $ad = BannerAd::create($newData);
        
        // FOR ADDING PAGES
        $pages = $newData['pages'];

        foreach ($pages as $page) {
            $pageData = [
                'banner_ad_id' => $ad->id,
                'page_id' => $page
            ];
            
            BannerAdPage::create($pageData);
        }


        return redirect()->route('ads.index')->with('success', 'Successfully created an ad.');
    }

    public function edit($id){
        
        // Get the page IDs used in any ad
        $usedPageIds = BannerAdPage::join('banner_ads', 'banner_ad_pages.banner_ad_id', '=', 'banner_ads.id')
        ->where('banner_ad_pages.banner_ad_id', '!=', $id)
        ->whereNull('banner_ads.deleted_at')
        ->pluck('banner_ad_pages.page_id')
        ->toArray();

        $pages = Page::whereNotIn('id', $usedPageIds)->where('status', 'PUBLISHED')->get();

        $mobile_pages_array = [
            'Home',
            'Dashboard',
            'Profile',
            'Subscription',
            'Transactions',
            'Ecredits',
            'Messages',
            'Products',
            'Settings'
        ];
        
        $mobile_pages = array_diff($mobile_pages_array, $usedPageIds);

        $ad = BannerAd::findOrFail($id);
        $ad_pages = BannerAdPage::where('banner_ad_id', $id)->get();

        return view('admin.ecommerce.ads.edit', compact('pages', 'mobile_pages', 'ad', 'ad_pages'));
    }
    
    public function update(BannerAdRequest $request, $id)
    {
        $ad = BannerAd::findOrFail($id);

        $updateData = $request->all();

        $fileUrls = [];
        $mobileFileUrls = [];

        //FOR DESKTOP FILE UPDATE VALUE
        $current_file = explode('/', $request->current_file)[1] ?? '';
        if ($request->hasFile('file_url')) {
            foreach ($request->file('file_url') as $file) {
                $fileUrls[] = FileHelper::move_to_product_file_folder($file, 'storage/ads/files')['url'];
            }

            $updateData['file_url'] = json_encode($fileUrls);
        }
        else{
            $updateData['file_url'] = $current_file ? $ad->file_url : '';
        }

        //FOR MOBILE FILE UPDATE VALUE
        $current_mobile_file = explode('/', $request->current_mobile_file)[1] ?? '';
        if ($request->hasFile('mobile_file_url')) {
            foreach ($request->file('mobile_file_url') as $file) {
                $mobileFileUrls[] = FileHelper::move_to_product_file_folder($file, 'storage/ads/mobile_files')['url'];
            }

            $updateData['mobile_file_url'] = json_encode($mobileFileUrls);
        }
        else{
            $updateData['mobile_file_url'] = $current_mobile_file ? $ad->mobile_file_url : '';
        }

        $updateData['status'] = $request->status ? 1 : 0;
        

        // //FOR DESKTOP FILE UPDATE VALUE
        // $current_file = explode('/', $request->current_file)[1] ?? '';
        // if($request->hasFile('file_url')){
        //     $updateData['file_url'] = FileHelper::move_to_product_file_folder($request->file('file_url'), 'storage/ads/files')['url'];
        // }
        // else{
        //     if($current_file){
        //         $updateData['file_url'] = $ad->file_url;
        //     }
        //     else{
        //         $updateData['file_url'] = "";
        //     }
        // }

        // //FOR MOBILE FILE UPDATE VALUE
        // $current_mobile_file = explode('/', $request->current_mobile_file)[1] ?? '';
        // if($request->hasFile('mobile_file_url')){
        //     $updateData['mobile_file_url'] = FileHelper::move_to_product_file_folder($request->file('mobile_file_url'), 'storage/ads/mobile_files')['url'];
        // }
        // else{
        //     if($current_mobile_file){
        //         $updateData['mobile_file_url'] = $ad->mobile_file_url;
        //     }
        //     else{
        //         $updateData['mobile_file_url'] = "";
        //     }
        // }

        $ad->update($updateData);

        //DELETE CURRENT AD PAGES FIRST
        BannerAdPage::where('banner_ad_id', $ad->id)->delete();

        // FOR ADDING PAGES
        $pages = $updateData['pages'];

        foreach ($pages as $page) {
            $pageData = [
                'banner_ad_id' => $ad->id,
                'page_id' => $page
            ];
            
            BannerAdPage::create($pageData);
        }
 

        return redirect()->back()->with('success', 'Successfully edited an ad.');
    }

    public function delete(Request $request, $ad_id)
    {

        $banner_ad = BannerAd::whereId((int) $ad_id);
        $banner_ad->update(['status' => 0]);
        $banner_ad->delete();

        return back()->with('success', "Ad successfully deleted");
    }

    public function restore($ad_id)
    {
        BannerAd::whereId((int) $ad_id)->restore();

        return back()->with('success', "Ad successfully restored");
    }

    public function click_count($ad_id){
        $banner_ad = BannerAd::where('id', $ad_id)->first();
        if ($banner_ad) {
            $banner_ad->update(['click_counts' => $banner_ad->click_counts + 1]);
        }
        return redirect($banner_ad->url);
    }
    
}
