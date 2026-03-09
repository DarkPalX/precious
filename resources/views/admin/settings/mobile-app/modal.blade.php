<div class="modal fade" id="prompt-remove-logo">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Remove Image</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                Are you sure you want to remove this image?
            </div>

            <form method="POST" action="{{ route('mobile-app-settings.remove-logo') }}">
                @csrf

                <input type="hidden" name="field" id="remove_field">

                <div class="modal-footer">

                    <button class="btn btn-danger btn-sm">
                        Yes Remove
                    </button>

                    <button class="btn btn-secondary btn-sm" data-dismiss="modal">
                        Cancel
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>