@extends("layout.main")
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 d-flex justify-content-between align-items-center px-3">
                        <p style="color: white;"><strong>Bank Balance Table</strong></p>
                    </div>
                </div>
                <div class="card-body px-0 pb-2 px-3">
                    <div class="table-responsive p-0">
                        <table id="bankBalanceTable" class="table align-items-center mb-0 table-striped table-hover px-2">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Exchange</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bank</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Account No.</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Remarks</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bankBalanceRecords as $bankBalance)
                                <tr>
                                    <td>{{ $bankBalance->user->name }}</td>
                                    <td>{{ $bankBalance->exchange->name }}</td>
                                    <td>{{ $bankBalance->name }}</td>
                                    <td>{{ $bankBalance->account_number }}</td>
                                    <td>{{ $bankBalance->cash_amount }}</td>
                                    <td>{{ $bankBalance->cash_type }}</td>
                                    <td>{{ $bankBalance->remarks }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-danger btn-sm" aria-label="Delete Bank Balance" onclick="deleteBankBalance(this, {{ $bankBalance->id }})">Delete</button>
                                    </td>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        const userTable = $('#bankBalanceTable').DataTable({
            pagingType: "full_numbers"
            , language: {
                paginate: {
                    first: '«'
                    , last: '»'
                    , next: '›'
                    , previous: '‹'
                }
            }
            , lengthMenu: [1, 10, 25, 50]
            , pageLength: 10
        });
    });

    function deleteBankBalance(button, id) {
        const row = $(button).closest('tr');
        const table = $('#bankBalanceTable').DataTable();

        if (!confirm('Are you sure you want to delete this bank balance?')) {
            return;
        }

        $.ajax({
            url: "{{ route('admin.bank_balance.destroy') }}"
            , method: "POST"
            , data: {
                id: id
                , _token: '{{ csrf_token() }}'
            }
            , success: function(response) {
                if (response.success) {
                    table.row(row).remove().draw();
                    alert(response.message); // Consider replacing this with a toast notification
                } else {
                    alert(response.message || 'Failed to delete the bank balance.');
                }
            }
            , error: function(xhr) {
                console.error(xhr.responseText);
                alert('Error: ' + xhr.status + ' - ' + xhr.statusText);
            }
        });
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
    .td-large {
    width: 45%;
}

.td-small {
    width: 10%;
    text-align: center;
}
    .table-striped tbody tr:nth-of-type(odd) { background-color: #f2f2f2; }
    .table-hover tbody tr:hover { background-color: #e0e0e0; }
    .modal-header { background-color: #343a40; color: white; }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 5px 10px; margin: 0 5px; font-size: 10px;
        color: white; background-color: #ffffff;
        border-radius: 50%; border: none;
        transition: background-color 0.3s ease;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #b3d8ff; color: white;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #343a40; color: white; font-weight: bold;
    }

</style>
@endsection
