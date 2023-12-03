<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>About - SaleTrackMate</title>
    @component('components.header_component')
    @endcomponent
</head>
<body>
@component('components.navbar_component')
@endcomponent
<section class="min-vh-100 gradient-form d-flex justify-content-center align-items-center">
    <div class="container pb-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black border-0 p-4">
                    <div class="row g-0">
                        <div class="col-lg-6 p-4 description-text text-center">
                            <h2 class="my-5">About SaleTrackMate</h2>
                            <p>SaleTrackMate, born from a student's graduation project, is dedicated to enhancing the
                                efficiency of invoicing management. Our software simplifies the invoicing process,
                                making it seamless and streamlined. While currently focused on invoicing management.
                                Our aspiration is to expand and enhance this capability, turning SaleTrackMate into a
                                comprehensive solution for businesses. Stay tuned as we evolve to meet the diverse needs
                                of businesses, aiming to become a significant player in the realm of efficient invoicing
                                management</p>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center gradient-form-black p-4"
                             id="description-section">
                            <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                <div class="contact-us mb-3">
                                    <img src="{{ asset('images/res/call.png') }}" alt="arrow_forward" width="32"
                                         height="32">
                                    +381 70 12 34 567
                                </div>
                                <div class="contact-us mb-3">
                                    <img src="{{ asset('images/res/alternate_email.png') }}" alt="arrow_forward"
                                         width="32" height="32">
                                    mail@example.com
                                </div>
                                <div class="contact-us mb-3">
                                    <img src="{{ asset('images/res/store.png') }}" alt="arrow_forward" width="32"
                                         height="32">
                                    Tax Code: 123456789
                                </div>
                                <div class="contact-us mb-3">
                                    <img src="{{ asset('images/res/house.png') }}" alt="arrow_forward" width="32"
                                         height="32">
                                    Bulevar Kralja Petra I, Novi Sad, Serbia
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
