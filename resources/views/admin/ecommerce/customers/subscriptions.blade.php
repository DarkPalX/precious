@extends('admin.layouts.app')

@section('pagecss')
    <link href="{{ asset('lib/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-5">
                        <li class="breadcrumb-item" aria-current="page">Ecommerce</li>
                        <li class="breadcrumb-item active" aria-current="page">Customer Subscriptions</li>
                    </ol>
                </nav>

                
                
                <div class="media">
                    <div class="media-body pd-t-20">
                        <a class="mg-b-5" href="#" onclick="window.history.back()"><i class="fa fa-arrow-left"></i> BACK</a>

                        <h5 class="mg-b-0 mg-t-30 tx-inverse tx-bold">{{  $user->fullname }}</h5>
                        <p>{{ $user->email }}</p>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="row row-sm">
            <!-- Start Pages -->
            <div class="col-md-12">
                <div class="table-list mg-b-10">
                    <div class="table-responsive-lg">
                        <table class="table mg-b-0 table-light table-hover" style="width:100%;">
                            <thead>
                                <tr>
                                    <th scope="col" width="15%">Title</th>
                                    <th scope="col">Validity (Days)</th>
                                    <th scope="col">Subscribed On</th>
                                    <th scope="col">Expiry Date</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user_subscriptions as $user_subscription)
                                    <tr>
                                        <td><strong>{{$user_subscription->title}}</strong></td>
                                        <td>{{ $user_subscription->no_days }}</td>
                                        <td>{{ $user_subscription->start_date }}</td>
                                        <td>{{ $user_subscription->end_date }}</td>
                                        <td>
                                            @if(\Carbon\Carbon::parse($user_subscription->end_date)->lt(\Carbon\Carbon::now()))
                                                <span class="badge badge-danger">Expired</span>
                                            @else
                                                <span class="badge badge-success">Active</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" style="text-align: center;"> <p class="text-danger">No subscriptions found.</p></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Pages -->

            <!-- Start Navigation -->
            {{-- <div class="col-md-6">
                <div class="mg-t-5">
                    @if ($user_subscriptions->firstItem() == null)
                        <p class="tx-gray-400 tx-12 d-inline">{{__('common.showing_zero_items')}}</p>
                    @else
                        <p class="tx-gray-400 tx-12 d-inline">Showing {{$user_subscriptions->firstItem()}} to {{$user_subscriptions->lastItem()}} of {{$user_subscriptions->total()}} users</p>
                    @endif

                </div>
            </div>
            <div class="col-md-6">
                <div class="text-md-right float-md-right mg-t-5">
                    <div>
                        {{ $user_subscriptions->appends(array)->links() }}
                    </div>
                </div>
            </div> --}}
            <!-- End Navigation -->

        </div>
    </div>
    @include('admin.ecommerce.customers.modals')
@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('scripts/user/scripts.js') }}"></script>

    {{-- <script>
        let listingUrl = "{{ route('customers.index') }}";
        let advanceListingUrl = "";
        let searchType = "{{ $searchType }}";
    </script> --}}
    <script src="{{ asset('js/listing.js') }}"></script>
@endsection

@section('customjs')
@endsection
