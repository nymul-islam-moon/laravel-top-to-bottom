<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateModalLabel">Edit Modal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="errorMsgContainer">

            </div>
            <div class="modal-body">
                <form class="row g-3" action="{{ route('test.submit') }}" method="POST" id="submit-form">
                    @csrf
                    @method('PUT')
                    <div class="row g-3 form-floating">
                        <div class="col">
                        <input type="text" class="form-control" id="update_name" name="name" placeholder="Full Name" aria-label="Full Name">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary update-btn">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
