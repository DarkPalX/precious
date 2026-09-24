<!-- JavaScripts
============================================= -->
<script src="{{ asset('theme/js/jquery.js') }}"></script>
<script src="{{ asset('theme/js/plugins.min.js') }}"></script>
<script src="{{ asset('theme/js/bs-filestyle.js') }}"></script>

<script>
    $(document).ready(function() {
        if(localStorage.getItem('popState') != 'shown'){
            $('#popupPrivacy').delay(1000).fadeIn();
        }
    });

    $('#cookieAcceptBarConfirm').click(function() // You are clicking the close button
    {
        $('#popupPrivacy').fadeOut(); // Now the pop up is hidden.
        localStorage.setItem('popState','shown');
    });
</script>

<!-- Footer Scripts
============================================= -->
@include('theme.layouts.components.banner-scripts')

<script src="{{ asset('theme/js/slick.js') }}"></script>
<script src="{{ asset('theme/js/slick.extension.js') }}"></script>
<script src="{{ asset('theme/js/cookiealert.js') }}"></script>
<script src="{{ asset('theme/js/functions.js') }}"></script>
<script src="{{ asset('js/notify.js') }}"></script>

<script>
	jQuery(document).ready( function($){
		function modeSwitcher( elementCheck, elementParent ) {
			if( elementCheck.filter(':checked').length > 0 ) {
				elementParent.addClass('dark');
				$('.mode-switcher').toggleClass('pts-switch-active');
			} else {
				elementParent.removeClass('dark');
				$('.mode-switcher').toggleClass('pts-switch-active', false);
			}
		}

		$('.pts-switcher').each( function(){
			var element = $(this),
				elementCheck = element.find(':checkbox'),
				elementParent = $('body');

			modeSwitcher( elementCheck, elementParent );

			elementCheck.on( 'change', function(){
				modeSwitcher( elementCheck, elementParent );
			});
		});
	});
</script>



<script>
    $(document).on('click', '.show_hide_password a', function(event) {
        event.preventDefault();

        var passwordInput = $(this).closest('.show_hide_password').find('input').first();
        var passwordIcon = $(this).find('i');
        var isVisible = passwordInput.attr('type') === 'text';

        passwordInput.attr('type', isVisible ? 'password' : 'text');
        passwordIcon.toggleClass('icon-eye-slash', isVisible);
        passwordIcon.toggleClass('icon-eye', !isVisible);
    });

    function top_remove_product(id){
        $('#top-product-id').val(id);
        $('#remove-top-product').submit();
    }
</script>

<script>
    // Select all elements with the class "no-paste"
    var noPasteElements = document.querySelectorAll('.no-paste');

    // Loop through each element and attach event listener
    noPasteElements.forEach(function(element) {
        element.addEventListener('paste', function(event) {
            event.preventDefault();
        });
    });

    // Select all elements with the class "numbers-only"
    var numbersOnlyElements = document.querySelectorAll('.numbers-only');

    // Loop through each element and attach event listener
    numbersOnlyElements.forEach(function(element) {
        element.addEventListener('paste', function(event) {
            event.preventDefault();
        });

        element.addEventListener('input', function(event) {
            this.value = this.value.replace(/\D/g, '');
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#pageModal').modal('show');

        if(localStorage.getItem('popState') != 'shown'){
            $('#popupPrivacy').delay(1000).fadeIn();
        }
    });

    $('#cookieAcceptBarConfirm').click(function() // You are clicking the close button
    {
        $('#popupPrivacy').fadeOut(); // Now the pop up is hidden.
        localStorage.setItem('popState','shown');
    });
</script>


<script>
    function getEmail(){
        var email = $('#widget-subscribe-form-email').val(); // Get the value of the email input field
        $('#subscriber_email').val(email); // Set the value of the email input field in the modal form
    }
</script>


@yield('pagejs')
