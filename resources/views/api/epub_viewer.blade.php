
<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8" />
 
  <meta http-equiv="Content-Security-Policy" content="default-src * 'unsafe-inline' 'unsafe-eval' data: blob:;">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Precious Epub Viewer</title>

  
  <link rel="stylesheet" type="text/css" href="https://www.beta.ebooklat.phr.com.ph/public/api/css/epub-main-style.css">

  <script src="https://www.beta.ebooklat.phr.com.ph/public/api/js/jszip.min.js"></script>
  <script src="https://www.beta.ebooklat.phr.com.ph/public/api/js/epub.js"></script>
  <!-- <script src="https://www.api.ebooklat.phr.com.ph/public/api/js/localforage.min"></script> -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/localforage/1.3.0/localforage.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  
  <style>
   #toc{
    width: 100%;
    background: #e6e6e6;
    padding: 5px;
    display: block;
    font-size: 13px;
    z-index:999;
    width: 98%;
    height: 50px;
   }

   /*#viewer{
    padding-top:30px;
   }
  .spreads{
      padding-top:20px;
      padding-bottom:20px;
   }*/

.sidenav {
    height: 100%;
    width: 310px;
    position: fixed;
    z-index: 9999999;
    top: 0;
    right: -315px;
    background-color: #fff;
    overflow-x: hidden;
    transition: 0.5s;
    box-shadow: 0 6px 12px rgba(0,0,0,0.175);
}

.font-chip{

   display: inline-block;
    vertical-align: middle;
    border-radius: 32px;
    border: 1px solid rgba(0, 0, 0, 0.15);
    text-align: center;
    margin: 4px;
    padding: 4px 8px;

      display: inline-block;
    vertical-align: middle;
    border-radius: 32px;
    border: 1px solid rgba(0, 0, 0, 0.15);
    text-align: center;
    margin: 4px;
    padding: 4px 8px;
    cursor: pointer;
}

.font-setting {
    display: block;
    padding: 8px 12px;
    border-botto
  }

.theme-setting {
    display: inline-block;
    vertical-align: middle;
    border-radius: 32px;
    border: 1px solid rgba(0, 0, 0, 0.15);
    text-align: center;
    margin: 4px;
    padding: 4px 8px;
}

.size-setting {
    display: inline-block;
    vertical-align: middle;
    border-radius: 32px;
    border: 1px solid rgba(0, 0, 0, 0.15);
    text-align: center;
    margin: 4px;
    padding: 4px 8px;
}

.margin-setting {
    display: inline-block;
    vertical-align: middle;
    border-radius: 32px;
    border: 1px solid rgba(0, 0, 0, 0.15);
    text-align: center;
    margin: 4px;
    padding: 4px 8px;
}

  .setting-label {
    display: block;
    font-weight: 700;
    margin-bottom: 8px;
        padding: 5px;
}

.setting-content{
   padding: 4px;
}
  </style>

</head>
<body>
  <!-- <div id="title"></div> -->
  
