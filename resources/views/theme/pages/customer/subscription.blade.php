@extends('theme.main')

@section('content')
@php
    $modals='';
@endphp

<div class="container topmargin-lg bottommargin-lg">
    <div class="row">
        <span onclick="closeNav()" class="dark-curtain"></span>
        <div class="col-lg-12 col-md-5 col-sm-12">
            <span onclick="openNav()" class="button button-small button-circle border-bottom ms-0 text-initial nols fw-normal noleftmargin d-lg-none mb-4"><span class="icon-chevron-left me-2 color-2"></span> Quicklinks</span>
        </div>
        <div class="col-lg-3 pe-lg-4">
            @include('theme.pages.customer.sidebar')
        </div>

        <div class="col-lg-9">
            <h2>Subscription Plan</h2>
            

            {{-- FOR CANCELLING --}}
            @if($current_subscription)
                <div class="promo promo-dark bg-success p-4 p-md-5 mb-5">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg">
                            <h3>You are currently subscribed to a plan!</h3>
                            <span>
                                <i>{{ $subscription_detail->title }}</i><br>
                                <small class="text-white">
                                    You can still subscribe to another plan to extend your subscription days or 
                                    <a class="text-warning" href="javasacript:void(0)" data-bs-toggle="modal" data-bs-target="#unsubscribe_modal">unsubscribe</a> 
                                    current plan
                                </small>
                            </span>
                            
                        </div>
                    </div>
                </div>
                
                <form action="{{ route('customer.subscription-cancel') }}" method="post">
                    @csrf
                    <div class="modal fade text-start bs-example-modal-centered" id="unsubscribe_modal" tabindex="-1" role="dialog" aria-labelledby="centerModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Cancel Subscription</h4>
                                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
                                </div>
                                <div class="modal-body">
                                    <small style="font-size:12px">Leave us a message why you are cancelling your current active subscription.</small>

                                    <textarea name="cancel_reason" class="form-control" style="font-size: 12px" placeholder="Reason for unsubscribing (optional)"></textarea>

                                    <small class="text-danger" style="font-size:12px">Note: There is no refund for unsubscribing active plans.</small>
                                </div>

                                {{-- hidden input --}}
                                <input name="plan_id" value="{{ $current_subscription->plan_id }}" hidden/>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endif

            {{-- FOR SUBSCRIBING --}}
            @foreach($subscriptions as $subscription)

                <form action="{{ route('customer.subscription-selected') }}" method="post">
                    @csrf
                    <div class="promo promo-dark bg-color p-4 p-md-5 mb-5">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg">
                                <h3>{{ $subscription->title }}</h3>
                                <span>{{ $subscription->short_description }}</span><br>
                            </div>
                            <div class="col-12 col-lg-auto mt-4 mt-lg-0">
                                <span class="fa fa-2x text-white mt-3">₱ {{ $subscription->price }}</span><br><br>
                                <button type="submit" class="button button-border button-light button-rounded m-0">SUBSCRIBE</button>
                            </div>
                        </div>
                        {{-- hidden input --}}
                        <input name="subscription_id" value="{{ $subscription->id }}" hidden/>
                    </div>
                </form>

            @endforeach
        </div>
    </div>
</div>

@endsection

@section('pagejs')
	<script>
	</script>
@endsection

