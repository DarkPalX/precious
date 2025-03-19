@extends('theme.main')

@section('pagecss')
@endsection

@section('content')
<div class="container topmargin-lg bottommargin-lg">
    <div class="row">
        <div class="col-lg-8 mb-5">
            {!! $page->contents !!}
        </div>
        <div class="col-lg-4">
            <h3>Leave Us a Message</h3>
            @if(session()->has('success'))
                <div class="style-msg successmsg">
                    <div class="sb-msg"><i class="icon-thumbs-up"></i><strong>Success!</strong> {{ session()->get('success') }}</div>
                    {{-- <button type="button" class="btn-close btn-sm" data-dismiss="alert" aria-hidden="true">&times;</button> --}}
                </div>
            @endif
            
            @if(session()->has('error'))
                <div class="style-msg successmsg">
                    <div class="sb-msg"><i class="icon-thumbs-up"></i><strong>Success!</strong> {{ session()->get('error') }}</div>
                    {{-- <button type="button" class="btn-close btn-sm" data-dismiss="alert" aria-hidden="true">&times;</button> --}}
                </div>
            @endif
            <p><strong>Note:</strong> Please do not leave required fields (*) empty.</p>
            <div class="form-style fs-sm">
                <form id="contactUsForm" action="{{ route('contact-us') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="fullName" class="fs-6 fw-semibold text-initial nols">Full Name <span class="text-danger">*</span></label>
                        <input type="text" id="fullName" class="form-control form-input" name="name" placeholder="First and Last Name" required/>
                    </div>

                    <div class="form-group">
                        <label for="emailAddress" class="fs-6 fw-semibold text-initial nols">E-mail Address <span class="text-danger">*</span></label>
                        <input type="email" id="emailAddress" class="form-control form-input" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="hello@email.com" required/>
                    </div>
                    <div class="form-group">
                        <label for="contactNumber" class="fs-6 fw-semibold text-initial nols">Contact Number</label>
                        <input type="number" id="contactNumber" class="form-control form-input" name="contact" placeholder="Landline or Mobile" />
                    </div>
                    <div class="form-group">
                        <label for="mail_attachments" class="fs-6 fw-semibold text-initial nols">Attachments</label>
                        <div class="col-lg-12">
                            <input id="mail_attachments" name="mail_attachments[]" type="file" multiple class="file-loading" data-show-preview="false" 
                                accept=".png, .jpg" 
                                onchange="
                                        if(this.files.length > 3) { 
                                            alert('You can upload a maximum of 3 files'); this.value = ''; 
                                        } 
                                        else { 
                                            Array.from(this.files).forEach(f => { 
                                                if (f.size > 3145728) { 
                                                    alert('File size must be less than 3MB'); this.value = ''; } 
                                                }
                                            )
                                        }"
                            >  

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="fs-6 fw-semibold text-initial nols">Message <span class="text-danger">*</span></label>
                        <textarea name="message" id="message" class="form-control form-input textarea" rows="5" required></textarea>
                    </div>
                    
                    {{-- <div class="form-group">
                        <label class="control-label text-danger" for="g-recaptcha-response" id="catpchaError" style="display:none;font-size: 14px;"><i class="fa fa-times-circle-o"></i>The Captcha field is required.</label></br>
                        @if($errors->has('g-recaptcha-response'))
                            @foreach($errors->get('g-recaptcha-response') as $message)
                                <label class="control-label text-danger" for="g-recaptcha-response"><i class="fa fa-times-circle-o"></i>{{ $message }}</label></br>
                            @endforeach
                        @endif
                    </div> --}}
                    
                    <div class="form-group">
                        <div class="g-recaptcha recaptcha mt-2" name="g-recaptcha-response" id="g-recaptcha-response" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                        @endif
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            {{-- <a class="button button-circle border-bottom ms-0 text-initial nols fw-normal button-large d-block text-center" href="javascript:void(0)" onclick="document.getElementById('contactUsForm').submit()">Submit</a> --}}
                            <a class="button button-circle border-bottom ms-0 text-initial nols fw-normal button-large d-block text-center" href="javascript:void(0)" onclick="validateAndSubmit(event)">Submit</a>
                        </div>
                        <div class="col-md-6">
                            <a href="javascript:void(0)" class="button button-circle button-dark border-bottom ms-0 text-initial nols fw-normal button-large d-block text-center" onclick="resetForm();">Reset</a>
                        </div>
                    </div>
                    
                    {{-- hidden inputs --}}
                    <div class="form-group" style="display:none;">
                        <input type="text" id="services" class="form-control form-input" name="services" placeholder="Enter Subject" value="Design" required/>
                        <input type="text" id="subject" class="form-control form-input" name="subject" placeholder="Enter Subject" value="Design" required/>
                    </div>

                </form>
                {{-- captcha script --}}
                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            </div>

        </div>
    </div>
</div>
@endsection

@section('pagejs')
<script>

    /** form validations **/
    $(document).ready(function () {
        //called when key is pressed in textbox
        $("#contact").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            var charCode = (e.which) ? e.which : event.keyCode
            if (charCode != 43 && charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;

        });
    });

    // $('#contactUsForm').submit(function (evt) {
    //     let recaptcha = $("#g-recaptcha-response").val();
    //     if (recaptcha === "") {
    //         evt.preventDefault();
    //         $('#catpchaError').show();
    //         return false;
    //     }
    // });
    
    function resetForm() {
        document.getElementById("contactUsForm").reset();
    }
</script>
<script>
    function validateAndSubmit(event) {
        event.preventDefault(); // Prevent default anchor behavior
    
        let form = document.getElementById('contactUsForm');
        
        if (form.checkValidity()) {
            form.submit();
        } else {
            form.reportValidity(); // Show validation messages
        }
    }
    </script>

<script >
    jQuery(document).ready(function() {
        
        jQuery("#mail_attachments").fileinput({
            showUpload: false,
            layoutTemplates: {
                main1: "{preview}\n" +
                "<div class=\'input-group {class}\'>\n" +
                "       {browse}\n" +
                "       {upload}\n" +
                "       {remove}\n" +
                "   {caption}\n" +
                "</div>"
            }
        });
        
    });
</script>
@endsection
