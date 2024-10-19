@extends("layout.main")
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 d-flex justify-content-between align-items-center px-3">
                        <p style="color: white;"><strong>Cash Transactions</strong></p>
                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#cashTransactionModal">Add New Transaction</button>
                    </div>
                </div>
                <div class="card-body px-0 pb-2 px-3">
                    <div class="table-responsive p-0">
                        <table id="cashTable" class="table align-items-center mb-0 table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cash Type</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Balance</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date and Time</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cashRecords as $cash)
                                    <tr>
                                        <td>{{ ucfirst($cash->cash_type) }}</td>
                                        <td>{{ number_format($cash->cash_amount, 2) }}</td>
                                        <td>{{ $cash->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cash Transaction Modal -->
    <div class="modal fade" id="cashTransactionModal" tabindex="-1" aria-labelledby="cashTransactionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cashTransactionModalLabel">Cash Transaction Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="cashForm">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="cash_type">Cash Type<span class="text-danger">*</span></label>
                                    <select class="form-control border px-3" id="cash_type" name="cash_type" required>
                                        <option disabled selected>Choose Cash Type</option>
                                        <option value="deposit">Deposit</option>
                                        <option value="withdrawal">Withdrawal</option>
                                        <option value="expense">Expense</option>
                                    </select>
                                </div>

                                <div class="form-group" id="reference_number" style="display: none;">
                                    <label for="reference_number">Reference Number<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control border" name="reference_number" placeholder="Enter Reference Number" value="{{ old('reference_number') }}">
                                </div>

                                <div class="form-group" id="phone_number" style="display: none;">
                                    <label for="phone_number">Phone Number<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control border" name="phone_number" placeholder="Enter Phone Number" value="{{ old('phone_number') }}">
                                </div>

                                <div class="form-group" id="cash_amount">
                                    <label for="cash_amount">Amount<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control border" name="cash_amount" placeholder="Enter Cash Amount" value="{{ old('cash_amount') }}" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group" id="customer_name" style="display: none;">
                                    <label for="customer_name">Customer Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control border" name="customer_name" placeholder="Enter Customer Name" value="{{ old('customer_name') }}">
                                </div>

                                <div class="form-group" id="bonus-amount-field" style="display: none;">
                                    <label for="bonus_amount">Bonus Amount <span class="text-pink">(optional)</span></label>
                                    <input type="text" class="form-control border" name="bonus_amount" placeholder="Enter Bonus Amount if any">
                                </div>

                                <div class="form-group" id="payment-type-field" style="display: none;">
                                    <label>Payment Type<span class="text-danger">*</span></label>
                                    @foreach(['google_pay', 'phone_pay', 'imps', 'neft', 'i20_pay'] as $payment)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="payment_type" value="{{ $payment }}" required>
                                            <label class="form-check-label">{{ ucfirst(str_replace('_', ' ', $payment)) }}</label>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="form-group" id="remarks">
                                    <label for="remarks">Remarks <span class="text-pink">(optional)</span></label>
                                    <input type="text" class="form-control border" name="remarks" placeholder="Enter Remarks if any" value="{{ old('remarks') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-8 ml-auto">
                                <button type="button" class="btn btn-primary" onclick="submitCashForm()">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$(document).ready(function() {
    const cashTypeSelect = $('#cash_type');

    function toggleFields() {
        const cashType = cashTypeSelect.val();
        $('#reference_number').toggle(cashType === 'deposit');
        $('#phone_number').toggle(cashType === 'deposit');
        $('#customer_name').toggle(cashType === 'withdrawal' || cashType === 'deposit');
        $('#bonus-amount-field').toggle(cashType === 'deposit');
        $('#payment-type-field').toggle(cashType === 'deposit');
        $('#remarks').toggle(cashType !== '');
        $('#cash_amount').show();
    }

    // Initial check
    toggleFields();

    // Event listener
    cashTypeSelect.on('change', toggleFields);
});

function submitCashForm() {
    $.ajax({
        url: "{{ route('exchange.cash.store') }}",
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data: {
            cash_type: $('#cash_type').val(),
            cash_amount: $('[name="cash_amount"]').val(),
            reference_number: $('[name="reference_number"]').val(),
            phone_number: $('[name="phone_number"]').val(),
            customer_name: $('[name="customer_name"]').val(),
            bonus_amount: $('[name="bonus_amount"]').val(),
            payment_type: $('[name="payment_type"]:checked').val(),
            remarks: $('[name="remarks"]').val()
        },
        success: function(response) {
            if (response.success) {
                alert(response.message);
                $('#cashTransactionModal').modal('hide');
                $('#cashForm')[0].reset();
                location.reload();
            } else {
                alert(response.message || 'Failed to submit the form.');
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
