
<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8" />
 
  <meta http-equiv="Content-Security-Policy" content="default-src * 'unsafe-inline' 'unsafe-eval' data: blob:;">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Precious Epub Viewer</title>

  
  <link rel="stylesheet" type="text/css" href="https://www.api.ebooklat.phr.com.ph/public/api/css/epub-main-style.css">

  <script src="https://www.api.ebooklat.phr.com.ph/public/api/js/jszip.min.js"></script>
  <script src="https://www.api.ebooklat.phr.com.ph/public/api/js/localforage.min.js"></script>  
  <script src="https://www.api.ebooklat.phr.com.ph/public/api/js/epub.js"></script>
  
  <style>
   #toc{    
    width: 100%;
    background: #e6e6e6;
    padding: 5px;
    display: block;
    font-size: 13px;    
    z-index:999;
    width: 98%;
   }

/*   #viewer{
    padding-top:20px;
    padding-bottom:40px;
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
  </style>

   
</head>
<body>
  <!-- <div id="title"></div> -->
  
@if($epub_file_exist)
  
  
  <div style="display:flex;top: 0px;right:0px;background: lightgray;height: 40px;z-index: 99999;">
    <select id="toc" style="font-size:15px;padding:5px !important;float:left;"></select>
        <div style="padding-right: 20px;cursor: pointer;width: 2%; display: contents;padding-left: 4px; color: #fff;">        
        <img src="https://www.api.ebooklat.phr.com.ph/public/api/img/menu-icon.png" onclick="openSidePanelNav()" style="width: 40px;">                
    </div>
  </div>
   
  <div id="viewer" class="spreads" style="font-size:30px;"></div>
    
  <!-- height spacer -->
  <div style="height: 40px;"></div>
  
  <div style="height:44px;position: fixed;z-index: 999;bottom:0px;text-align:center;width:100%;background: #0c2136;">
        <a id="prev" href="#prev" class="arrow" style="font-size:23px;color:white;padding-right:20px;"><span style="font-size:15px;">Prev </span>‹</a>
        <a id="next" href="#next" class="arrow"style="font-size:23px;color:white;padding-left:20px;">›<span style="font-size:15px;"> Next</span></a>
  </div>

  <div id="CartPanel" class="sidenav" style="right: -315px;width: 260px;">
      <div id="SidePanelCartDetail" class="header-wrapper sticky-area" style="display: block; background: gray !important;padding-top: 10px;">
        <div class="container" style="padding-left: 5px;">
            <div class="topbar d-flex" style="border-bottom: 1.2px solid rgba(255,255,255,.5);">
              <div class="topbar-item-right d-flex ">
                  <div class="item">
                    <div style="display:flex;">
                    <img src="https://www.api.ebooklat.phr.com.ph/public/api/img/close-button.png" onclick="closeSidePanelNav()" style="color:#fff;font-family: work sans,sans-serif;cursor: pointer;width: 30px;height: 30px;">  
                    <span style="color:#fff;padding-left: 50px;">:: Settings ::</span>
                    </div>
                  </div>
              </div>
            </div>

            <!--    <div class="row" style="background:#2e3c5f;padding-top: 5px;padding-bottom: 5px;">
                    <div class="container">
                          <h2 class="mb-1 text-white" style="font-size: 15px;color: #fff !important;text-align: center;">
                            Set Theme
                          </h2>
                    </div>
                </div> -->
          </div>
      </div>

        <div class="row" style="margin-right: 0px;margin-left: 0px;"> 
            <div class="table-responsive-md" style="width: 100%;">                  
                <table class="table table-style-01" style="width:100%;">
                  <tbody> 

                      <tr style="border-bottom:1px dashed gray;">
                        <td id="dark-theme" style="vertical-align: middle;display: flex; cursor: pointer">
                            <img src="https://www.api.ebooklat.phr.com.ph/public/api/img/dark-mode.png" alt="dark-mode" style="width: 40px;height: 40;"> <span style="padding-left:20px;position: relative;top: 10px;">Dark Theme</span>
                        </td>
                      </tr> 
                      <tr style="border-bottom:1px dashed gray;">
                        <td id="light-theme" style="vertical-align: middle;display: flex;cursor: pointer">
                            <img  src="https://www.api.ebooklat.phr.com.ph/public/api/img/light-mode.png" alt="light-mode" style="width: 40px;height: 40;"> <span style="padding-left:20px;position: relative;top: 10px;">Light Theme</span>
                        </td>
                      </tr> 
                      <tr style="border-bottom:1px dashed gray;">
                        <td id="septia-theme" style="vertical-align: middle;display: flex;cursor: pointer;">
                            <img src="https://www.api.ebooklat.phr.com.ph/public/api/img/septia-mode.png" alt="septia-mode" style="width: 40px;height: 40;">  <span style="padding-left:20px;position: relative;top: 10px;">Sepia Theme</span>
                        </td>
                      </tr>  
                    
                 <!--      <tr>
                        <td>
                          <div class="row" style="background:#2e3c5f;padding-top: 7px;padding-bottom: 7px;">
                              <div class="container">
                                    <h2 class="mb-1 text-white" style="font-size: 15px;color: #fff !important;text-align: center;">
                                      Set Font Size
                                    </h2>
                              </div>
                          </div>
                        </td>
                      </tr> --> 


                     <tr style="border-bottom:1px dashed gray;">
                        <td id="font_10" style="vertical-align: middle;display: flex; cursor: pointer">
                            <img src="https://www.api.ebooklat.phr.com.ph/public/api/img/font-size.png" alt="extra-small-font" style="width: 40px;height: 40;"> <span style="padding-left:20px;position: relative;top: 10px;">Extra Small Font Size</span>
                        </td>
                      </tr> 
                      <tr style="border-bottom:1px dashed gray;">
                        <td id="font_13" style="vertical-align: middle;display: flex; cursor: pointer">
                            <img src="https://www.api.ebooklat.phr.com.ph/public/api/img/font-size.png" alt="small-font" style="width: 40px;height: 40;"> <span style="padding-left:20px;position: relative;top: 10px;">Small Font Size</span>
                        </td>
                      </tr> 
                      <tr style="border-bottom:1px dashed gray;">
                        <td id="font_16" style="vertical-align: middle;display: flex; cursor: pointer">
                            <img src="https://www.api.ebooklat.phr.com.ph/public/api/img/font-size.png" alt="defualt-font" style="width: 40px;height: 40;"> <span style="padding-left:20px;position: relative;top: 10px;">Default Font Size</span>
                        </td>
                      </tr> 
                       <tr style="border-bottom:1px dashed gray;">
                        <td id="font_18" style="vertical-align: middle;display: flex; cursor: pointer">
                            <img src="https://www.api.ebooklat.phr.com.ph/public/api/img/font-size.png" alt="medium-font" style="width: 40px;height: 40;"> <span style="padding-left:20px;position: relative;top: 10px;">Medium Font Size</span>
                        </td>
                      </tr>
                      <tr style="border-bottom:1px dashed gray;">
                        <td id="font_20" style="vertical-align: middle;display: flex;cursor: pointer">
                            <img src="https://www.api.ebooklat.phr.com.ph/public/api/img/font-size.png" alt="large-font" style="width: 40px;height: 40;"> <span style="padding-left:20px;position: relative;top: 10px;">Large Font Size</span>
                        </td>
                      </tr>

                      <tr style="border-bottom:1px dashed gray;">
                        <td id="font_25" style="vertical-align: middle;display: flex;cursor: pointer">
                           <img src="https://www.api.ebooklat.phr.com.ph/public/api/img/font-size.png" alt="extra-large-font" style="width: 40px;height: 40;">  <span style="padding-left:20px;position: relative;top: 10px;">Extra Large Font Size</span>
                        </td>
                      </tr> 

<!-- 
                       <tr>
                        <td>
                          <div class="row" style="background:#2e3c5f;padding-top: 7px;padding-bottom: 7px;">
                              <div class="container">
                                    <h2 class="mb-1 text-white" style="font-size: 15px;color: #fff !important;text-align: center;">
                                      Set Font Style
                                    </h2>
                              </div>
                          </div>
                        </td>
                      </tr>  -->


                      <tr style="border-bottom:1px dashed gray;">
                        <td id="font_helvetica" style="vertical-align: middle;display: flex;cursor: pointer">
                           <img src="https://www.api.ebooklat.phr.com.ph/public/api/img/font-style.png" alt="font-helvetica" style="width: 40px;height: 40;">  <span style="padding-left:20px;position: relative;top: 10px;font-family: Arial, Helvetica, sans-serif;">Helvetica Style</span>
                        </td>
                      </tr>


                      <tr style="border-bottom:1px dashed gray;">
                        <td id="font_times" style="vertical-align: middle;display: flex;cursor: pointer">
                           <img src="https://www.api.ebooklat.phr.com.ph/public/api/img/font-style.png" alt="font-arial" style="width: 40px;height: 40;">  <span style="padding-left:20px;position: relative;top: 10px;font-family: Times New Roman, Times, serif;">Times Roman Style</span>
                        </td>
                      </tr>


                      <tr style="border-bottom:1px dashed gray;">
                        <td id="font_lucida" style="vertical-align: middle;display: flex;cursor: pointer">
                           <img src="https://www.api.ebooklat.phr.com.ph/public/api/img/font-style.png" alt="font-arial" style="width: 40px;height: 40;">  <span style="padding-left:20px;position: relative;top: 10px;font-family: Lucida Console, Courier New, monospace;">Courier New Style</span>
                        </td>
                      </tr>  


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
    var params = URLSearchParams && new URLSearchParams(document.location.search.substring(1));
    var url = params && params.get("url") && decodeURIComponent(params.get("url"));
    var currentSectionIndex = (params && params.get("loc")) ? params.get("loc") : undefined;
    
    var file_url = params && params.get("file_url") && decodeURIComponent(params.get("file_url"));

    // Load the opf
     var book = ePub("{{$epub_doc}}", {
      store: "epubjs-test"
    });
    
    var rendition = book.renderTo("viewer", {
      width: "100%",
      height: "100%",
      flow: "spreads"
    });
   
    rendition.display(currentSectionIndex);
   

   // Set Theme
    var dark_theme = document.getElementById("dark-theme");
    dark_theme.addEventListener("click", function(e){  

        rendition.themes.select("dark");     
       //  rendition.themes.register("dark_color", {
       //        "p": {                   
       //          "color": "white !important",
       //        },
       //  });
       // rendition.themes.select("dark_color");        
        // rendition.themes.default({ "p": { "color": "white !important"}})

      });

    var light_theme = document.getElementById("light-theme");    
    light_theme.addEventListener("click", function(e){    

        rendition.themes.select("light");              
       //  rendition.themes.register("light_color", {
       //        "p": {                   
       //          "color": "black !important",
       //        },
       //  });
       // rendition.themes.select("light_color");              
        //rendition.themes.default({ "p": { "color": "black !important"}})
      });

     var septia_theme = document.getElementById("septia-theme");    
     septia_theme.addEventListener("click", function(e){    

        rendition.themes.select("septia");               
       //  rendition.themes.register("septia_color", {
       //        "p": {                   
       //          "color": "#704214 !important",
       //        },
       //  });
       // rendition.themes.select("septia_color");  
        //rendition.themes.default({ "p": { "color": "#704214  !important"}})
      });
      
     // End Theme=============
     

     // Set Font Size==========
      var font_10 = document.getElementById("font_10");
      font_10.addEventListener("click", function(e){            
        rendition.themes.register("custom_font_10", {
              body: {                   
                "font-size": "10px !important",
              },
        });
       rendition.themes.select("custom_font_10");               
      });

      var font_13 = document.getElementById("font_13");
      font_13.addEventListener("click", function(e){            
        rendition.themes.register("custom_font_13", {
              body: {                   
                "font-size": "13px !important",
              },
        });
       rendition.themes.select("custom_font_13");               
      });


      var font_15 = document.getElementById("font_16");
      font_15.addEventListener("click", function(e){            
        rendition.themes.register("custom_font_16", {
              body: {                   
                "font-size": "15px !important",
              },
        });
       rendition.themes.select("custom_font_16");               
      });

      var font_18 = document.getElementById("font_18");
      font_18.addEventListener("click", function(e){    
        rendition.themes.register("custom_font_18", {
              body: {                   
                "font-size": "20px !important",
              },
        });
         rendition.themes.select("custom_font_18");               
      });

      var font_20 = document.getElementById("font_20");
      font_20.addEventListener("click", function(e){    
        rendition.themes.register("custom_font_20", {
              body: {                   
                "font-size": "20px !important",
              },
        });
         rendition.themes.select("custom_font_20");               
      });

      var font_25 = document.getElementById("font_25");
      font_25.addEventListener("click", function(e){    
        rendition.themes.register("custom_font_25", {
              body: {                   
                "font-size": "25px !important",
              },
        });
         rendition.themes.select("custom_font_25");               
      });
    
    // End Set Font Size======
  

    //Set Font Style==========
    var font_helvetica = document.getElementById("font_helvetica");
      font_helvetica.addEventListener("click", function(e){         
        rendition.themes.register("custom_font_helvetica", {
              body: {                   
                "font-family": "Arial, Helvetica, sans-serif !important",
              },
        });
         rendition.themes.select("custom_font_helvetica");               
      });

      var font_times = document.getElementById("font_times");
      font_times.addEventListener("click", function(e){    
        rendition.themes.register("custom_font_times", {
              body: {                   
                "font-family": "Times New Roman, Times, serif !important",
              },
        });
         rendition.themes.select("custom_font_times");               
      });
    
      var font_lucida = document.getElementById("font_lucida");
      font_lucida.addEventListener("click", function(e){    
        rendition.themes.register("custom_font_lucida", {
              body: {                   
                "font-family": "Lucida Console, Courier New, monospace !important",
              },
        });
         rendition.themes.select("custom_font_lucida");               
      });
    
    // End Set Font Style

    book.ready.then(() => {

      var next = document.getElementById("next");
      next.addEventListener("click", function(e){        
        book.package.metadata.direction === "rtl" ? rendition.prev() : rendition.next();
        e.preventDefault();      
      }, false);

      var prev = document.getElementById("prev");
      prev.addEventListener("click", function(e){
        book.package.metadata.direction === "rtl" ? rendition.next() : rendition.prev();       
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
          var index = $select.selectedIndex,
              url = $select.options[index].getAttribute("ref");
          rendition.display(url);
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
