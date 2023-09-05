<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-center" data-bs-dismiss="modal">
                <h5 class="modal-title w-100" id="changePasswordModalLabel">Change Password</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="password" class="form-label">Current Password:</label>
                        <input type="password" class="form-control" id="password"
                               placeholder="Your current password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password:</label>
                        <input type="password" class="form-control" id="new_password"
                               placeholder="Your new password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_new_password" class="form-label">Confirm New Password:</label>
                        <input type="password" class="form-control" id="confirm_new_password"
                               placeholder="Repeat your new password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Change Password</button>
            </div>
        </div>
    </div>
</div>
