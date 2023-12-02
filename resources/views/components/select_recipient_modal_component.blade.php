<div class="modal fade" id="selectRecipientModal" tabindex="-1" aria-labelledby="selectRecipientModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-center" data-bs-dismiss="modal">
                <h5 class="modal-title w-100" id="changePasswordModalLabel">Select Recipient</h5>
            </div>
            <div class="modal-body">
                @if(isset($recipient_list) && count($recipient_list) > 0)
                    <label for="recipientSelect" class="form-label">Recipient:</label>
                    <select
                        class="form-select mb-3 mb-lg-0 me-lg-2 w-sm-100 w-100" id="recipientSelect">
                        @foreach ($recipient_list as $recipient_data)
                            <option value="{{ $recipient_data['id'] }}"
                                    data-recipient="{{ json_encode($recipient_data) }}">
                                {{ $recipient_data['name'] }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <h5 class="text-center">It looks like you haven't saved a recipient yet</h5>
                    <p class="small text-center pt-3">To save your first recipient, on navigation bar click on <b><i>Recipients</i></b>
                        and then click on <b><i>Add New Recipient</i></b></p>
                @endif
            </div>
            <div class="modal-footer">
                @if(isset($recipient_list) && count($recipient_list) > 0)
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="selectRecipient(null)">Select Recipient
                    </button>
                @else
                    <button type="button" class="btn btn-primary w-25" data-bs-dismiss="modal">OK</button>
                @endif
            </div>
        </div>
    </div>
</div>
