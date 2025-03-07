<!-- Deceased Confirmation Modal -->
<div class="modal fade" id="confirmDeceasedModal" tabindex="-2" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content custom-modal-shadow"> <!-- Add custom class for shadow -->
            <div class="modal-header custom-modal-header bg-danger text-white p-2 d-flex align-items-center">
                <h5 class="modal-title m-0 d-flex align-items-center">
                    <i class="fa fa-exclamation-triangle me-2"></i> Confirm Deceased Status
                </h5>
            </div>

            <div class="modal-body">
                <p>Are you sure you want to mark <strong id="profileName"></strong> as deceased?</p>
                <input type="hidden" id="deceasedProfileId"> <!-- Hidden field to store profile ID -->

                <!-- New Date of Death Input -->
                <div class="mb-3">
                    <label for="deceasedDate" class="form-label">Date of Death:</label>
                    <input type="date" id="deceasedDate" class="form-control">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelDeceasedBtn">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeceasedBtn">Yes, mark as deceased</button>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-modal-header {
        background-color: #c82333 !important; /* Slightly darker red, closer to btn-danger */
    }
    .custom-modal-shadow {
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.8) !important; /* Darker shadow */
        border-radius: 10px; /* Optional: Rounded corners */
    }
</style>
