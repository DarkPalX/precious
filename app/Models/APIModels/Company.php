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

class Company extends Model
{

  // public function getCompanyAboutUs(){

  //  $query = DB::table('pages as pg')
     
  //      ->selectraw("
  //         pg.id as Page_ID,
  //         COALESCE(pg.contents,'') as about_us                        
  //       ");

  //      $query->where("pg.status","=",'PUBLISHED');  
  //      $query->where("pg.label","=",'About Us');           
  //      $query->where("pg.deleted_at","=",null);    
      
  //   $list = $query->first();                          
  //  return $list;  

    
  // }

  public function getCompanyFAQ($data){

     $query = DB::table('pages as pg')
         
       ->selectraw("
          pg.id as Page_ID,
          COALESCE(pg.contents,'') as faq                        
        ");    
       
       $query->where("pg.status","=",'PUBLISHED');  
       $query->where("pg.label","=",'FAQs');           
       $query->where("pg.deleted_at","=",null);  
     
    $list = $query->first();                           
     return $list;    
    
  }

  // public function getCompanyPrivacyPolicy($data){

  //    $query = DB::table('pages as pg')
         
  //      ->selectraw("
  //         pg.id as Page_ID,
  //         COALESCE(pg.contents,'') as privacy_policy                        
  //       ");    
       
  //      $query->where("pg.status","=",'PUBLISHED');  
  //      $query->where("pg.label","=",'Privacy Policy');           
  //      $query->where("pg.deleted_at","=",null);  
     
  //   $list = $query->first();                           
  //    return $list;    
    
  // }


  // public function getCompanyTermsCondition($data){

  //    $query = DB::table('pages as pg')
         
  //      ->selectraw("
  //         pg.id as Page_ID,
  //         COALESCE(pg.contents,'') as terms_condition                        
  //       ");    
       
  //      $query->where("pg.status","=",'PUBLISHED');  
  //      $query->where("pg.label","=",'Terms of Use Agreement');           
  //      $query->where("pg.deleted_at","=",null);  
     
  //   $list = $query->first();                           
  //    return $list;    
    
  // }
  

  public function getCompanyAboutUs(){

    return Cache::remember(
        'company_about_us',
       now()->addSeconds(30),
        function () {

            $query = DB::table('pages as pg')
                ->selectraw("
                    pg.id as Page_ID,
                    COALESCE(pg.contents,'') as about_us
                ");

            $query->where("pg.status", "=", "PUBLISHED");
            $query->where("pg.label", "=", "About Us");
            $query->whereNull("pg.deleted_at");

            return $query->first();
        }
    );
}


// public function getCompanyFAQ($data){

//     return Cache::remember(
//         'company_faq',
//         now()->addSeconds(30),
//         function () {

//             $query = DB::table('pages as pg')
//                 ->selectraw("
//                     pg.id as Page_ID,
//                     COALESCE(pg.contents,'') as faq
//                 ");

//             $query->where("pg.status", "=", "PUBLISHED");
//             $query->where("pg.label", "=", "FAQs");
//             $query->whereNull("pg.deleted_at");

//             return $query->first();
//         }
//     );
// }


public function getCompanyPrivacyPolicy($data){

    return Cache::remember(
        'company_privacy_policy',
       now()->addSeconds(30),
        function () {

            $query = DB::table('pages as pg')
                ->selectraw("
                    pg.id as Page_ID,
                    COALESCE(pg.contents,'') as privacy_policy
                ");

            $query->where("pg.status", "=", "PUBLISHED");
            $query->where("pg.label", "=", "Privacy Policy");
            $query->whereNull("pg.deleted_at");

            return $query->first();
        }
    );
}


public function getCompanyTermsCondition($data){

    return Cache::remember(
        'company_terms_condition',
       now()->addSeconds(30),
        function () {

            $query = DB::table('pages as pg')
                ->selectraw("
                    pg.id as Page_ID,
                    COALESCE(pg.contents,'') as terms_condition
                ");

            $query->where("pg.status", "=", "PUBLISHED");
            $query->where("pg.label", "=", "Terms of Use Agreement");
            $query->whereNull("pg.deleted_at");

            return $query->first();
        }
    );
}

}