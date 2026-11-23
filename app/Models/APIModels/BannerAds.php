<?php

namespace App\Models\APIModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use Session;
use Hash;
use View;
use Input;
use Image;

use App\Models\APIModels\Misc;

class BannerAds extends Model
{

  const BANNER_CACHE_MINUTES = 2;
  private function bannerCacheExpiry(){
    return now()->addMinutes(self::BANNER_CACHE_MINUTES);
  }


  public function getHomeSliderBannerList($data){

    $cacheKey = 'home_slider_banners';

    return Cache::remember($cacheKey, $this->bannerCacheExpiry(), function() {

        $query = DB::table('mobile_banners as mob_ban')
            ->join('mobile_albums as mob_alb', 'mob_alb.id', '=', 'mob_ban.album_id')

            ->selectRaw("
                mob_ban.id as banner_ID,
                COALESCE(mob_ban.album_id,'') as album_id,
                COALESCE(mob_ban.title,'') as title,
                COALESCE(mob_ban.description,'') as description,
                COALESCE(mob_ban.alt,'') as alt,
                COALESCE(mob_ban.image_path,'') as image_path,

                COALESCE(mob_ban.button_text,'') as button_text,
                COALESCE(mob_ban.url,'') as url_link,
                COALESCE(mob_ban.order,0) as order_sequence
            ")

            ->where('mob_alb.status', '=', 1)
            ->where('mob_alb.type', '=', 'sub_banner')
            ->where('mob_alb.banner_type', '=', 'image')
            ->whereNull('mob_ban.deleted_at')

            ->orderBy('mob_ban.order', 'ASC')
            ->limit(5);

        return $query->get();
    });
  }



  public function getPopUpBannerList($data){

    $cacheKey = 'popup_banner_list';

    // 2 Minutes Set To Cache
    return Cache::remember($cacheKey, $this->bannerCacheExpiry(), function() {

        $query = DB::table('mobile_banners as mob_ban')
            ->join('mobile_albums as mob_alb', 'mob_alb.id', '=', 'mob_ban.album_id')

            ->selectRaw("
                mob_ban.id as banner_ID,
                COALESCE(mob_ban.album_id,'') as album_id,
                COALESCE(mob_ban.title,'') as title,
                COALESCE(mob_ban.description,'') as description,
                COALESCE(mob_ban.alt,'') as alt,
                COALESCE(mob_ban.image_path,'') as image_path,

                COALESCE(mob_ban.button_text,'') as button_text,
                COALESCE(mob_ban.url,'') as url_link,
                COALESCE(mob_ban.order,0) as order_sequence
            ")

            ->where('mob_alb.status', '=', 1)
            ->where('mob_alb.type', '=', 'main_banner')
            ->where('mob_alb.banner_type', '=', 'image')
            ->where('mob_ban.album_id', '=', 1)
            ->whereNull('mob_ban.deleted_at')

            ->orderBy('mob_ban.order', 'ASC')
            ->limit(10);

        return $query->get();
    });
  }


  public function getPopUpBannerListAll($data){

    $cacheKey = 'popup_banner_list_all';

    // 2 Minutes Set To Cache
    return Cache::remember($cacheKey, $this->bannerCacheExpiry(), function() {

        $query = DB::table('mobile_banners as mob_ban')
            ->join('mobile_albums as mob_alb', 'mob_alb.id', '=', 'mob_ban.album_id')

            ->selectRaw("
                mob_ban.id as banner_ID,
                COALESCE(mob_ban.album_id,'') as album_id,
                COALESCE(mob_ban.title,'') as title,
                COALESCE(mob_ban.description,'') as description,
                COALESCE(mob_ban.alt,'') as alt,
                COALESCE(mob_ban.image_path,'') as image_path,

                COALESCE(mob_ban.button_text,'') as button_text,
                COALESCE(mob_ban.url,'') as url_link,

                COALESCE(mob_alb.banner_type,'') as banner_type,
                COALESCE(mob_ban.order,0) as order_sequence
            ")

            ->where('mob_alb.status', '=', 1)
            ->where('mob_alb.type', '=', 'main_banner')
            ->where('mob_ban.album_id', '=', 1)
            ->whereNull('mob_ban.deleted_at')

            ->orderBy('mob_ban.order', 'ASC')
            ->limit(10);

        return $query->get();
    });
  }

  //PAGE BODY SECTION ADS
  public function getBannerAds($data)
  {
    $Page = $data['Page'];

    $cacheKey = "banner_ads_page_{$Page}";

    // 2 Minutes Set To Cache
    return Cache::remember($cacheKey, $this->bannerCacheExpiry(), function () use ($Page) {
        return DB::table('banner_ads as ban_ads')
            ->join('banner_ad_pages as ban_ads_pg', 'ban_ads_pg.banner_ad_id', '=', 'ban_ads.id')
            ->selectRaw("
                ban_ads.id as banner_Ads_ID,
                COALESCE(ban_ads.mobile_file_url, '') as mobile_file_url,
                COALESCE(ban_ads.url, '') as url,
                COALESCE(ban_ads_pg.page_id, '') as page,
                COALESCE(ban_ads.click_counts, 0) as click_counts
            ")
            ->where('ban_ads_pg.page_id', '=', $Page)
            ->where('ban_ads.is_mobile', '=', 1)
            ->where('ban_ads.status', '=', 1)
            ->whereNull('ban_ads.deleted_at')
            ->whereRaw('ban_ads_pg.page_id NOT REGEXP "^[0-9]+$"') // page id must not be numeric
            ->first();
    });
  }

  public function getBannerAdsInfo($BannerAdsID){

    $query = DB::table('banner_ads as ban_ads')
      ->join('banner_ad_pages as ban_ads_pg', 'ban_ads_pg.banner_ad_id', '=', 'ban_ads.id')

      ->selectRaw("
          ban_ads.id as banner_Ads_ID,
          COALESCE(ban_ads.mobile_file_url,'') as mobile_file_url,
          COALESCE(ban_ads.url,'') as url,
          COALESCE(ban_ads_pg.page_id,'') as page,

          COALESCE(ban_ads.click_counts,0) as click_counts
      ");

    $query->where("ban_ads.id",'=',$BannerAdsID);

    $list = $query->first();
    return $list;

  }

  public function updateBannerClickCounts($click_counts, $BannerAdsID){

    DB::table('banner_ads')
      ->whereRaw('id = ?',[$BannerAdsID])
      ->update([
          'click_counts' => $click_counts
      ]);

    return "Success";

  }


}