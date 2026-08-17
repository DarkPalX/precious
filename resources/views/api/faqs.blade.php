<style>
    .img-responsive {
        display: block;
        width: 100%;
        max-width: 800px;
        height: auto;
        margin: 20px auto;
    }
</style>

@if(isset($Info))
    @php
        $PageID = $Info->Page_ID;
        $Content = $Info->faq ?? '';

        // Automatically add img-responsive class to all images
        $Content = preg_replace_callback(
            '/<img\b([^>]*)>/i',
            function ($matches) {
                $attributes = $matches[1];

                // If image already has a class attribute
                if (preg_match('/\bclass\s*=\s*["\']([^"\']*)["\']/i', $attributes)) {
                    return preg_replace(
                        '/\bclass\s*=\s*(["\'])(.*?)\1/i',
                        'class=$1$2 img-responsive$1',
                        $matches[0]
                    );
                }

                // If image doesn't have a class
                return '<img class="img-responsive"' . $attributes . '>';
            },
            $Content
        );
    @endphp
@endif

<div
    style="
        font-family: 'Poppins', sans-serif !important;
        color: #555;
        line-height: 1.5;
        font-size: 33px;
        padding: 10px;
    "
>
    {!! $Content !!}
</div>