@if($epub_file_exist)
  
  
  <div style="display:flex;top: 0px;right:0px;background: lightgray;height: 40px;z-index: 99999;position: fixed;">    
        <div style="padding-right: 20px;cursor: pointer;width: 2%; display: contents;padding-left: 4px; color: #fff;">        
        <img src="https://www.beta.ebooklat.phr.com.ph/public/api/img/menu-icon.png" onclick="openSidePanelNav()" style="width: 40px;">                
    </div>
  </div>
   
  <div id="viewer" class="spreads" style="font-size:30px;"></div>
    
  <!-- height spacer -->
  <div style="height: 40px;"></div>
  
   <div style="height:44px;position: fixed;z-index: 999;bottom:50%;text-align:center;width:100%;background: none;">
  <a id="prev" href="#prev" class="arrow" style="font-size: 80px;width: 65px;background: transparent;float: left;margin-left: -20px !important;color: lightgray !important;visibility: visible;height: 100px;line-height: 70px;">‹</a>
  <a id="next" href="#next" class="arrow" style="font-size: 80px;width: 65px;background: transparent;float: right;margin-right: -20px !important;;color: lightgray !important;visibility: visible;height: 100px;line-height: 70px;">›</a>      
  </div>

  <div id="CartPanel" class="sidenav" style="right: -315px;width: 260px;">
      <div id="SidePanelCartDetail" class="header-wrapper sticky-area" style="display: block; background: #21395f !important;padding-top: 10px;">
        <div class="container" style="padding-left: 5px;">
            <div class="topbar d-flex" style="border-bottom: 1.2px solid rgba(255,255,255,.5);">
              <div class="topbar-item-right d-flex ">
                  <div class="item">
                    <div style="display:flex;">
                    <img src="https://www.beta.ebooklat.phr.com.ph/public/api/img/close-button.png" onclick="closeSidePanelNav()" style="color:#fff;font-family: work sans,sans-serif;cursor: pointer;width: 30px;height: 30px;">  
                    <span style="color:#fff;padding-left: 50px;">:: Settings ::</span>
                    </div>
                  </div>
              </div>
            </div>

          </div>
      </div>

       <div class="row" style="margin-right: 0px;margin-left: 0px;"> 
            <div class="table-responsive-md" style="width: 100%;">                  
                <table class="table table-style-01" style="width:100%;">
                  <tbody> 

                       <div class="setting">
                            <div class="setting-label" style="border-bottom: 1px dashed gray;border-top: 1px dashed gray;">Select Chapter</div>
                            <div class="setting-content" data-chips="theme">
                               <select id="toc" style="font-size:15px;padding:5px !important;float:left;"></select>                              
                            </div>
                        </div>

                      <div class="setting">
                          <!-- <div class="setting-label" style="border-bottom: 1px dashed gray;border-top: 1px dashed gray;">Set Bookmark</div>     -->
                          <center style="padding-bottom:10px;">                            
                          <form action="https://www.beta.ebooklat.phr.com.ph/public/api/update-book-marks" method="post">
                            <input type="hidden" value="{{$customer_id}}" name="UserID">
                            <input type="hidden" value="{{$product_id}}" name="ProductID">
                            <input id="BookMarkIndex" type="hidden" name="PageNo">
                             <input type="submit" value=" Bookmark This Chapter " style="vertical-align: middle;border-radius: 32px;border: 1px solid rgba(0, 0, 0, 0.15);text-align: center;margin: 4px;padding: 4px 8px;margin-top: 15px;">
                           </form>
                           </center>          
                        </div>

                      <div class="setting">
                            <div class="setting-label" style="border-bottom: 1px dashed gray;border-top: 1px dashed gray;">Themes</div>
                            <div class="setting-content" data-chips="theme">
                                <div class="theme-setting" id="light-theme" style="background: #fff; color: #000;" data-default="true" data-value="#fff;#000">Light</div>
                                <div class="theme-setting" id="dark-theme" style="background: #000; color: #fff;" data-value="#000;#fff">Dark</div>                                
                                <div class="theme-setting" id="septia-theme"  style="background: #f5deb3; color: #000;" data-value="#f5deb3;#000">Sepia</div>                                
                            </div>
                        </div> 

                      <div class="setting">
                            <div class="setting-label" style="border-bottom: 1px dashed gray;border-top: 1px dashed gray;">Font Style</div>
                            <div class="setting-content" data-chips="font">
                                <div class="font-chip" id="font_lucida" style="font-family: Lucida Console, Courier New, monospace;">Courier New</div>                                
                                <div class="font-chip " id="font_times" style="font-family: Times New Roman, Times, serif;">Times Roman</div>                                
                                <div class="font-chip" id="font_helvetica" style="font-family: Arial, Helvetica, sans-serif;" >Helvetica Style</div>
                            </div>
                        </div>

                        <div class="setting">
                            <div class="setting-label" style="border-bottom: 1px dashed gray;border-top: 1px dashed gray;">Font Size</div>
                            <div class="setting-content" data-chips="font-size">                                
                                <div id="font_10" class="size-setting" style="font-size:10pt">10</div>
                                <div id="font_11" class="size-setting" style="font-size:11pt">11</div>
                                <div id="font_12" class="size-setting" style="font-size:12pt">12</div>
                                <div id="font_13" class="size-setting" style="font-size:13pt">13</div>
                                <div id="font_15" class="size-setting" style="font-size:15pt">15</div>
                                <div id="font_16" class="size-setting" style="font-size:16pt">16</div>
                                <div id="font_18" class="size-setting" style="font-size:18pt">18</div>
                                <div id="font_20" class="size-setting" style="font-size:20pt">20</div>                                
                            </div>
                        </div>

                        <div class="setting">
                            <div class="setting-label" style="border-bottom: 1px dashed gray;border-top: 1px dashed gray;">Margins</div>
                            <div class="setting-content" data-chips="font-size">                                
                                <div id="margin_0" class="margin-setting" style="font-size:10pt">0px</div>
                                <div id="margin_2" class="margin-setting" style="font-size:10pt">2px</div>
                                <div id="margin_4" class="margin-setting" style="font-size:10pt">4px</div>
                                <div id="margin_6" class="margin-setting" style="font-size:10pt">6px</div>
                                <div id="margin_8" class="margin-setting" style="font-size:10pt">8px</div>
                                <div id="margin_10" class="margin-setting" style="font-size:10pt">10px</div>                                                              
                                <div id="margin_12" class="margin-setting" style="font-size:10pt">12px</div>                                                              
                            </div>
                        </div>
                    
                </tbody>
           </table>                        
          </div>
      </div>           
  </div>

  @else
   <div class="container" style="position: relative; width: 100%px;height: 30%;">
    <center style="position: absolute; top: 50%;width: 300px;left: 13%;">
        <p>Sorry! No ePub book files found nor attached to the books that you are reading.</p>
    </center>
  </div>
  @endif


  <script>
  
    var option=0;

    var background="light";
    var font_size="18";
    var margin_size="0";
    var font_style="Times Roman";
      
    var params = URLSearchParams && new URLSearchParams(document.location.search.substring(1));
    var url = params && params.get("url") && decodeURIComponent(params.get("url"));
    var currentSectionIndex = (params && params.get("loc")) ? params.get("loc") : undefined;

    var currentSectionIndex ="{{$chapter_page_no}}";
  
    var book = ePub("{{$epub_doc}}", {
      store: "epubjs-test"
    });
     
    var rendition = book.renderTo("viewer", {
      width: "100%",
      height: "100%",
      flow: "scrolled-doc"
    });
   
    var displayed = rendition.display(currentSectionIndex);

    // displayed.then(function(renderer){
    //   // Add all resources to the store      
    //   book.storage.add(book.resources, true).then(() => {
    //     console.log("stored");
    //   })
    // });
   


    // Start Set Custome Theme==============================
     
    var dark_theme = document.getElementById("dark-theme");
    dark_theme.addEventListener("click", function(e){  

      background="dark";
      //rendition.themes.select("dark");     

      if(font_size=="10"){

        if(font_style=='Times Roman'){            
          rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "10px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "10px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "10px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

        rendition.themes.select("dark_color");  
      }

      if(font_size=="11"){
         if(font_style=='Times Roman'){            
          rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "11px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "11px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "11px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

        rendition.themes.select("dark_color");  
      }

      if(font_size=="12"){

         if(font_style=='Times Roman'){            
          rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "12px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "12px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "12px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

        rendition.themes.select("dark_color");  
      }

      if(font_size=="13"){

       if(font_style=='Times Roman'){            
          rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "13px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "13px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "13px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

        rendition.themes.select("dark_color");  
      }

      if(font_size=="15"){

         if(font_style=='Times Roman'){            
          rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "15px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "15px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "15px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

        rendition.themes.select("dark_color");  
      }

      if(font_size=="16"){

        if(font_style=='Times Roman'){            
          rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "16px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "16px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "16px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

        rendition.themes.select("dark_color");  
      }

      if(font_size=="18"){

        if(font_style=='Times Roman'){            
          rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "18px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "18px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "18px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

        rendition.themes.select("dark_color");  
      }


      if(font_size=="20"){

        if(font_style=='Times Roman'){            
          rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "20px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "20px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("dark_color", {
                 body: {                   
                  "background-color": "black !important",
                  "font-size": "20px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "white !important",
                },
          });
        }

        rendition.themes.select("dark_color");  
      }
              
    });

   // light theme =====================================================


    var light_theme = document.getElementById("light-theme");    
    light_theme.addEventListener("click", function(e){    

      background="light";
      // rendition.themes.select("light");  
      
     if(font_size=="10"){

       if(font_style=='Times Roman'){            
          rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "10px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "10px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "10px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

        rendition.themes.select("light_color");  
      }

      if(font_size=="11"){

               if(font_style=='Times Roman'){            
          rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "11px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "11px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "11px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

        rendition.themes.select("light_color");  
      }

      if(font_size=="12"){

       if(font_style=='Times Roman'){            
          rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "12px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "12px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "12px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

        rendition.themes.select("light_color");  
      }

      if(font_size=="13"){

        if(font_style=='Times Roman'){            
          rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "13px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "13px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "13px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

        rendition.themes.select("light_color");  
      }

      if(font_size=="15"){

          if(font_style=='Times Roman'){            
          rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "15px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "15px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "15px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

        rendition.themes.select("light_color");  
      }

      if(font_size=="16"){

           if(font_style=='Times Roman'){            
          rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "16px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "16px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "16px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

        rendition.themes.select("light_color");  
      }

      if(font_size=="18"){
         if(font_style=='Times Roman'){            
          rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "18px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "18px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "18px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

        rendition.themes.select("light_color");  
      }

      if(font_size=="20"){

        if(font_style=='Times Roman'){            
          rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "20px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "20px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("light_color", {
                 body: {                   
                  "background-color": "white !important",
                  "font-size": "20px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "black !important",
                },
          });
        }

        rendition.themes.select("light_color");  
      }

     
      });


   // septia theme===========================================================


     var septia_theme = document.getElementById("septia-theme");    
     septia_theme.addEventListener("click", function(e){    

       background="septia";      
        // rendition.themes.select("septia");  

      if(font_size=="10"){

        if(font_style=='Times Roman'){            
          rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "10px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "10px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "10px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

        rendition.themes.select("septia_color");  
      }

      if(font_size=="11"){

    
        if(font_style=='Times Roman'){            
          rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "11px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "11px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "11px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

        rendition.themes.select("septia_color");  
      }

      if(font_size=="12"){

       if(font_style=='Times Roman'){            
          rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "12px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "12px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "12px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

        rendition.themes.select("septia_color");  
      }

      if(font_size=="13"){
         if(font_style=='Times Roman'){            
          rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "13px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "13px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "13px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

        rendition.themes.select("septia_color");  
      }

      if(font_size=="15"){

       if(font_style=='Times Roman'){            
          rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "15px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "15px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "15px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

        rendition.themes.select("septia_color");  
      }

      if(font_size=="16"){

      if(font_style=='Times Roman'){            
          rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "16px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "16px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "16px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

        rendition.themes.select("septia_color");  
      }

      if(font_size=="18"){

   if(font_style=='Times Roman'){            
          rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "20px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "20px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "20px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

        rendition.themes.select("septia_color");  
      }

      if(font_size=="20"){

       if(font_style=='Times Roman'){            
          rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "20px !important",
                  "font-family": "Times New Roman, Times, serif !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

       if(font_style=='Helvetica'){            
          rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "20px !important",
                  "font-family": "Arial, Helvetica, sans-serif !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

        if(font_style=='Lucida'){            
            rendition.themes.register("septia_color", {
                 body: {                   
                  "background-color": "#f4eacd !important",
                  "font-size": "20px !important",
                  "font-family": "Lucida Console, Courier New, monospace !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
          });
        }

        rendition.themes.select("septia_color");  
      }             
        
      });
      
     // End Theme=============
     

     // Set Font Size==========
      var font_10 = document.getElementById("font_10");
      font_10.addEventListener("click", function(e){   

      font_size="10";

      if(background=='light'){

          rendition.themes.register("custom_font_10", {
              body: {     
                "background-color": "white !important",                        
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });

         rendition.themes.select("custom_font_10");          
         
      }

      if(background=='dark'){

          rendition.themes.register("custom_font_10", {
              body: {     
                "background-color": "black !important",                        
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });

         rendition.themes.select("custom_font_10");          
         

      }

       if(background=='septia'){

          rendition.themes.register("custom_font_10", {
              body: {     
                "background-color": "#f4eacd !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });

         rendition.themes.select("custom_font_10");                   
      }
          

      });

       var font_11 = document.getElementById("font_11");
      font_11.addEventListener("click", function(e){ 

      font_size="11";  

      if(background=='light'){

          rendition.themes.register("custom_font_11", {
              body: {     
                "background-color": "white !important",                        
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });

         rendition.themes.select("custom_font_11");          
         
      }

      if(background=='dark'){

          rendition.themes.register("custom_font_11", {
              body: {     
                "background-color": "black !important",                        
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });

         rendition.themes.select("custom_font_11");                   
      }

       if(background=='septia'){

          rendition.themes.register("custom_font_11", {
              body: {     
                "background-color": "#f4eacd !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });

         rendition.themes.select("custom_font_11");                   
      }

      });

      var font_12 = document.getElementById("font_12");
      font_12.addEventListener("click", function(e){    

      font_size="12";  

        if(background=='light'){

          rendition.themes.register("custom_font_12", {
              body: {     
                "background-color": "white !important",                        
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });

         rendition.themes.select("custom_font_12");                   
      }

      if(background=='dark'){

          rendition.themes.register("custom_font_12", {
              body: {     
                "background-color": "black !important",                        
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });

         rendition.themes.select("custom_font_12");                   

      }

       if(background=='septia'){

          rendition.themes.register("custom_font_12", {
              body: {     
                "background-color": "#f4eacd !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });

         rendition.themes.select("custom_font_12");                   

      }

      });

      var font_13 = document.getElementById("font_13");
      font_13.addEventListener("click", function(e){    

        font_size="13";  

        if(background=='light'){

          rendition.themes.register("custom_font_13", {
              body: {     
                "background-color": "white !important",                        
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });

         rendition.themes.select("custom_font_13");          
         
      }

      if(background=='dark'){

          rendition.themes.register("custom_font_13", {
              body: {     
                "background-color": "black !important",                        
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });

         rendition.themes.select("custom_font_13");                   
      }

       if(background=='septia'){

          rendition.themes.register("custom_font_13", {
              body: {     
                "background-color": "#f4eacd !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });

         rendition.themes.select("custom_font_13");                   
      }

      });

      var font_15 = document.getElementById("font_15");
      font_15.addEventListener("click", function(e){   

      font_size="15";           
        
        if(background=='light'){

          rendition.themes.register("custom_font_15", {
              body: {     
                "background-color": "white !important",                        
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });

         rendition.themes.select("custom_font_15");                   
      }

      if(background=='dark'){

          rendition.themes.register("custom_font_15", {
              body: {     
                "background-color": "black !important",                        
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });

         rendition.themes.select("custom_font_15");                   
      }

       if(background=='septia'){

          rendition.themes.register("custom_font_15", {
              body: {     
                "background-color": "#f4eacd !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });

         rendition.themes.select("custom_font_15");          
         
      }

      });

      var font_16 = document.getElementById("font_16");
      font_16.addEventListener("click", function(e){   

      font_size="16";                    
            
        if(background=='light'){

          rendition.themes.register("custom_font_16", {
              body: {     
                "background-color": "white !important",                        
                "font-size": "16px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });

         rendition.themes.select("custom_font_16");          
         
      }

      if(background=='dark'){

          rendition.themes.register("custom_font_16", {
              body: {     
                "background-color": "black !important",                        
                "font-size": "16px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });

         rendition.themes.select("custom_font_16");                   

      }

       if(background=='septia'){

          rendition.themes.register("custom_font_16", {
              body: {     
                "background-color": "#f4eacd !important",
                "font-size": "16px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });

         rendition.themes.select("custom_font_16");                   
      }

      });

      var font_18 = document.getElementById("font_18");
      font_18.addEventListener("click", function(e){  

      font_size="18";                      

      if(background=='light'){

          rendition.themes.register("custom_font_18", {
              body: {     
                "background-color": "white !important",                        
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });

         rendition.themes.select("custom_font_18");          
         
      }

      if(background=='dark'){

          rendition.themes.register("custom_font_18", {
              body: {     
                "background-color": "black !important",                        
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });

         rendition.themes.select("custom_font_18");                   
      }

       if(background=='septia'){

          rendition.themes.register("custom_font_18", {
              body: {     
                "background-color": "#f4eacd !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });

         rendition.themes.select("custom_font_18");          
         
       }
             
      });

      var font_20 = document.getElementById("font_20");
      font_20.addEventListener("click", function(e){ 

      font_size="20";                    

         if(background=='light'){

          rendition.themes.register("custom_font_20", {
              body: {     
                "background-color": "white !important",                        
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });

         rendition.themes.select("custom_font_20");                   
      }

      if(background=='dark'){

          rendition.themes.register("custom_font_20", {
              body: {     
                "background-color": "black !important",                        
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });

         rendition.themes.select("custom_font_20");                   
      }

       if(background=='septia'){

          rendition.themes.register("custom_font_20", {
              body: {     
                "background-color": "#f4eacd !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });

         rendition.themes.select("custom_font_20");                          
       }           

      });
    
    // End Set Font Size==================================

    // Set Margin Size=====================================
    var margin_0 = document.getElementById("margin_0");
      margin_0.addEventListener("click", function(e){  


      if(background=='light'){

        if(font_size=="10"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "white !important",                        
                "margin": "0px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="11"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "white !important",                        
                "margin": "0px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="12"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "white !important",                        
                "margin": "0px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="13"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "white !important",                        
                "margin": "0px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }


        if(font_size=="15"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "white !important",                        
                "margin": "0px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="16"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                 "background-color": "white !important",                        
                 "margin": "2px !important",
                 "font-size": "16px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="18"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "white !important",                        
                "margin": "0px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="20"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "white !important",                        
                "margin": "0px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

      
         rendition.themes.select("custom_margin_0");                   

      }

      if(background=='dark'){

         if(font_size=="10"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "black !important",                        
                "margin": "0px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="11"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "black !important",                        
                "margin": "0px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="12"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "black !important",                        
                "margin": "0px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }


        if(font_size=="13"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "black !important",                        
                "margin": "0px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="13"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "black !important",                        
                "margin": "0px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="15"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "black !important",                        
                "margin": "0px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="16"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                 "background-color": "black !important",                        
                 "margin": "2px !important",
                 "font-size": "16px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

       if(font_size=="18"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "black !important",                        
                "margin": "0px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }


       if(font_size=="20"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "black !important",                        
                "margin": "0px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

         rendition.themes.select("custom_margin_0");                   
      }

      if(background=='septia'){

        if(font_size=="10"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "0px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

       if(font_size=="11"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "0px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

       if(font_size=="12"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "0px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

       if(font_size=="13"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "0px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

       if(font_size=="15"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "0px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="16"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                 "background-color": "#f4eacd !important",                      
                 "margin": "2px !important",
                 "font-size": "16px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        } 

        if(font_size=="18"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "0px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="20"){
          rendition.themes.register("custom_margin_0", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "0px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

         rendition.themes.select("custom_margin_0");                          
       }     
            
      });

      var margin_2 = document.getElementById("margin_2");
      margin_2.addEventListener("click", function(e){            
        

      if(background=='light'){


        if(font_size=="10"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "white !important",                        
                "margin": "2px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="11"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "white !important",                        
                "margin": "2px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="12"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "white !important",                        
                "margin": "2px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="13"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "white !important",                        
                "margin": "2px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }


        if(font_size=="15"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "white !important",                        
                "margin": "2px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="16"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                 "background-color": "white !important",                        
                 "margin": "2px !important",
                 "font-size": "16px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }  

        if(font_size=="18"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "white !important",                        
                "margin": "2px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="20"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "white !important",                        
                "margin": "2px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

         rendition.themes.select("custom_margin_2");                   
      }

      if(background=='dark'){

       if(font_size=="10"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "black !important",                        
                "margin": "2px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="11"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "black !important",                        
                "margin": "2px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="12"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "black !important",                        
                "margin": "2px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }


        if(font_size=="13"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "black !important",                        
                "margin": "2px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="13"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "black !important",                        
                "margin": "2px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="15"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "black !important",                        
                "margin": "2px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="16"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                 "background-color": "black !important",                        
                 "margin": "2px !important",
                 "font-size": "16px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }  

       if(font_size=="18"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "black !important",                        
                "margin": "2px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }


       if(font_size=="20"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "black !important",                        
                "margin": "2px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }
         rendition.themes.select("custom_margin_2");                   
      }

      if(background=='septia'){

        if(font_size=="10"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "2px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

       if(font_size=="11"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "2px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

       if(font_size=="12"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "2px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

       if(font_size=="13"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "2px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

       if(font_size=="15"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "2px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="16"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                 "background-color": "#f4eacd !important",                      
                 "margin": "2px !important",
                 "font-size": "16px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }  

        if(font_size=="18"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "2px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="20"){
          rendition.themes.register("custom_margin_2", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "2px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }
         rendition.themes.select("custom_margin_2");                          
       }

      });
        
     var margin_4 = document.getElementById("margin_4");
      margin_4.addEventListener("click", function(e){    

      if(background=='light'){

          if(font_size=="10"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "white !important",                        
                "margin": "4px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="11"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "white !important",                        
                "margin": "4px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="12"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "white !important",                        
                "margin": "4px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="13"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "white !important",                        
                "margin": "4px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="15"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "white !important",                        
                "margin": "4px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

       if(font_size=="16"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                 "background-color": "white !important",                        
                 "margin": "4px !important",
                 "font-size": "16px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }  

        if(font_size=="18"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "white !important",                        
                "margin": "4px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="20"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "white !important",                        
                "margin": "4px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          })
         rendition.themes.select("custom_margin_4");                   
         }
   
      }
       
      if(background=='dark'){

         if(font_size=="10"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "black !important",                        
                "margin": "4px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="11"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "black !important",                        
                "margin": "4px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="12"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "black !important",                        
                "margin": "4px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }


        if(font_size=="13"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "black !important",                        
                "margin": "4px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="13"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "black !important",                        
                "margin": "4px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="15"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "black !important",                        
                "margin": "4px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="16"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                 "background-color": "black !important",                        
                 "margin": "4px !important",
                 "font-size": "16px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }  

       if(font_size=="18"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "black !important",                        
                "margin": "4px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

       if(font_size=="20"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "black !important",                        
                "margin": "4px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

         rendition.themes.select("custom_margin_4");                   
      }

     if(background=='septia'){

     if(font_size=="10"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "4px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

       if(font_size=="11"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "4px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

       if(font_size=="12"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "4px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

       if(font_size=="13"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "4px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

       if(font_size=="15"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "4px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="16"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                 "background-color": "#f4eacd !important",                      
                 "margin": "4px !important",
                 "font-size": "16px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }  

        if(font_size=="18"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "4px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="20"){
          rendition.themes.register("custom_margin_4", {
              body: {     
                "background-color": "#f4eacd !important",                      
                "margin": "4px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }
         rendition.themes.select("custom_margin_4");                          
       }


      });
        
      var margin_6 = document.getElementById("margin_6");
      margin_6.addEventListener("click", function(e){   

        if(background=='light'){

         if(font_size=="10"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "white !important",   
                "margin": "6px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="11"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "white !important",   
                "margin": "6px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="12"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "white !important",   
                "margin": "6px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="13"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "white !important",   
                "margin": "6px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="15"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "white !important",   
                "margin": "6px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="16"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "white !important",   
                 "margin": "6px !important",
                 "font-size": "16px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }  

        if(font_size=="18"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "white !important",   
                "margin": "6px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="20"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "white !important",   
                "margin": "6px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

         rendition.themes.select("custom_margin_6");                   
      }

      if(background=='dark'){

        if(font_size=="10"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "black !important",                        
                "margin": "6px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="11"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "black !important",                        
                "margin": "6px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="12"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "black !important",                        
                "margin": "6px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="13"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "black !important",                        
                "margin": "6px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

       if(font_size=="15"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "black !important",                        
                "margin": "6px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        } 

        if(font_size=="16"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "black !important",                        
                 "margin": "6px !important",
                 "font-size": "16px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }        

        if(font_size=="18"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "black !important",                        
                "margin": "6px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="20"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "black !important",                        
                "margin": "6px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

         rendition.themes.select("custom_margin_6");                   
      }

      if(background=='septia'){

        if(font_size=="10"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "6px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }


        if(font_size=="11"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "6px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }


        if(font_size=="12"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "6px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="13"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "6px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="15"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "6px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="16"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "#f4eacd !important",
                 "margin": "6px !important",
                 "font-size": "16px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }  

        if(font_size=="18"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "6px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="20"){
          rendition.themes.register("custom_margin_6", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "6px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

         rendition.themes.select("custom_margin_6");                          
       }          

      });
        
      var margin_8 = document.getElementById("margin_8");
      margin_8.addEventListener("click", function(e){            
       
      if(background=='light'){

          if(font_size=="10"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "white !important",   
                "margin": "8px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="11"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "white !important",   
                "margin": "8px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="12"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "white !important",   
                "margin": "8px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="13"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "white !important",   
                "margin": "8px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="15"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "white !important",   
                "margin": "8px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="16"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "white !important",   
                 "margin": "8px !important",
                 "font-size": "16px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }  

        if(font_size=="18"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "white !important",   
                "margin": "8px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }


        if(font_size=="20"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "white !important",   
                "margin": "8px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }


         rendition.themes.select("custom_margin_8");                   
      }

      if(background=='dark'){


        if(font_size=="10"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "black !important",                        
                "margin": "8px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="11"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "black !important",                        
               "margin": "8px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="12"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "black !important",                        
               "margin": "8px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="13"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "black !important",                        
               "margin": "8px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

       if(font_size=="15"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "black !important",                        
               "margin": "8px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        } 

        if(font_size=="16"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "black !important",                        
                 "margin": "8px !important",
                 "font-size": "16px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }        

        if(font_size=="18"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "black !important",                        
               "margin": "8px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="20"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "black !important",                        
               "margin": "8px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

         rendition.themes.select("custom_margin_8");                   
      }

      if(background=='septia'){

        if(font_size=="10"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "8px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }


        if(font_size=="11"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "8px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }


        if(font_size=="12"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "8px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="13"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "8px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="15"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "8px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="16"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "#f4eacd !important", 
                 "margin": "8px !important",
                 "font-size": "16px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }  

        if(font_size=="18"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "8px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="20"){
          rendition.themes.register("custom_margin_8", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "8px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

         rendition.themes.select("custom_margin_8");                          
       }          

      });

      var margin_10 = document.getElementById("margin_10");
      margin_10.addEventListener("click", function(e){    

       if(background=='light'){

        if(font_size=="10"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "white !important",   
                "margin": "10px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="11"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "white !important",   
                "margin": "10px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="12"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "white !important",   
                "margin": "10px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="13"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "white !important",   
                "margin": "10px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="15"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "white !important",   
                "margin": "10px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

      if(font_size=="16"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "white !important",   
                 "margin": "10px !important",
                 "font-size": "16px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }  

        if(font_size=="18"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "white !important",   
                "margin": "10px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }


        if(font_size=="20"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "white !important",   
                "margin": "10px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

         rendition.themes.select("custom_margin_10");                   
      }

      if(background=='dark'){

         if(font_size=="10"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "black !important",                        
                "margin": "8px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="11"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "black !important",                        
               "margin": "10px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="12"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "black !important",                        
               "margin": "10px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="13"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "black !important",                        
               "margin": "10px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

       if(font_size=="15"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "black !important",                        
               "margin": "10px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }   

       if(font_size=="16"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "black !important",                        
                 "margin": "10px !important",
                 "font-size": "16px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }      

        if(font_size=="18"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "black !important",                        
               "margin": "10px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="20"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "black !important",                        
               "margin": "10px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

         rendition.themes.select("custom_margin_10");                   
      }

      if(background=='septia'){

        if(font_size=="10"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "10px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }


        if(font_size=="11"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "10px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }


        if(font_size=="12"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "10px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="13"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "10px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="15"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "10px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="16"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "#f4eacd !important",
                 "margin": "10px !important",
                 "font-size": "16px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }  

        if(font_size=="18"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "10px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="20"){
          rendition.themes.register("custom_margin_10", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "10px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

         rendition.themes.select("custom_margin_10");                          
       } 

      });

      var margin_12 = document.getElementById("margin_12");
      margin_12.addEventListener("click", function(e){  

      if(background=='light'){

          if(font_size=="10"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "white !important",   
                "margin": "12px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="11"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "white !important",   
                "margin": "12px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="12"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "white !important",   
                "margin": "12px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="13"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "white !important",   
                "margin": "12px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

        if(font_size=="15"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "white !important",   
                "margin": "12px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

       if(font_size=="16"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "white !important",   
                 "margin": "12px !important",
                 "font-size": "16px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }  

        if(font_size=="18"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "white !important",   
                "margin": "12px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }


        if(font_size=="20"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "white !important",   
                "margin": "12px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "black !important",
              },
          });
        }

         rendition.themes.select("custom_margin_12");                   
      }

      if(background=='dark'){

         if(font_size=="10"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "black !important",                        
                "margin": "12px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="11"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "black !important",                        
               "margin": "12px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="12"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "black !important",                        
               "margin": "12px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="13"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "black !important",                        
               "margin": "12px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

       if(font_size=="15"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "black !important",                        
                 "margin": "12px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }   

        if(font_size=="16"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "black !important",                        
                 "margin": "12px !important",
                "font-size": "16px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }      

        if(font_size=="18"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "black !important",                        
               "margin": "12px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

        if(font_size=="20"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "black !important",                        
               "margin": "12px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "white !important",
              },
          });
        }

         rendition.themes.select("custom_margin_12");                   
      }

      if(background=='septia'){


        if(font_size=="10"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "12px !important",
                "font-size": "10px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }


        if(font_size=="11"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "12px !important",
                "font-size": "11px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }


        if(font_size=="12"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "12px !important",
                "font-size": "12px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="13"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "12px !important",
                "font-size": "13px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="15"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "12px !important",
                "font-size": "15px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="16"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "#f4eacd !important",
                 "margin": "12px !important",
                 "font-size": "16px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }  

        if(font_size=="18"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "12px !important",
                "font-size": "18px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

        if(font_size=="20"){
          rendition.themes.register("custom_margin_12", {
              body: {     
                 "background-color": "#f4eacd !important",
                "margin": "12px !important",
                "font-size": "20px !important",
              },
              "p": {                   
                "color": "#704214 !important",
              },
          });
        }

         rendition.themes.select("custom_margin_12");                          
       } 
        
      });

   // End of Margin=======================================================
  
    //Set Font Style======================================================
    var font_helvetica = document.getElementById("font_helvetica");
      font_helvetica.addEventListener("click", function(e){  
       
      font_style="Helvetica";

      if(background=='light'){

          if(font_size=="10"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "white !important",                        
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "10px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

          if(font_size=="11"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "white !important",                        
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "11px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

          if(font_size=="12"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "white !important",                        
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "12px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

          if(font_size=="13"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "white !important",                        
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "13px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }


          if(font_size=="15"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "white !important",                        
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "15px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

          if(font_size=="16"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "white !important",                        
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "16px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }


          if(font_size=="18"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "white !important",                        
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "18px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

          if(font_size=="20"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "white !important",                        
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "20px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

         rendition.themes.select("custom_font_helvetica");                   
      }

      if(background=='dark'){

         if(font_size=="10"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "black !important",                        
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "10px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

           if(font_size=="11"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "black !important",                        
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "11px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

          if(font_size=="12"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "black !important",                        
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "12px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

          if(font_size=="13"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "black !important",                        
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "13px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

           if(font_size=="15"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "black !important",                        
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "15px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

            if(font_size=="16"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "black !important",                        
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "16px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

            if(font_size=="18"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "black !important",                        
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "18px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

           if(font_size=="20"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "black !important",                        
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "20px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

         rendition.themes.select("custom_font_helvetica");                   
      }

      if(background=='septia'){

           if(font_size=="10"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "#f4eacd !important",                  
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "10px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

          if(font_size=="11"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "#f4eacd !important",                  
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "11px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

          if(font_size=="12"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "#f4eacd !important",                  
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "12px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

          if(font_size=="13"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "#f4eacd !important",                  
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "13px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

         if(font_size=="15"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "#f4eacd !important",                  
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "15px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

          if(font_size=="18"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "#f4eacd !important",                  
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "18px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

          if(font_size=="20"){
                rendition.themes.register("custom_font_helvetica", {
                body: {     
                  "background-color": "#f4eacd !important",                  
                  "font-family": "Arial, Helvetica, sans-serif !important",
                  "font-size": "20px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

 
         rendition.themes.select("custom_font_helvetica");                          
       } 
                     
      });

      var font_times = document.getElementById("font_times");
      font_times.addEventListener("click", function(e){  

      font_style="Times Roman";

       if(background=='light'){


         if(font_size=="10"){
                rendition.themes.register("custom_font_times", {
                body: {     
                  "background-color": "white !important",                        
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "10px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

           if(font_size=="11"){
                rendition.themes.register("custom_font_times", {
                body: {     
                  "background-color": "white !important",                      
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "11px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

          if(font_size=="12"){
                rendition.themes.register("custom_font_times", {
                body: {     
                  "background-color": "white !important",                      
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "12px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

          if(font_size=="13"){
                rendition.themes.register("custom_font_times", {
                body: {     
                  "background-color": "white !important",                      
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "13px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

           if(font_size=="15"){
                rendition.themes.register("custom_font_times", {
                body: {     
                  "background-color": "white !important",                      
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "15px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

            if(font_size=="16"){
                rendition.themes.register("custom_font_times", {
                body: {     
                  "background-color": "white !important",                      
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "16px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

            if(font_size=="18"){
                rendition.themes.register("custom_font_times", {
                body: {     
                  "background-color": "white !important",                      
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "18px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

           if(font_size=="20"){
                rendition.themes.register("custom_font_times", {
                body: {     
                  "background-color": "white !important",                      
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "20px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }


         rendition.themes.select("custom_font_times");                   
      }

      if(background=='dark'){


           if(font_size=="10"){
                rendition.themes.register("custom_font_times", {
                body: {     
                  "background-color": "black !important",                        
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "10px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

           if(font_size=="11"){
                rendition.themes.register("custom_font_times", {
                body: {     
                  "background-color": "black !important",                        
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "11px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

          if(font_size=="12"){
                rendition.themes.register("custom_font_times", {
                body: {     
                  "background-color": "black !important",                        
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "12px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

          if(font_size=="13"){
                rendition.themes.register("custom_font_times", {
                body: {     
                  "background-color": "black !important",                        
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "13px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

           if(font_size=="15"){
                rendition.themes.register("custom_font_times", {
                body: {     
                  "background-color": "black !important",                        
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "15px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

            if(font_size=="16"){
                rendition.themes.register("custom_font_times", {
                body: {     
                  "background-color": "black !important",                        
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "16px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

            if(font_size=="18"){
                rendition.themes.register("custom_font_times", {
                body: {     
                  "background-color": "black !important",                        
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "18px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

           if(font_size=="20"){
                rendition.themes.register("custom_font_times", {
                body: {     
                  "background-color": "black !important",                        
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "20px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

         rendition.themes.select("custom_font_times");                   
      }

      if(background=='septia'){

 
            if(font_size=="10"){
                rendition.themes.register("custom_font_times", {
                body: {     
                  "background-color": "#f4eacd !important",
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "10px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

           if(font_size=="11"){
                rendition.themes.register("custom_font_times", {
                body: {     
                   "background-color": "#f4eacd !important",
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "11px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

          if(font_size=="12"){
                rendition.themes.register("custom_font_times", {
                body: {     
                   "background-color": "#f4eacd !important",
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "12px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

          if(font_size=="13"){
                rendition.themes.register("custom_font_times", {
                body: {     
                   "background-color": "#f4eacd !important",
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "13px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

           if(font_size=="15"){
                rendition.themes.register("custom_font_times", {
                body: {     
                   "background-color": "#f4eacd !important",
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "15px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

            if(font_size=="16"){
                rendition.themes.register("custom_font_times", {
                body: {     
                   "background-color": "#f4eacd !important",
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "16px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

            if(font_size=="18"){
                rendition.themes.register("custom_font_times", {
                body: {     
                   "background-color": "#f4eacd !important",
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "18px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

           if(font_size=="20"){
                rendition.themes.register("custom_font_times", {
                body: {     
                   "background-color": "#f4eacd !important",
                  "font-family": "Times New Roman, Times, serif !important",
                  "font-size": "20px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }


         rendition.themes.select("custom_font_times");                          
       } 

              
      });
    
      var font_lucida = document.getElementById("font_lucida");
      font_lucida.addEventListener("click", function(e){    

     font_style="Lucida";

     if(background=='light'){


          if(font_size=="10"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "white !important",                        
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "10px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

           if(font_size=="11"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "white !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "11px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

          if(font_size=="12"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "white !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "12px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

          if(font_size=="13"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "white !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "13px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

           if(font_size=="15"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "white !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "15px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

            if(font_size=="16"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "white !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "16px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

            if(font_size=="18"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "white !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "18px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

           if(font_size=="20"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "white !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "20px !important",
                },
                "p": {                   
                  "color": "black !important",
                },
            });    
          }

         rendition.themes.select("custom_font_lucida");                   
      }

      if(background=='dark'){

          if(font_size=="10"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "black !important",                        
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "10px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

          if(font_size=="11"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "black !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "11px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

          if(font_size=="12"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "black !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "12px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

          if(font_size=="13"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "black !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "13px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

           if(font_size=="15"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "black !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "15px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

            if(font_size=="16"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "black !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "16px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

            if(font_size=="18"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "black !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "18px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

           if(font_size=="20"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "black !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "20px !important",
                },
                "p": {                   
                  "color": "white !important",
                },
            });    
          }

         rendition.themes.select("custom_font_lucida");                   
      }

      if(background=='septia'){

            if(font_size=="10"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "#f4eacd !important",                        
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "10px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

          if(font_size=="11"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "#f4eacd !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "11px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

          if(font_size=="12"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "#f4eacd !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "12px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

          if(font_size=="13"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "#f4eacd !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "13px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

           if(font_size=="15"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "#f4eacd !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "15px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

            if(font_size=="16"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "#f4eacd !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "16px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

            if(font_size=="18"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "#f4eacd !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "18px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

           if(font_size=="20"){
                rendition.themes.register("custom_font_lucida", {
                body: {     
                  "background-color": "#f4eacd !important",                      
                  "font-family": "Lucida Console, Courier New, monospace !important",
                  "font-size": "20px !important",
                },
                "p": {                   
                  "color": "#704214 !important",
                },
            });    
          }

         rendition.themes.select("custom_font_lucida");                          
       } 

            
      });
    
    
     // End Set Custome Theme===============================================================

    book.ready.then(() => {

      var next = document.getElementById("next");
      next.addEventListener("click", function(e){        
        book.package.metadata.direction === "rtl" ? rendition.prev() : rendition.next();

       var $select = document.getElementById("toc");
       index=$select.selectedIndex+1; 

        var $ChapterNo = document.getElementById("BookMarkIndex");
        $ChapterNo.value=index;  
                    
        e.preventDefault();      
      }, false);

      var prev = document.getElementById("prev");
      prev.addEventListener("click", function(e){
        book.package.metadata.direction === "rtl" ? rendition.next() : rendition.prev();    
       
       var $select = document.getElementById("toc");
       index=$select.selectedIndex-1; 

       var $ChapterNo = document.getElementById("BookMarkIndex");
        $ChapterNo.value=index;     
        
      }, false);

      var keyListener = function(e){

        // Left Key
        if ((e.keyCode || e.which) == 37) {
          book.package.metadata.direction === "rtl" ? rendition.next() : rendition.prev();
        }

        // Right Key
        if ((e.keyCode || e.which) == 39) {
          book.package.metadata.direction === "rtl" ? rendition.prev() : rendition.next();
        }

      };

      rendition.on("keyup", keyListener);
      document.addEventListener("keyup", keyListener, false);

    })

    var title = document.getElementById("title");

    rendition.on("rendered", function(section){
      var current = book.navigation && book.navigation.get(section.href);

      if (current) {
        var $select = document.getElementById("toc");
        var $selected = $select.querySelector("option[selected]");
        if ($selected) {
          $selected.removeAttribute("selected");
        }

        var $options = $select.querySelectorAll("option");
        for (var i = 0; i < $options.length; ++i) {
          let selected = $options[i].getAttribute("ref") === current.href;
          if (selected) {
            $options[i].setAttribute("selected", "");
          }
        }
      }

    });

    rendition.on("relocated", function(location){
      console.log(location);

      var next = book.package.metadata.direction === "rtl" ?  document.getElementById("prev") : document.getElementById("next");
      var prev = book.package.metadata.direction === "rtl" ?  document.getElementById("next") : document.getElementById("prev");

      if (location.atEnd) {
        next.style.visibility = "hidden";
      } else {
        next.style.visibility = "visible";
      }

      if (location.atStart) {
        prev.style.visibility = "hidden";
      } else {
        prev.style.visibility = "visible";
      }
      
    });

    rendition.on("layout", function(layout) {

      let viewer = document.getElementById("viewer");

      if (layout.spread) {
        viewer.classList.remove('single');
      } else {
        viewer.classList.add('single');
      }
    });

    window.addEventListener("unload", function () {
      console.log("unloading");
      this.book.destroy();
    });

    book.loaded.navigation.then(function(toc){
      var $select = document.getElementById("toc"),
          docfrag = document.createDocumentFragment();

      toc.forEach(function(chapter) {
        var option = document.createElement("option");
        option.textContent = chapter.label;
        option.setAttribute("ref", chapter.href);

        docfrag.appendChild(option);
      });

      $select.appendChild(docfrag);

      $select.onchange = function(){
           index = $select.selectedIndex,
              url = $select.options[index].getAttribute("ref");
          rendition.display(url);

           var $ChapterNo = document.getElementById("BookMarkIndex");
           $ChapterNo.value=index;   
          
          return false;
      };
    });

  </script>

  <script>
    function openSidePanelNav() {
    document.getElementById("CartPanel").style.right = "0px";
   }
   function closeSidePanelNav() {
    document.getElementById("CartPanel").style.right = "-315px";
   }
  </script>
  

  </body>
</html>
