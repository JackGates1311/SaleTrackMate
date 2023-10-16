<form method="GET" action="{{route('selectRecipient')}}">
    <div class="d-flex flex-column flex-lg-row">
        <div
            class="d-flex flex-column flex-lg-row justify-content-start justify-content-lg-start w-100 w-lg-50">
            <label for="recipientSelect">Recipient:</label>
            <select
                class="form-select mb-3 mb-lg-0 me-lg-2 w-sm-100 w-100" id="recipientSelect"
                name="recipient"
                onchange="this.form.submit()">
                @if(isset($recipients) && count($recipients) > 0)
                    @foreach ($recipients as $recipient)
                        <option value="{{ $recipient['id'] }}"
                            {{ $selected_recipient && $selected_recipient['id'] === $recipient['id'] ? 'selected' : '' }}>
                            {{ $recipient['name'] }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
        <hr/>
    </div>
</form>
