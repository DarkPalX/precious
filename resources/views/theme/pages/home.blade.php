@extends('theme.main')

@section('pagecss')
@endsection

@php
    $contents = $page->contents;


    $featuredProducts = \App\Models\Ecommerce\Product::where('is_featured', 1)->where('status', 'PUBLISHED')->skip(0)->take(4)->get();
    if($featuredProducts->count()){

        $featuredProductsHTML = '';

        foreach($featuredProducts as $key => $product) {
            $imageUrl = asset('storage/products/'.$product->photoPrimary);

            $featuredProductsHTML .= '
            <div class="product">
                <div class="grid-inner">
                    <div class="product-image h-translate-y all-ts">
                        <a href="'.route('product.details',$product->slug).'"><img src="'.$imageUrl.'" alt="'. $product->name .'"></a>
                        <div class="bg-overlay">
                            <div class="bg-overlay-content align-items-end justify-content-start flex-column">
                                <a data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Bag" data-hover-animate="fadeInRightSmall" href="#" class="btn btn-light h-bg-color h-text-light border-0 mb-2"><i class="icon-shopping-bag"></i></a>
                                <a data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Favorites" data-hover-animate="fadeInRightSmall" data-hover-delay="100" href="#" class="btn btn-light h-bg-color h-text-light border-0 mb-2"><i class="icon-heart3"></i></a>
                                <a data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist" data-hover-animate="fadeInRightSmall" data-hover-delay="100" href="#" class="btn btn-light h-bg-color h-text-light border-0 mb-2"><i class="icon-star"></i></a>
                            </div>
                            <div class="bg-overlay-bg bg-transparent"></div>
                        </div>
                    </div>
                    <div class="product-desc py-0">
                        <div class="product-title"><h3><a href="'.route('product.details',$product->slug).'">'. $product->name .'</a></h3></div>
                        <div class="product-price"><ins class="text-light">'. number_format($product->price,2) .'</ins></div>
                        <div class="product-rating">
                            <i class="icon-star3"></i>
                            <i class="icon-star3"></i>
                            <i class="icon-star3"></i>
                            <i class="icon-star-half-full"></i>
                            <i class="icon-star-empty"></i>
                        </div>
                    </div>
                </div>
            </div>';
        }

    } else {
        $featuredProductsHTML = '';
    }


    $featuredArticles = Article::where('is_featured', 1)->where('status', 'Published')->skip(0)->take(5)->get();
    if($featuredArticles->count()) {

        $featuredArticlesHTML = '';

        $prefooter = asset('theme/images/pre-footer.jpg');

        foreach ($featuredArticles as $index => $article) {
            $imageUrl = (empty($article->thumbnail_url)) ? asset('theme/images/misc/no-image.jpg') : $article->thumbnail_url;

            
            $featuredArticlesHTML .= '
                <div class="oc-item">
                    <div class="ipost clearfix">
                        <div class="entry-image">
                            <a href="'. $article->get_url() .'" data-lightbox="image"><img class="image_fade" src="'. $imageUrl .'" alt="Standard Post with Image"></a>
                        </div>
                        <div class="entry-title" style="max-height: 70px; overflow: hidden;">
                            <h3 style="display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden; text-overflow: ellipsis;">
                                <a href="'. $article->get_url() .'" style="text-decoration: none;">'. $article->name .'</a>
                            </h3>
                        </div>
                        <ul class="entry-meta clearfix">
                            <li><i class="icon-calendar3"></i> '. $article->date_posted() .'</li>
                        </ul>
                        <div class="entry-content">
                            <p>'. $article->teaser .'</p>
                        </div>
                    </div>
                </div>';

            if (Article::has_featured_limit() && $index >= env('FEATURED_NEWS_LIMIT')) {
                break;
            }
        }

        $keywords   = ['{Featured Articles}', '{Featured Products}'];
        $variables  = [$featuredArticlesHTML, $featuredProductsHTML];

        $contents = str_replace($keywords,$variables,$contents);

    } else {

        $keywords   = ['{Featured Articles}', '{Featured Products}'];
        $variables  = ['', $featuredProductsHTML];

        $contents = str_replace($keywords,$variables,$contents);
    } 

@endphp

@section('content')
    {!! $contents !!}
@endsection

