<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <title>SaleTrackMate</title>

    @component('header_component')
    @endcomponent

</head>
<body>
@component('navbar_component')
@endcomponent
<section class="carousel-section">
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="10000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/image0.jpg') }}"
                     alt="Analyze Analytics Image">
                <div class="carousel-caption p-5">
                    <h5>Analyze Analytics of Invoices</h5>
                    <p class="carousel-paragraph">Access detailed financial insights: revenue, expenses, profit margins, and more</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/image1.jpg') }}" alt="Easy Recipient and Article Selection Image">
                <div class="carousel-caption p-5">
                    <h5>Management of Recipients</h5>
                    <p class="carousel-paragraph">Efficiently manage recipient info for invoicing. Add, update, and organize clients easily</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/image2.jpg') }}" alt="Simplified Fiscal Year Management Image">
                <div class="carousel-caption p-5">
                    <h5>Fiscal Year Management</h5>
                    <p class="carousel-paragraph">Track income and expenses by managing fiscal years. Organize financial records with ease</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/image3.jpg') }}" alt="Goods and Services Management Image">
                <div class="carousel-caption p-5">
                    <h5>Goods and Services Management</h5>
                    <p class="carousel-paragraph">Efficiently manage products, taxes, and billing for accurate invoicing.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/image4.jpg') }}" alt="Recipients Management Image">
                <div class="carousel-caption p-5">
                    <h5>Recipients Management</h5>
                    <p class="carousel-paragraph">Efficiently organize recipient info with additions and updates for streamlined invoicing.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{asset('images/image5.jpg')}}" alt="Invoice Management Image">
                <div class="carousel-caption p-5">
                    <h5>Invoice Management</h5>
                    <p class="carousel-paragraph">Manage invoices through easy creation and closure, recipient selection, and item selection.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{asset('images/image6.jpg')}}" alt="Printing Invoices Image">
                <div class="carousel-caption p-5">
                    <h5>Export of Invoices</h5>
                    <p class="carousel-paragraph">Easily export invoices as PDF or XML files for sharing, and print them when required.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{asset('images/image7.jpg')}}" alt="Company Information Management Image">
                <div class="carousel-caption p-5">
                    <h5>Company Data Management</h5>
                    <p class="carousel-paragraph">Update and view company details, including contact info, address, company name, and relevant data.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{asset('images/image8.jpg')}}" alt="Secure Data Encryption Image">
                <div class="carousel-caption p-5">
                    <h5>Secure Data Encryption</h5>
                    <p class="carousel-paragraph">Enhance security with user authentication for sensitive data protection.</p>
                </div>
            </div>
        </div>
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="3" aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="4" aria-label="Slide 5"></button>
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="5" aria-label="Slide 6"></button>
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="6" aria-label="Slide 7"></button>
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="7" aria-label="Slide 8"></button>
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="8" aria-label="Slide 9"></button>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <img src="{{ asset('images/res/arrow_back.png') }}" alt="arrow_back" width="32" height="32">
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <img src="{{ asset('images/res/arrow_forward.png') }}" alt="arrow_forward" width="32" height="32">
            <span class="visually-hidden">Next</span>
        </button>
    </div>

</section>

<footer class="text-center py-3">
    <div class="container">
        <p>&copy; {{ date('Y') }} SaleTrackMate. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
