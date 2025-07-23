
<!-- Participant Modal -->
<div class="modal fade" id="participantModal" tabindex="-1" aria-labelledby="participantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="participantModalLabel">Course Participants</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Course ID</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="participant-table-body">
                        <!-- Rows akan diisi oleh JavaScript -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="addParticipantBtn">Add Participant</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Participant Modal -->
<div class="modal fade" id="addParticipantModal" tabindex="-1" aria-labelledby="addParticipantModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addParticipantModalLabel">Add Participant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addParticipantForm">
                    @csrf
                    <input type="hidden" name="course_id" id="course_id">
                    <div class="mb-3">
                        <label for="participant_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="participant_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="participant_role" class="form-label">Role</label>
                        <input type="text" class="form-control" id="participant_role" name="participant_role">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Participant</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

