@extends("layout.main")
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 d-flex justify-content-between align-items-center px-3">
                        <p style="color: white;"><strong>Opening Closing Balance Table</strong></p>
                        <div>
                            <a href="{{ route('export.openCloseBalance') }}" class="btn btn-dark">Export Opening Closing Balance List</a>
                            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addOwnerProfitModal">Opening Closing Balance Form</button>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2 px-3">
                    <div class="table-responsive p-0">
                        <table id="openingClosingBalanceTable" class="table align-items-center mb-0 table-striped table-hover px-2">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Opening Balance </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Closing Balance</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Balance</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($openingClosingBalanceRecords as $openingClosingBalance)
                                    <tr>
                                        <td>{{ $openingClosingBalance->open_balance}}</td>
                                        <td>{{ $openingClosingBalance->close_balance}}</td>
                                        <td>{{ $openingClosingBalance->total_balance}}</td>
                                        <td>{{ $openingClosingBalance->remarks}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addOwnerProfitModal" tabindex="-1" aria-labelledby="addOwnerProfitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="addOwnerProfitModalLabel" style="color:white">Add Owner Profit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-validation">
                    <form id="ownerProfitForm" method="post">
                        @csrf
                        <div class="col-md-12 mb-3">
                            <label for="cash_amount" class="form-label">Cash Amount<span class="text-danger">*</span></label>
                            <input type="text" class="form-control border" id="cash_amount" name="cash_amount" placeholder="Enter Cash Amount" value="{{ old('cash_amount') }}" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="remarks" class="form-label">Remarks<span class="text-danger">*</span></label>
                            <input type="text" class="form-control border" id="remarks" name="remarks" placeholder="Enter Remarks" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="submitOwnerProfit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
        const userTable = $('#openingClosingBalanceTable').DataTable({
            pagingType: "full_numbers",
            language: {
                paginate: {
                    first: '«',
                    last: '»',
                    next: '›',
                    previous: '‹'
                }
            },
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10
        });
});
$('#submitOwnerProfit').click(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Capture form values
        const cashAmount = $('#cash_amount').val();
        const remarks = $('#remarks').val();

        $.ajax({
            url: "{{ route('exchange.owner_profit.store') }}",
            method: "POST",
            data: {
                cash_amount: cashAmount,
                remarks: remarks,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.message) {
                    alert(response.message);
                    $('#addOwnerProfitModal').modal('hide');
                    $('#ownerProfitForm')[0].reset(); // Reset the form
                    userTable.ajax.reload(); // Reload the DataTable to reflect new data
                }
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON.message || 'An error occurred while adding the owner profit.'));
            }
        });
    });

</script>

@endsection
