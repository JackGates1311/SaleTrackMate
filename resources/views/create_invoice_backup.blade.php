<hr/>
<section class="min-vh-100 gradient-form d-flex justify-content-center align-items-center">
    <div class="container pb-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black border-0">
                    <div class="row g-0">
                        <div class="col-lg-12">
                            <div class="card-body p-3">
                                <div class="text-center">
                                    <h4 class="mt-1 mb-3 pb-1">Create Invoice</h4>
                                </div>
                                <hr/>
                                <form accept-charset="UTF-8" action="#" method="POST">
                                    @csrf <!-- {{ csrf_field() }} -->
                                    @component('components.forms.invoice_form_component')
                                    @endcomponent
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
