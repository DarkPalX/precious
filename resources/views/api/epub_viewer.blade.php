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
  
  <style>
   #toc{    
    width: 100%;
    background: #e6e6e6;
    padding: 5px;
    display: block;
    font-size: 13px;    
    z-index:999;
    width: 70%;
   }
   #viewer{
    padding-top:30px;
   }
   .spreads{
      padding-bottom:20px;
   }

  </style>

   
</head>
<body>
  <!-- <div id="title"></div> -->
  

  <div style="display:flex;position: fixed; width: 100%;background: #2e3c5f;height: 40px;z-index: 99999;">
    <select id="toc" style="font-size:15px;padding:5px !important;float:left;"></select>
    <div style="float:right;padding-right: 20px;cursor: pointer;width: 20%; display: flex;padding-left: 4px; color: #fff;">
      <img id="dark-theme" src="https://www.beta.ebooklat.phr.com.ph/public/api/img/dark-mode.png" alt="dark-mode" style="width: 40px;">
      <img id="light-theme" src="https://www.beta.ebooklat.phr.com.ph/public/api/img/light-mode.png" alt="light-mode" style="width: 40px;">
      <img id="septia-theme" src="https://www.beta.ebooklat.phr.com.ph/public/api/img/septia-mode.png" alt="septia-mode" style="width: 40px;padding-right: 4px;">
    </div>
  </div>
  
  <div id="viewer" class="spreads" style="font-size:30px;"></div>
    
  
  
  <div style="height:44px;position: fixed;z-index: 999;bottom:0px;text-align:center;width:100%;background: #0c2136;">
        <a id="prev" href="#prev" class="arrow" style="font-size:23px;color:white;padding-right:20px;"><span style="font-size:15px;">Prev </span>‹</a>
        <a id="next" href="#next" class="arrow"style="font-size:23px;color:white;padding-left:20px;">›<span style="font-size:15px;"> Next</span></a>
  </div>

  <script>
    var params = URLSearchParams && new URLSearchParams(document.location.search.substring(1));
    var url = params && params.get("url") && decodeURIComponent(params.get("url"));
    var currentSectionIndex = (params && params.get("loc")) ? params.get("loc") : undefined;

    // Load the opf
    var book = ePub(url || "{{$epub_doc}}");
    
    var rendition = book.renderTo("viewer", {
      width: "100%",
      height: "100%",
      spread: "always"
    });
   
    rendition.display(currentSectionIndex);

    var dark_theme = document.getElementById("dark-theme");
    dark_theme.addEventListener("click", function(e){      
        rendition.themes.select("dark");      
      });


    var light_theme = document.getElementById("light-theme");    
    light_theme.addEventListener("click", function(e){    
        rendition.themes.select("light");      
      });

     var septia_theme = document.getElementById("septia-theme");
    
    septia_theme.addEventListener("click", function(e){    
        rendition.themes.select("septia");      
      });



    book.ready.then(() => {

      var next = document.getElementById("next");

      next.addEventListener("click", function(e){
        book.package.metadata.direction === "rtl" ? rendition.prev() : rendition.next();
        e.preventDefault();
      }, false);

      var prev = document.getElementById("prev");
      prev.addEventListener("click", function(e){
        book.package.metadata.direction === "rtl" ? rendition.next() : rendition.prev();
        e.preventDefault();
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



</body>
</html>
