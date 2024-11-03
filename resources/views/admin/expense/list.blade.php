@extends("layout.main")
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-warning shadow-primary border-radius-lg pt-4 d-flex justify-content-between align-items-center px-3">
                        <p style="color: black;"><strong>Expense Table (Weekly Bases)</strong></p>
                        <div>
                        <a href="{{ route('export.expense') }}" class="btn btn-dark">Expense Export</a>                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2 px-3">
                    <div class="table-responsive p-0">
                        <table id="expenseTable" class="table align-items-center mb-0 table-striped table-hover px-2">
                            <thead>
                                <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ">User </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ">Exchange </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ">Amount</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ">Type</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ">Remarks</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ">Balance</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ">Date and Time</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder  ">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $balance = 0;
                                @endphp

                                @foreach($expenseRecords as $expense)
                                    @php
                                        if ($expense->cash_type == 'deposit') {
                                            $balance += $expense->cash_amount;
                                        } elseif ($expense->cash_type == 'withdrawal') {
                                            $balance -= $expense->cash_amount;
                                        }elseif ($expense->cash_type == 'expense') {
                                            $balance -= $expense->cash_amount;
                                        }
                                    @endphp
                                @if($expense->cash_type == "expense")
                                    <tr>
                                        <td>{{ $expense->user->name }}</td>
                                        <td>{{ $expense->exchange->name }}</td>
                                        <td>{{ $expense->cash_amount }}</td>
                                        <td>{{ $expense->cash_type }}</td>
                                        <td>{{ $expense->remarks }}</td>
                                        <td>{{ $balance}}</td>
                                        <td>{{ $expense->created_at}}</td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm" onclick="deleteExpense(this, {{ $expense->id }})">Delete</button>
                                        </td>
                                    </tr>
                                @endif
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
        const userTable = $('#expenseTable').DataTable({
            pagingType: "full_numbers",
            language: {
                paginate: {
                    first: '«',
                    last: '»',
                    next: '›',
                    previous: '‹'
                }
            },
            lengthMenu: [1, 10, 25, 50],
            pageLength: 10,
            order: [[0, 'desc']] 
        });
});
function deleteExpense(button, id) {
    const row = $(button).parents('tr');
    const table = $('#expenseTable').DataTable();

    if (!confirm('Are you sure you want to delete this Expense?')) {
        return;
    }

    $.ajax({
        url: "{{ route('admin.expense.destroy') }}",
        method: "POST",
        data: {
            id: id,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                table.row(row).remove().draw();
                alert(response.message);
            } else {
                alert(response.message || 'Failed to delete the Expense.');
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert('Error: ' + xhr.status + ' - ' + xhr.statusText);
        }
    });
}
</script>

@endsection
