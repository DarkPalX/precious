@extends('admin.layouts.app')

@section('pagecss')
    <link href="{{ asset('lib/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
    <style>
        .row-selected {
            background-color: #92b7da !important;
        }
    </style>
@endsection

@section('content')
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-5">
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('products.index')}}">Ebook Subscribers</a></li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Ebook Subscribers</h4>
            </div>
        </div>

        <div class="row row-sm">

            <!-- Start Filters -->
            @include('admin.ecommerce.ebook-subscribers.filter')
            <!-- End Filters -->


            <!-- Start Pages -->
            <div class="col-md-12">
                <div class="table-list mg-b-10">
                    <div class="table-responsive-lg">
                        <table class="table mg-b-0 table-light table-hover"  style="table-layout: fixed;word-wrap: break-word;">
                            <thead>
                                <tr>
                                    <th style="width: 5%;" class="text-center">QR</th>
                                    <th style="width: 50%;overflow: hidden;">Name</th>
                                    <th style="width: 10%;">Category</th>
                                    <th style="width: 10%;">Subscribers Count</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($products as $product)
                                <tr id="row{{$product->id}}" class="row_cb">
                                    <th>
                                        @if(!empty($product->file_url))
                                            <div class="custom-control custom-checkbox">
                                                <a href="{{ route('generate.file.qr', ['product_id' => urlencode($product->id)]) }}" target="_blank" title="Generate QR Code"><i class="fa fa-qrcode mr-2"></i></a>
                                            </div>
                                        @endif
                                    </th>
                                    <td>
                                        <strong @if($product->trashed()) style="text-decoration:line-through;" @endif> {{ $product->name }}</strong><br>
                                        <span class="badge badge-success" {{ !$product->is_bundle  ? 'hidden' : '' }}>Bundle</span>
                                        <span class="badge badge-primary" {{ !$product->is_free  ? 'hidden' : '' }}>Free</span>
                                        <span class="badge badge-danger" {{ !$product->is_premium  ? 'hidden' : '' }}>Premium</span>
                                    </td>
                                    <td>{{ $product->category->name }}</td>
                                    <td class="text-center"><a href="{{ route('subscriptions.ebooks-subscription-list', ['id' => $product->id]) }}"> {{ App\Models\UsersSubscription::getSubscriberCount($product->id) }} </a></td>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="4" style="text-align: center;"> <p class="text-danger">No products found.</p></th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Pages -->
            <div class="col-md-6">
                <div class="mg-t-5">
                    @if ($products->firstItem() == null)
                        <p class="tx-gray-400 tx-12 d-inline">{{__('common.showing_zero_items')}}</p>
                    @else
                        <p class="tx-gray-400 tx-12 d-inline">Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} items</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-md-right float-md-right mg-t-5">
                    <div>
                        {{ $products->appends((array) $filter)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="" id="posting_form" style="display:none;" method="post">
        @csrf
        <input type="text" id="products" name="products">
        <input type="text" id="status" name="status">
    </form>

@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>

    <script>
        let listingUrl = "{{ route('subscriptions.ebooks') }}";
        let searchType = "{{ $searchType }}";
    </script>
    <script src="{{ asset('js/listing.js') }}"></script>
@endsection

@section('customjs')
    <script>
        function post_form(url,status,product){
            $('#posting_form').attr('action',url);
            $('#products').val(product);
            $('#status').val(status);
            $('#posting_form').submit();
        }

        /*** handles the changing of status of multiple pages ***/
        function change_status(status){
            var counter = 0;
            var selected_videos = '';
            $(".cb:checked").each(function(){
                counter++;
                fid = $(this).attr('id');
                selected_videos += fid.substring(2, fid.length)+'|';
            });
            if(parseInt(counter) < 1){
                $('#prompt-no-selected').modal('show');
                return false;
            }
            else{
                if(parseInt(counter)>1){ // ask for confirmation when multiple pages was selected
                    $('#productStatus').html(status)
                    $('#prompt-update-status').modal('show');

                    $('#btnUpdateStatus').on('click', function() {
                        post_form("{{route('product.multiple.change.status')}}",status,selected_videos);
                    });
                }
                else{
                    post_form("{{route('product.multiple.change.status')}}",status,selected_videos);
                }
            }
        }

        function delete_category(){
            var counter = 0;
            var selected_products = '';
            $(".cb:checked").each(function(){
                counter++;
                fid = $(this).attr('id');
                selected_products += fid.substring(2, fid.length)+'|';
            });

            if(parseInt(counter) < 1){
                $('#prompt-no-selected').modal('show');
                return false;
            }
            else{
                $('#prompt-multiple-delete').modal('show');
                $('#btnDeleteMultiple').on('click', function() {
                    post_form("{{route('products.multiple.delete')}}",'',selected_products);
                });
            }
        }

        function delete_one_category(id,product){
            $('#prompt-delete').modal('show');
            $('#btnDelete').on('click', function() {
                post_form("{{route('product.single.delete')}}",'',id);
            });
        }

        function add_inventory(id,inventory){
            $('#productid').val(id);
            $('#available_stock').html(inventory);
            $('#prompt-add-inventory').modal('show');
        }

        function deduct_inventory(id,inventory){
            $('#productId').val(id);
            $('#availableStock').html(inventory);
            $('#prompt-deduct-inventory').modal('show');

            $("#qty").attr({
                "max" : inventory
            });
        }
    </script>
@endsection
