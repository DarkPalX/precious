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
                        <li class="breadcrumb-item active" aria-current="page">Ebook Subscribers</li>
                    </ol>
                </nav>
                
                <div class="media">
                    <div class="media-body pd-t-20">
                        <a class="mg-b-5" href="#" onclick="window.history.back()"><i class="fa fa-arrow-left"></i> BACK</a>

                        <h5 class="mg-b-0 mg-t-30 tx-inverse tx-bold">{{ $product->name }}</h5>
                        <p>{{ $product->category->name }}</p>
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
                                    <th scope="col" width="15%">Name</th>
                                    <th scope="col" width="15%">Email</th>
                                    <th scope="col" width="15%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ebook_subscribers as $ebook_subscriber)
                                    @php
                                        $subscriber = App\Models\UsersSubscription::getSubscriberInfo($ebook_subscriber->user_id);
                                    @endphp
                                    @if($subscriber)
                                        <tr>
                                            <td><strong>{{ $subscriber->name }}</strong></td>
                                            <td>{{ $subscriber->email }}</td>
                                            <td>
                                                @if($subscriber->is_active && $subscriber->deleted_at == NULL)
                                                    <span class="badge badge-success badge-sm">Active</span>
                                                @else
                                                    <span class="badge badge-danger badge-sm">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
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
