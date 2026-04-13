@extends('admin.layouts.app')

@section('pagetitle')
    Mobile App Settings
@endsection

@section('content')
    <style>
        .image-preview-container {
            position: relative;
            display: inline-block;
            margin-top: 10px;
        }

        .preview-image {
            max-height: 120px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        .remove-image-btn {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: none;
            background: #dc3545;
            color: #fff;
            font-weight: bold;
            font-size: 14px;
            line-height: 24px;
            cursor: pointer;
            text-align: center;
        }

        .remove-image-btn:hover {
            background: #b02a37;
        }
    </style>

    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20">
            <h4 class="mg-b-0">Mobile App Settings</h4>
        </div>

        <form method="POST"
              action="{{ route('mobile-app-settings.update') }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="d-flex align-items-center justify-content-end">
                <button class="btn btn-primary btn-sm mb-3 m-1">
                    Save Settings
                </button>
                <button class="btn btn-secondary btn-sm mb-3 m-1" type="button" onclick="window.location.href='{{ route('mobile-app-settings.reset') }}'">
                    Reset to Default
                </button>

            </div>


            {{-- SPLASHSCREEN --}}

            <h5>Splashscreen</h5>

            @php
                $splashFields = [
                        ['name' => 'splashscreen_logo', 'type' => 'logo', 'w' => env('MOBILE_LOGO_WIDTH'), 'h' => env('MOBILE_LOGO_HEIGHT')],
                        ['name' => 'splashscreen_gif_animation', 'type' => 'gif', 'w' => env('MOBILE_GIF_WIDTH'), 'h' => env('MOBILE_GIF_HEIGHT')]
                    ];
            @endphp

            @foreach($splashFields as $field)
                @php 
                    $fieldName = $field['name']; // Store the name string to keep the code clean
                @endphp
                
                <div class="form-group">
                    <label>{{ ucfirst(str_replace('_',' ', $fieldName)) }} ({{ $field['w'] }}x{{ $field['h'] }})</label>
                    
                    <input type="file" 
                        name="{{ $fieldName }}" 
                        class="form-control image-input" 
                        data-preview="preview_{{ $fieldName }}" 
                        data-type="{{ $field['type'] }}"> 

                    <input type="hidden"
                        name="remove_{{ $fieldName }}"
                        id="remove_{{ $fieldName }}"
                        value="0">

                    <div class="image-preview-container">
                        <img id="preview_{{ $fieldName }}"
                            src="{{ $mobile_setting->$fieldName && strpos($mobile_setting->$fieldName, '/') === false ? asset('storage/mobile/'.$mobile_setting->$fieldName) : $mobile_setting->$fieldName }}"
                            class="preview-image">

                        @if($mobile_setting->$fieldName)
                            <button type="button"
                                    class="remove-image-btn remove-image"
                                    data-preview="preview_{{ $fieldName }}"
                                    data-input="remove_{{ $fieldName }}">
                                ×
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach

            <hr>

            {{-- ONBOARD SCREENS --}}

            <h5>Onboard Screens ({{ env('MOBILE_LOGO_WIDTH') }}x{{ env('MOBILE_LOGO_HEIGHT') }})</h5>

            @for($i=1;$i<=3;$i++)
                <div class="card mb-3 p-3">
                    <h6>Screen {{ $i }}</h6>

                    <div class="form-group">
                        <label>Icon</label>

                        <input type="file"
                               name="onboard_screen_logo_{{ $i }}"
                               class="form-control image-input"
                               data-preview="preview_onboard_{{ $i }}"
                               data-type="logo">

                        <input type="hidden"
                               name="remove_onboard_screen_logo_{{ $i }}"
                               id="remove_onboard_screen_logo_{{ $i }}"
                               value="0">

                        <div class="image-preview-container">
                            <img id="preview_onboard_{{ $i }}"
                                 {{-- src="{{ $mobile_setting['onboard_screen_logo_'.$i] ? asset('storage/mobile/'.$mobile_setting['onboard_screen_logo_'.$i]) : '' }}" --}}
                                src="{{ $mobile_setting['onboard_screen_logo_'.$i] && strpos($mobile_setting['onboard_screen_logo_'.$i], '/') === false ? asset('storage/mobile/'.$mobile_setting['onboard_screen_logo_'.$i]) : $mobile_setting['onboard_screen_logo_'.$i] }}"

                                 class="preview-image">

                            @if($mobile_setting['onboard_screen_logo_'.$i])
                                <button type="button"
                                        class="remove-image-btn remove-image"
                                        data-preview="preview_onboard_{{ $i }}"
                                        data-input="remove_onboard_screen_logo_{{ $i }}">
                                    ×
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Title</label>

                        <input type="text"
                               name="onboard_screen_title_{{ $i }}"
                               class="form-control"
                               value="{{ $mobile_setting['onboard_screen_title_'.$i] }}">
                    </div>

                    <div class="form-group">
                        <label>Content</label>

                        <textarea name="onboard_screen_content_{{ $i }}"
                                  class="form-control">{{ $mobile_setting['onboard_screen_content_'.$i] }}</textarea>
                    </div>
                </div>
            @endfor

            <hr>

            {{-- DASHBOARD ICONS --}}

            <h5>Dashboard Icons ({{ env('MOBILE_ICON_WIDTH') }}x{{ env('MOBILE_ICON_HEIGHT') }})</h5>

            @php
                $dashboard = [
                    'dashboard_profile_button',
                    'dashboard_library_button',
                    'dashboard_transactions_button',
                    'dashboard_ecredits_button',
                    'dashboard_contact_button',
                    'dashboard_about_button',
                    'dashboard_faqs_button',
                    'dashboard_password_button',
                    'dashboard_settings_button'
                ];
            @endphp

            @foreach($dashboard as $field)
                <div class="form-group">
                    <label>{{ ucfirst(str_replace('_',' ',$field)) }}</label>

                    <input type="file"
                           name="{{ $field }}"
                           class="form-control image-input"
                           data-preview="preview_{{ $field }}"
                           data-type="icon">

                    <input type="hidden"
                           name="remove_{{ $field }}"
                           id="remove_{{ $field }}"
                           value="0">

                    <div class="image-preview-container">
                        <img id="preview_{{ $field }}"
                            src="{{ $mobile_setting->$field && strpos($mobile_setting->$field, '/') === false ? asset('storage/mobile/'.$mobile_setting->$field) : $mobile_setting->$field }}"

                             class="preview-image"
                             style="height:80px;">

                        @if($mobile_setting->$field)
                            <button type="button"
                                    class="remove-image-btn remove-image"
                                    data-preview="preview_{{ $field }}"
                                    data-input="remove_{{ $field }}">
                                ×
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach

            <hr>

            {{-- MENUBAR ICONS --}}

            <h5>Menubar Icons ({{ env('MOBILE_ICON_WIDTH') }}x{{ env('MOBILE_ICON_HEIGHT') }})</h5>

            @php
                $menubar = [
                    'menubar_profile_button',
                    'menubar_library_button',
                    'menubar_home_button',
                    'menubar_orders_button',
                    'menubar_messages_button',
                    'empty_library_icon'
                ];
            @endphp

            @foreach($menubar as $field)
                <div class="form-group">
                    <label>{{ ucfirst(str_replace('_',' ',$field)) }}</label>

                    <input type="file"
                           name="{{ $field }}"
                           class="form-control image-input"
                           data-preview="preview_{{ $field }}"
                           data-type="icon">

                    <input type="hidden"
                           name="remove_{{ $field }}"
                           id="remove_{{ $field }}"
                           value="0">

                    <div class="image-preview-container">
                        <img id="preview_{{ $field }}"
                            src="{{ $mobile_setting->$field && strpos($mobile_setting->$field, '/') === false ? asset('storage/mobile/'.$mobile_setting->$field) : $mobile_setting->$field }}"

                             class="preview-image"
                             style="height:80px;">

                        @if($mobile_setting->$field)
                            <button type="button"
                                    class="remove-image-btn remove-image"
                                    data-preview="preview_{{ $field }}"
                                    data-input="remove_{{ $field }}">
                                ×
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach

            <hr>

            {{-- BACKGROUND SETTINGS --}}

            <h5>Background Settings ({{ env('MOBILE_BACKGROUND_WIDTH') }}x{{ env('MOBILE_BACKGROUND_HEIGHT') }})</h5>

            <div id="bg_color_div">
                <label>Background Color</label>

                <input type="color"
                       name="background_color_info"
                       class="form-control"
                       value="{{ $mobile_setting->background_color_info }}">
            </div>

            <div id="bg_image_div">
                <label>Background Image</label>

                <input type="file"
                    name="background_img_info"
                    class="form-control image-input"
                    data-preview="preview_bg"
                    data-type="background">

                <input type="hidden"
                    name="remove_background_img_info"
                    id="remove_background_img_info"
                    value="0">

                <div class="image-preview-container">
                    <img id="preview_bg"
                        src="{{ $mobile_setting->background_img_info && strpos($mobile_setting->background_img_info, '/') === false ? asset('storage/mobile/'.$mobile_setting->background_img_info) : $mobile_setting->background_img_info }}"
                        
                        class="preview-image">

                    @if($mobile_setting->background_img_info)
                        <button type="button"
                                class="remove-image-btn remove-image"
                                data-preview="preview_bg"
                                data-input="remove_background_img_info">
                            ×
                        </button>
                    @endif
                </div>
            </div>

            {{-- <div class="form-group">
                <label>Background Type</label>

                <select id="background_type"
                        name="background_type"
                        class="form-control">
                    <option value="">Select</option>
                    <option value="color" {{ $mobile_setting->background_color_info ? 'selected':'' }}>
                        Color
                    </option>
                    <option value="image" {{ $mobile_setting->background_img_info ? 'selected':'' }}>
                        Image
                    </option>
                </select>
            </div>

            <div id="bg_color_div" style="{{ $mobile_setting->background_color_info ? '' : 'display:none' }}">
                <label>Background Color</label>

                <input type="color"
                       name="background_color_info"
                       class="form-control"
                       value="{{ $mobile_setting->background_color_info }}">
            </div>

            <div id="bg_image_div" style="{{ $mobile_setting->background_img_info ? '' : 'display:none' }}">
                <label>Background Image</label>

                <input type="file"
                       name="background_img_info"
                       class="form-control image-input"
                       data-preview="preview_bg"
                       data-type="background">

                <input type="hidden"
                       name="remove_background_img_info"
                       id="remove_preview_bg"
                       value="0">

                <div class="image-preview-container">
                    <img id="preview_bg"
                         src="{{ $mobile_setting->background_img_info ? asset('storage/mobile/'.$mobile_setting->background_img_info) : '' }}"
                         class="preview-image">
                </div>
            </div> --}}

            <hr>

            {{-- COLOR SETTINGS --}}

            <h5>Color Settings</h5>

            <div class="form-group">
                <label>Topbar Color</label>

                <input type="color"
                       name="topbar_bg_color"
                       class="form-control"
                       value="{{ $mobile_setting->topbar_bg_color }}">
            </div>

            <div class="form-group">
                <label>Bottombar Color</label>

                <input type="color"
                       name="bottombar_bg_color"
                       class="form-control"
                       value="{{ $mobile_setting->bottombar_bg_color }}">
            </div>

            <div class="form-group">
                <label>Button Color</label>

                <input type="color"
                       name="button_bg_color"
                       class="form-control"
                       value="{{ $mobile_setting->button_bg_color }}">
            </div>

            <div class="form-group">
                <label>Font Color</label>

                <input type="color"
                       name="font_color"
                       class="form-control"
                       value="{{ $mobile_setting->font_color }}">
            </div>

            <button class="btn btn-primary btn-sm mt-3">
                Save Settings
            </button>
            <button class="btn btn-secondary btn-sm mt-3" type="button" onclick="window.location.href='{{ route('mobile-app-settings.reset') }}'">
                Reset to Default
            </button>

        </form>
    </div>

    {{-- Invalid Size Modal --}}
    <div class="modal fade" id="sizeErrorModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Invalid Image Size</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <p id="sizeErrorMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('customjs')
    <script>
        const LIMITS = {
            background: { w: {{ env('MOBILE_BACKGROUND_WIDTH', 300) }}, h: {{ env('MOBILE_BACKGROUND_HEIGHT', 300) }} },
            logo: { w: {{ env('MOBILE_LOGO_WIDTH', 300) }}, h: {{ env('MOBILE_LOGO_HEIGHT', 300) }} },
            // gif: { w: {{ env('MOBILE_GIF_WIDTH', 300) }}, h: {{ env('MOBILE_GIF_HEIGHT', 300) }} },
            icon: { w: {{ env('MOBILE_ICON_WIDTH', 130) }}, h: {{ env('MOBILE_ICON_HEIGHT', 130) }} }
        };

        $(document).on('change', '.image-input', function() {
            let input = this;
            let previewId = $(this).data('preview');
            let type = $(this).data('type');
            let limit = LIMITS[type];

            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    let img = new Image();
                    img.src = e.target.result;

                    img.onload = function() {
                        if (img.width != limit.w || img.height != limit.h) {
                            $('#sizeErrorMessage').html(`The selected image is <b>${img.width}x${img.height}px</b>.<br>Required dimensions are <b>${limit.w}x${limit.h}px</b>.`);
                            $('#sizeErrorModal').modal('show');
                            $(input).val('');
                            $('#' + previewId).attr('src', '');
                        } else {
                            $('#' + previewId).attr('src', e.target.result);
                            $(`button[data-preview="${previewId}"]`).show();
                            $(`#remove_${previewId.replace('preview_', '')}`).val(0);
                        }
                    };
                };

                reader.readAsDataURL(input.files[0]);
            }
        });

        $(document).on('click', '.remove-image', function() {
            let preview = $(this).data('preview');
            let input = $(this).data('input');

            $('#' + preview).attr('src', '');
            $('#' + input).val(1);

            $(this).hide();
        });

        $('#background_type').change(function() {
            let type = $(this).val();

            $('#bg_color_div, #bg_image_div').hide();

            if (type === 'color') {
                $('#bg_color_div').show();
            } else if (type === 'image') {
                $('#bg_image_div').show();
            }
        });
    </script>
@endsection
