{{-- <section id="slider" class="slick-carousel clearfix sub-banner">
    <div id="page-title" class="bg-transparent border-0">
        <div class="container clearfix">
            <div class="title-head">
                <h1 class="text-light">{{ $page->name }}</h1>
            </div>
            @if(isset($breadcrumb))
            <ol class="breadcrumb">
                @foreach($breadcrumb as $link => $url)
                    @if($loop->last)
                        <li class="breadcrumb-item active limiter" aria-current="page">{{$link}}</li>
                    @else
                        <li class="breadcrumb-item"><a href="{{$url}}">{{$link}}</a></li>
                    @endif 
                @endforeach
            </ol>
            @endif
        </div>
    </div>
    
    <div class="slider-parallax-inner">
        <div class="swiper-container swiper-parent">
            <div class="slick-wrapper" id="banner">
                @foreach ($page->album->banners as $banner)
                    <div class="swiper-slide dark" style="background-image: url('{{ $banner->image_path }}');"></div>
                @endforeach
            </div>
        </div>
    </div>
</section> --}}

<section id="slider" class="slick-carousel clearfix sub-banner">
    <div class="banner-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12" style="padding:0;">
					<div class="sub-banner-caption">
						<div class="container" style="position: relative;">
							<h2 class="text-center excerpt-1 text-light">{{ $page->name }}</h2>
							<div class="sub-banner-flex">
								@if(isset($breadcrumb))
					            <ol class="breadcrumb nobottommargin flex-nowrap justify-content-center">
					                @foreach($breadcrumb as $link => $url)
					                    @if($loop->last)
					                        <li class="breadcrumb-item active excerpt-1 text-light" aria-current="page">{{$link}}</li>
					                    @else
					                        <li class="breadcrumb-item text-nowrap"><a href="{{$url}}" class="text-light"><i class="icon-home"></i></a></li>
					                    @endif
					                @endforeach
					            </ol>
					            @endif
							</div>
						</div>
					</div>
                    <div id="banner" class="slick-slider">
                        @foreach ($page->album->banners as $banner)
                        <div class="hero-slide dark">
                            <img src="{{ $banner->image_path }}" />
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
