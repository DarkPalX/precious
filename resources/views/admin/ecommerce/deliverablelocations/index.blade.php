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
                        <li class="breadcrumb-item active" aria-current="page">Delivery Flat Rates</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Manage Flat Rates</h4>
            </div>
        </div>


        <div class="row row-sm">
            <!-- Start Filters -->
            <div class="col-md-12">
                <div class="filter-buttons">
                    <div class="d-md-flex bd-highlight">
                        <div class="bd-highlight mg-r-10 mg-t-10">
                            <div class="dropdown d-inline mg-r-5">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{__('common.filters')}}
                                </button>
                                <div class="dropdown-menu">
                                    <form id="filterForm" class="pd-20">
                                        <div class="form-group">
                                            <label for="exampleDropdownFormEmail1">{{__('common.sort_by')}}</label>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="orderBy1" name="orderBy" class="custom-control-input" value="updated_at" @if ($filter->orderBy == 'updated_at') checked @endif>
                                                <label class="custom-control-label" for="orderBy1">{{__('common.date_modified')}}</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="orderBy2" name="orderBy" class="custom-control-input" value="name" @if ($filter->orderBy == 'name') checked @endif>
                                                <label class="custom-control-label" for="orderBy2">{{__('common.name')}}</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleDropdownFormEmail1">{{__('common.sort_order')}}</label>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="sortByAsc" name="sortBy" class="custom-control-input" value="asc" @if ($filter->sortBy == 'asc') checked @endif>
                                                <label class="custom-control-label" for="sortByAsc">{{__('common.ascending')}}</label>
                                            </div>

                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="sortByDesc" name="sortBy" class="custom-control-input" value="desc"  @if ($filter->sortBy == 'desc') checked @endif>
                                                <label class="custom-control-label" for="sortByDesc">{{__('common.descending')}}</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" id="showDeleted" name="showDeleted" class="custom-control-input" @if ($filter->showDeleted) checked @endif>
                                                <label class="custom-control-label" for="showDeleted">{{__('common.show_deleted')}}</label>
                                            </div>
                                        </div>
                                        <div class="form-group mg-b-40">
                                            <label class="d-block">{{__('common.item_displayed')}}</label>
                                            <input id="displaySize" type="text" class="js-range-slider" name="perPage" value="{{ $filter->perPage }}"/>
                                        </div>
                                        <button id="filter" type="button" class="btn btn-sm btn-primary">{{__('common.apply_filters')}}</button>
                                    </form>
                                </div>
                            </div>
                            @if (auth()->user()->has_access_to_route('location.multiple.change.status') || auth()->user()->has_access_to_route('location.multiple.delete'))
                            <div class="list-search d-inline">
                                <div class="dropdown d-inline mg-r-10">
                                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @if (auth()->user()->has_access_to_route('location.multiple.change.status'))
                                            <a class="dropdown-item" href="javascript:void(0)" onclick="change_status('PUBLISHED')">Publish</a>
                                            <a class="dropdown-item" href="javascript:void(0)" onclick="change_status('PRIVATE')">Private</a>
                                        @endif

                                        @if (auth()->user()->has_access_to_route('location.multiple.delete'))
                                            <a class="dropdown-item tx-danger" href="javascript:void(0)" onclick="delete_rates()">{{__('common.delete')}}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="ml-auto bd-highlight mg-t-10 mg-r-10">
                            <form class="form-inline" id="searchForm">
                                <div class="search-form mg-r-10">
                                    <input name="search" type="search" id="search" class="form-control"  placeholder="Search by Name" value="{{ $filter->search }}">
                                    <button class="btn filter" type="button" id="btnSearch"><i data-feather="search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="mg-t-10">
                            @if (auth()->user()->has_access_to_route('locations.create'))
                                <a class="btn btn-primary btn-sm mg-b-20" href="{{ route('locations.create') }}">Add New Rate</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Filters -->

            <div class="col-md-12">
                <div class="table-list mg-b-10">
                    <div class="table-responsive-lg">
                        <table class="table mg-b-0 table-light table-hover" style="table-layout: fixed;word-wrap: break-word;">
                            <thead>
                            <tr>
                                <th style="width: 5%;">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkbox_all">
                                        <label class="custom-control-label" for="checkbox_all"></label>
                                    </div>
                                </th>
                                <th width="50%">Location</th>
                                <th>Rate</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($address as $add)
                                <tr id="row{{$add->id}}" class="row_cb">
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input cb" id="cb{{ $add->id }}">
                                            <label class="custom-control-label" for="cb{{ $add->id }}"></label>
                                        </div>
                                    </th>
                                    <td><strong @if($add->trashed()) style="text-decoration:line-through;" @endif> {{ $add->name }}</strong> </td>
                                    <td>{{ number_format($add->rate,2) }}</td>
                                    <td>{{ $add->status }}</td>

                                    <td>
                                        @if($add->trashed())
                                            <nav class="nav table-options">
                                                <a class="nav-link" href="{{route('location.restore', $add->id)}}" title="Restore this rate"><i data-feather="rotate-ccw"></i></a>
                                            </nav>
                                        @else
                                            <nav class="nav table-options">
                                                @if (auth()->user()->has_access_to_route('locations.edit'))
                                                    <a class="nav-link" href="{{ route('locations.edit',$add->id) }}" title="Edit Location"><i data-feather="edit"></i></a>
                                                @endif

                                                @if (auth()->user()->has_access_to_route('locations.enable') || auth()->user()->has_access_to_route('locations.disable'))
                                                <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i data-feather="settings"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if($add->status == 'PRIVATE')
                                                        <a class="dropdown-item" href="{{route('location.change-status',[$add->id,'PUBLISHED'])}}"> Publish</a>
                                                    @else
                                                        <a class="dropdown-item" href="{{route('location.change-status',[$add->id,'PRIVATE'])}}" > Private</a>
                                                    @endif
                                                </div>
                                                @endif

                                                @if (auth()->user()->has_access_to_route('locations.delete'))
                                                    <a class="nav-link" href="javascript:void(0)" onclick="delete_one_rate('{{$add->id}}')" title="Delete Flat Rate"><i data-feather="trash"></i></a>
                                                @endif
                                            </nav>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="5" style="text-align: center;"> <p class="text-danger">No delivery rates found.</p></th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mg-t-5">
                    @if ($address->firstItem() == null)
                        <p class="tx-gray-400 tx-12 d-inline">{{__('common.showing_zero_items')}}</p>
                    @else
                        <p class="tx-gray-400 tx-12 d-inline">Showing {{ $address->firstItem() }} to {{ $address->lastItem() }} of {{ $address->total() }} items</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-md-right float-md-right mg-t-5">
                    <div>
                        {{ $address->appends((array) $filter)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="" id="posting_form" method="post" style="display: none;">
        @csrf
        <input type="text" id="rates" name="rates">
        <input type="text" id="status" name="status">
    </form>


    @include('admin.ecommerce.modals')
@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>

    <script>
        let listingUrl = "{{ route('locations.index') }}";
        let advanceListingUrl = "";
        let searchType = "{{ $searchType }}";
    </script>
    <script src="{{ asset('js/listing.js') }}"></script>


@endsection

@section('customjs')
    <script>
        function post_form(url,status,rateId){
            $('#posting_form').attr('action',url);
            $('#rates').val(rateId);
            $('#status').val(status);
            $('#posting_form').submit();
        }

        function delete_one_rate(id){
            $('#prompt-delete').modal('show');
            $('#btnDelete').on('click', function() {
                post_form("{{route('location.single.delete')}}",'',id);
            });
        }

        /*** handles the changing of status of multiple pages ***/
        function change_status(status){
            var counter = 0;
            var selected_rates = '';
            $(".cb:checked").each(function(){
                counter++;
                fid = $(this).attr('id');
                selected_rates += fid.substring(2, fid.length)+'|';
            });
            if(parseInt(counter) < 1){
                $('#prompt-no-selected').modal('show');
                return false;
            }
            else{
                if(parseInt(counter)>1){ // ask for confirmation when multiple pages was selected
                    $('#promoStatus').html(status)
                    $('#prompt-update-status').modal('show');

                    $('#btnUpdateStatus').on('click', function() {
                        post_form("{{route('location.multiple.change.status')}}",status,selected_rates);
                    });
                }
                else{
                    post_form("{{route('location.multiple.change.status')}}",status,selected_rates);
                }
            }
        }

        function delete_rates(){
            var counter = 0;
            var selected_rates = '';
            $(".cb:checked").each(function(){
                counter++;
                fid = $(this).attr('id');
                selected_rates += fid.substring(2, fid.length)+'|';
            });

            if(parseInt(counter) < 1){
                $('#prompt-no-selected').modal('show');
                return false;
            }
            else{
                $('#prompt-multiple-delete').modal('show');
                $('#btnDeleteMultiple').on('click', function() {
                    post_form("{{route('location.multiple.delete')}}",'',selected_rates);
                });
            }
        }
    </script>
@endsection
