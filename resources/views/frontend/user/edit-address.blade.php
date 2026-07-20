<form action="{{ route('user.updateAddress') }}" method="post" id="editForm">
    @csrf
    <input type="hidden" id="edit_address_id" name="edit_address_id" value="{{ $address->id }}">
    <div class="modal-body">
        <div class="row gy-3">
            <small id="emailHelp" class="form-text text-muted">Your information is safe with us.</small>
            <div class="col-lg-12">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="address_type"
                        id="editRadioHome" value="Home" @checked($address->address_type == "Home")>
                    <label class="form-check-label" for="editRadioHome">Home</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="address_type"
                        id="editRadioOffice" value="Office" @checked($address->address_type == "Office")>
                    <label class="form-check-label" for="editRadioOffice">Office</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="address_type"
                        id="editRadioOthers" value="Others" @checked($address->address_type == "Others")>
                    <label class="form-check-label" for="editRadioOthers">Others</label>
                </div>
            </div>
            <div class="col-lg-4">
                <label class="form-label" for="edit_shipping_name">Full Name</label>
                <input type="text" class="form-control" id="edit_shipping_name" name="shipping_name"
                    placeholder="Enter Your Full Name" value="{{ $address->shipping_name }}">
                <div id="edit_shipping_name_error" class="text-danger"></div>
            </div>
            <div class="col-lg-4">
                <label class="form-label" for="edit_shipping_email">Email address</label>
                <input type="email" class="form-control" id="edit_shipping_email"
                    name="shipping_email" placeholder="Enter email" value="{{ $address->shipping_email }}">
                <div id="edit_shipping_email_error" class="text-danger"></div>
            </div>
            <div class="col-lg-4">
                <label class="form-label" for="edit_shipping_phone">Phone</label>
                <input type="phone" class="form-control" id="edit_shipping_phone"
                    name="shipping_phone" placeholder="+9187654321" value="{{ $address->shipping_phone }}">
                <div id="edit_shipping_phone_error" class="text-danger"></div>
            </div>
            <div class="col-lg-4">
                <label class="form-label" for="edit_shipping_address">Address</label>
                <input type="address" class="form-control" id="edit_shipping_address"
                    name="shipping_address" placeholder="Add Address..." value="{{ $address->shipping_address }}">
                <div id="edit_shipping_address_error" class="text-danger"></div>
            </div>
            <div class="col-lg-4">
                <label class="form-label" for="country">Country</label>
                <select class="form-control" id="edit_shipping_country" name="country">
                    <option value="">Select Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}" @selected($country->id == $address->country)>{{ $country->name }}</option>
                    @endforeach
                </select>
                <div id="edit_shipping_country_error" class="text-danger"></div>
            </div>
            <div class="col-lg-4">
                <label class="form-label" for="state">State</label>
                <select class="form-control" id="edit_shipping_state" name="state">
                    <option value="">Select State</option>
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}" @selected($state->id == $address->state)>{{ $state->name }}</option>
                    @endforeach
                </select>
                <div id="edit_shipping_state_error" class="text-danger"></div>
            </div>
            <div class="col-lg-4">
                <label class="form-label" for="city">City</label>
                <select class="form-control" id="edit_shipping_city" name="city">
                    <option value="">Select City</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" @selected($city->id == $address->city)>{{ $city->name }}</option>
                    @endforeach
                </select>
                <div id="edit_shipping_city_error" class="text-danger"></div>
            </div>
            <div class="col-lg-4">
                <label class="form-label" for="edit_pincode">Pincode</label>
                <input type="number" class="form-control" id="edit_pincode" name="pincode"
                    placeholder="pincode" value="{{ $address->pincode }}">
                <div id="edit_pincode_error" class="text-danger"></div>
            </div>
        </div>
        <div class="row align-items-center mt-2">
            <div class="col-auto">
                <input type="checkbox" id="is_default" name="is_default" class="form-check-input" @checked($address->is_default == 1)>
            </div>
            <div class="col">
                <label for="is_default" class="form-check-label">Check this as default address</label>
            </div>
        </div>
    </div>
    <div class="modal-footer border-0">
        <button type="button" class="text-light btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="text-light btn-success">Save changes</button>
    </div>
</form>