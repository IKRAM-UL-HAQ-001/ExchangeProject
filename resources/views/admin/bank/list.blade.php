@extends("layout.main")
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 d-flex justify-content-between align-items-center px-3">
                        <p style="color: white;"><strong>Bank Table</strong></p>
                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addBankModal">Add New Bank</button>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table id="bankTable" class="table align-items-center mb-0 table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bank Name</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>ikram</td>
                                    <td>test</td>
                                    <td class="text-center">
                                        <button class="btn btn-danger btn-sm" onclick="deleteBank(this)">Delete</button>
                                    </td>
                                </tr>
                                <!-- Additional rows as needed -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addBankModal" tabindex="-1" aria-labelledby="addBankModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h5 class="modal-title" id="addBankModalLabel" style="color:white">Add New Bank</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addBankForm" method="post" action="">
                        <div class="mb-3">
                            <label for="name" class="form-label">Bank Name</label>
                            <input type="text" class="form-control border px-3" id="name" name="name" placeholder="Enter Bank Name" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addBank()">Save Bank</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#bankTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50]
    });
});

function addBank() {
    const name = document.getElementById('name').value;
    
    // Log or send data to the server
    console.log({ name});

    // Add new row to the DataTable
    const table = $('#bankTable').DataTable();
    table.row.add([
        name,
        '<button class="btn btn-danger btn-sm" onclick="deleteBank(this)">Delete</button>'
    ]).draw();

    // Close the modal
    var myModalEl = document.getElementById('addBankModal');
    var modal = bootstrap.Modal.getInstance(myModalEl);
    modal.hide();

    // Reset the form
    document.getElementById('addBankForm').reset();
}

function deleteBank(button) {
    const table = $('#bankTable').DataTable();
    table.row($(button).parents('tr')).remove().draw();
}
</script>

<style>
.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f2f2f2;
}

.table-hover tbody tr:hover {
    background-color: #e0e0e0;
}

.modal-header {
    background-color: #343a40;
    color: white;
}
</style>
@endsection
