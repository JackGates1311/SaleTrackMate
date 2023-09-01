<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Account Settings - SaleTrackMate</title>
    @component('components.header_component')
    @endcomponent
</head>
<body>
@component('components.navbar_component')
@endcomponent

<div class="vh-100 d-flex flex-column gradient-form">
    <div class="container mt-3 flex-grow-1">
        <div class="row">
            <!-- Left Panel -->
            <div class="col-lg-12">
                <div class="accordion text-center" id="settingsAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="companySettingsHeader">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#companySettings" aria-expanded="true" aria-controls="companySettings">
                                Manage Companies
                            </button>
                        </h2>
                        <div id="companySettings" class="accordion-collapse collapse show" aria-labelledby="companySettingsHeader" data-bs-parent="#settingsAccordion">
                            <div class="accordion-body">
                                <!-- Company Settings Form -->
                                <form>
                                    <div class="mb-3">
                                        <label for="companyName" class="form-label">Company Name</label>
                                        <input type="text" class="form-control" id="companyName" name="companyName">
                                    </div>
                                    <div class="mb-3">
                                        <label for="companyAddress" class="form-label">Company Address</label>
                                        <input type="text" class="form-control" id="companyAddress" name="companyAddress">
                                    </div>
                                    <!-- More company properties... -->
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="userInfoHeader">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#userInfo" aria-expanded="false" aria-controls="userInfo">
                                View User Info
                            </button>
                        </h2>
                        <div id="userInfo" class="accordion-collapse collapse" aria-labelledby="userInfoHeader" data-bs-parent="#settingsAccordion">
                            <div class="accordion-body">
                                <!-- User Info Display -->
                                <p><strong>Name:</strong> John Doe</p>
                                <p><strong>Email:</strong> john@example.com</p>
                                <p><strong>Role:</strong> Administrator</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
