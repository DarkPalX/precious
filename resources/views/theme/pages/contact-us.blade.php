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
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                </div>
            @endif
            
            @if(session()->has('error'))
                <div class="style-msg successmsg">
                    <div class="sb-msg"><i class="icon-thumbs-up"></i><strong>Success!</strong> {{ session()->get('error') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                </div>
            @endif
            <p><strong>Note:</strong> Please do not leave required fields (*) empty.</p>
            <div class="form-style fs-sm">
                <form action="{{ route('contact-us') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="fullName" class="fs-6 fw-semibold text-initial nols">Full Name <span class="text-danger">*</span></label>
                        <input type="text" id="fullName" class="form-control form-input" name="name" placeholder="First and Last Name" />
                    </div>

                    <div class="form-group">
                        <label for="emailAddress" class="fs-6 fw-semibold text-initial nols">E-mail Address <span class="text-danger">*</span></label>
                        <input type="email" id="emailAddress" class="form-control form-input" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="hello@email.com" />
                    </div>
                    <div class="form-group">
                        <label for="contactNumber" class="fs-6 fw-semibold text-initial nols">Contact Number <span class="text-danger">*</span></label>
                        <input type="number" id="contactNumber" class="form-control form-input" name="contact" placeholder="Landline or Mobile" />
                    </div>
                    <div class="form-group">
                        <label for="message" class="fs-6 fw-semibold text-initial nols">Message <span class="text-danger">*</span></label>
                        <textarea name="message" id="message" class="form-control form-input textarea" rows="5"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label text-danger" for="g-recaptcha-response" id="catpchaError" style="display:none;font-size: 14px;"><i class="fa fa-times-circle-o"></i>The Captcha field is required.</label></br>
                        @if($errors->has('g-recaptcha-response'))
                            @foreach($errors->get('g-recaptcha-response') as $message)
                                <label class="control-label text-danger" for="g-recaptcha-response"><i class="fa fa-times-circle-o"></i>{{ $message }}</label></br>
                            @endforeach
                        @endif
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <a href="#" class="button button-circle border-bottom ms-0 text-initial nols fw-normal button-large d-block text-center">Submit</a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="button button-circle button-dark border-bottom ms-0 text-initial nols fw-normal button-large d-block text-center">Reset</a>
                        </div>
                    </div>
                </form>
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

    $('#contactUsForm').submit(function (evt) {
        let recaptcha = $("#g-recaptcha-response").val();
        if (recaptcha === "") {
            evt.preventDefault();
            $('#catpchaError').show();
            return false;
        }
    });
</script>
@endsection
