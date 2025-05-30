<?php

namespace App\Models\APIModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Session;
use Hash;
use View;
use Input;
use Image;
use DB;

use App\Models\APIModels\Misc;

class BannerAds extends Model
{
   
   //SLIDER BANNERS ADS
  public function getHomeSliderBannerList($data){

     $query = DB::table('mobile_banners as mob_ban')
     ->join('mobile_albums as  mob_alb', 'mob_alb.id', '=', 'mob_ban.album_id') 
    
       ->selectraw("
          mob_ban.id as banner_ID,
          COALESCE(mob_ban.album_id,'') as album_id,

          COALESCE(mob_ban.title,'') as title,
          COALESCE(mob_ban.description,'') as description,
          COALESCE(mob_ban.alt,'') as alt,
          COALESCE(mob_ban.image_path,'') as image_path,
          
          COALESCE(mob_ban.button_text,'') as button_text,
          COALESCE(mob_ban.url,'') as url_link,          

          COALESCE(mob_ban.order,0) as order_sequence
                        
        ");    
       
       $query->where("mob_alb.status","=",1);  
       $query->where("mob_alb.type","=",'sub_banner');    
       $query->where("mob_alb.banner_type","=",'image');   
       $query->where("mob_ban.deleted_at","=",null);  

     
    $query->orderBy("mob_ban.order","ASC");     
    $list = $query->get();
                             
     return $list;    
    
  }
 
//POP UP BANNER ADS IMAGE ONLY  // REMOVE THIS ONCE ALL APPS IS APPROVED
  public function getPopUpBannerList($data){
   
   $query = DB::table('mobile_banners as mob_ban')
     ->join('mobile_albums as  mob_alb', 'mob_alb.id', '=', 'mob_ban.album_id') 
    
       ->selectraw("
          mob_ban.id as banner_ID,
          COALESCE(mob_ban.album_id,'') as album_id,

          COALESCE(mob_ban.title,'') as title,
          COALESCE(mob_ban.description,'') as description,
          COALESCE(mob_ban.alt,'') as alt,
          COALESCE(mob_ban.image_path,'') as image_path,
          
          COALESCE(mob_ban.button_text,'') as button_text,
          COALESCE(mob_ban.url,'') as url_link,          

          COALESCE(mob_ban.order,0) as order_sequence
                        
        ");    
              
       $query->where("mob_alb.status","=",1);         
       $query->where("mob_alb.type","=",'main_banner');    
       $query->where("mob_alb.banner_type","=",'image'); 
       $query->where("mob_ban.album_id","=",1); 
       $query->where("mob_ban.deleted_at","=",null); 
             
      $query->orderBy("mob_ban.order","ASC");          
     $list = $query->get();                           
     return $list;     
    
  }

// POP UP BANNER ADS IMAGE & VIDEO LATEST FUNCTION
  public function getPopUpBannerListAll($data){
   
   $query = DB::table('mobile_banners as mob_ban')
     ->join('mobile_albums as  mob_alb', 'mob_alb.id', '=', 'mob_ban.album_id') 
    
       ->selectraw("
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
                        
        ");    
              
       $query->where("mob_alb.status","=",1);         
       $query->where("mob_alb.type","=",'main_banner');    
       $query->where("mob_ban.album_id","=",1); 
       $query->where("mob_ban.deleted_at","=",null); 
             
      $query->orderBy("mob_ban.order","ASC");          
     $list = $query->get();                           
     return $list;     
    
  }

  //PAGE BODY SECTION ADS
  public function getBannerAds($data){

   $Page=$data['Page'];

   $query = DB::table('banner_ads as ban_ads')
     ->join('banner_ad_pages as  ban_ads_pg', 'ban_ads_pg.banner_ad_id', '=', 'ban_ads.id') 
    
       ->selectraw("
           ban_ads.id as banner_Ads_ID,
           COALESCE(ban_ads.mobile_file_url,'') as mobile_file_url,
           COALESCE(ban_ads.url,'') as url,
           COALESCE(ban_ads_pg.page_id,'') as page,

          COALESCE(ban_ads.click_counts,0) as click_counts
                        
        ");    
              
       $query->where("ban_ads_pg.page_id",'=',$Page);   
       $query->where("ban_ads.is_mobile","=",1);              
       $query->where("ban_ads.status","=",1);           
       $query->where("ban_ads.deleted_at","=",null); 
       $query->whereRaw('ban_ads_pg.page_id NOT REGEXP "^[0-9]+$"');  // Make sure page id is not in numeric ID but name of the page
                   
     $list = $query->first();                           
     return $list;     
    
  }

   public function getBannerAdsInfo($BannerAdsID){

   $query = DB::table('banner_ads as ban_ads')
     ->join('banner_ad_pages as  ban_ads_pg', 'ban_ads_pg.banner_ad_id', '=', 'ban_ads.id') 
    
       ->selectraw("
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