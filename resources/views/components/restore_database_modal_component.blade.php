<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path
            d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </symbol>
</svg>
<div class="modal fade" id="restoreDatabaseModal" tabindex="-1" aria-labelledby="restoreDatabaseModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-center" data-bs-dismiss="modal">
                <h5 class="modal-title w-100" id="restoreDatabaseModalLabel">Restore Database</h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-flex align-items-center mb-2" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                        <use xlink:href="#exclamation-triangle-fill"/>
                    </svg>
                    <div class="m-3">
                        <strong>Warning:</strong> This action involves high risk, including potential data loss and
                        database inconsistency. Proceed with caution and ensure you have a verified backup before
                        proceeding.
                    </div>
                </div>
                <form action="{{route('database_restore')}}" method="POST" enctype="multipart/form-data">
                    @csrf <!-- {{ csrf_field() }} -->
                    <div class="mb-3 pt-3 input-group">
                        <input type="file" class="form-control" id="fileInput" name="fileInput" accept=".sql" required>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-outline-secondary mt-2 w-100"
                                    data-bs-dismiss="modal">
                                Cancel
                            </button>
                        </div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-primary mt-2 w-100">
                                Restore Database
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
