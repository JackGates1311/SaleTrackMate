<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Create Invoice - SaleTrackMate</title>
    @component('components.header_component')
    @endcomponent
</head>
<body>
@component('components.navbar_component', ['companies' => []])
@endcomponent

<!-- <div class="vh-100 d-flex flex-column gradient-form">
    <div class="container mt-lg-4 mt-2">
        <div id="tabContainer" class="tabContainer">
            <div class="tabs" id="tabs">
                <ul class="nav nav-tabs">
                    <li class="nav-item" id="tabHeader_1">Page 1</li>
                    <li class="nav-item" id="tabHeader_2">Page 2</li>
                    <li class="nav-item" id="tabHeader_3">Page 3</li>
                </ul>
            </div>
            <div id="tabscontent" class="tab-content">
                <div class="tabpage" id="tabpage_1">
                    <h2>Page 1</h2>
                    <p>Lorem Ipsum is simply dummy text </p>

                </div>
                <div class="tabpage" id="tabpage_2" style="display:none;">
                    <h2>Page 2</h2>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's standard dummy text ever since the 1500s,
                    </p>
                </div>
                <div class="tabpage" id="tabpage_3" style="display:none;">
                    <h2>Page 3</h2>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's standard dummy text ever since the 1500s,
                    </p>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's standard dummy text ever since the 1500s,
                    </p>
                </div>
            </div>
        </div>

        <div class="gototab" onclick="goToTabByDelta(-1)">Previous</div>
        <div class="gototab" onclick="goToTabByDelta(+1)">Next</div>

        <div style="clear:both;">&nbsp;<div>

                <p style="margin-top: 150px;"></p>

            </div>
        </div>
    </div>
</div> !-->
<div class="vh-100 d-flex flex-column gradient-form">
    <div class="container mt-lg-4 mt-2">
        <div id="tabContainer" class="tabContainer">
            <ul class="nav nav-tabs" id="tabs">
                <li class="nav-item" id="tabHeader_1">
                    <a class="nav-link active" href="#tabpage_1" role="tab" aria-selected="true">Page 1</a>
                </li>
                <li class="nav-item" id="tabHeader_2">
                    <a class="nav-link" href="#tabpage_2" role="tab" aria-selected="false">Page 2</a>
                </li>
                <li class="nav-item" id="tabHeader_3">
                    <a class="nav-link" href="#tabpage_3" role="tab" aria-selected="false">Page 3</a>
                </li>
            </ul>
        </div>
        <div class="tab-content" id="tabscontent">
            <div class="tab-pane show active" id="tabpage_1" role="tabpanel">
                <h2>Page 1</h2>
                <p>Lorem Ipsum is simply dummy text</p>
            </div>
            <div class="tab-pane" id="tabpage_2" role="tabpanel">
                <h2>Page 2</h2>
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                    the industry's standard dummy text ever since the 1500s.
                </p>
            </div>
            <div class="tab-pane" id="tabpage_3" role="tabpanel">
                <h2>Page 3</h2>
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                    the industry's standard dummy text ever since the 1500s.
                </p>
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                    the industry's standard dummy text ever since the 1500s.
                </p>
            </div>
        </div>
        <div class="btn-group" role="group" aria-label="Navigation Buttons">
            <button type="button" class="btn btn-secondary" onclick="goToTabByDelta(-1)">Previous</button>
            <button type="button" class="btn btn-primary" onclick="goToTabByDelta(1)">Next</button>
        </div>
    </div>
</div>
</body>

<script src="{{ asset('js/invoice.js') }}"></script>
</html>
