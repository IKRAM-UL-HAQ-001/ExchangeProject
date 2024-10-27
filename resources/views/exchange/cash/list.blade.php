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
                                @php
                                $balance = 0;
                            @endphp
                                @foreach($cashRecords as $cash)
                                    @php
                                        if ($cash->cash_type == 'deposit') {
                                            $balance += $cash->cash_amount;
                                        } elseif ($cash->cash_type == 'withdrawal') {
                                            $balance -= $cash->cash_amount;
                                        } elseif ($cash->cash_type == 'expense') {
                                            $balance -= $cash->cash_amount;
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ ucfirst($cash->cash_type) }}</td>
                                        <td>{{ number_format($cash->cash_amount, 2) }}</td>
                                        <td >{{$balance}}</td>
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
                    <h5 class="modal-title text-white" id="cashTransactionModalLabel">Cash Transaction Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeModalButton"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success text-white" id='success' style="display:none;">
                        {{ session('success') }}
                    </div>
                    <div class="alert alert-danger text-white" id='error' style="display:none;">
                        {{ session('error') }}
                    </div>
                    <form id="cashForm" action="{{ route('exchange.cash.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="cash_type">Cash Type<span class="text-danger">*</span></label>
                                    <select class="form-control border px-3" id="cash_type" name="cash_type" required>
                                        <option disabled selected>Choose Cash Type</option>
                                        <option value="deposit" {{ old('cash_type') == 'deposit' ? 'selected' : '' }}>Deposit</option>
                                        <option value="withdrawal" {{ old('cash_type') == 'withdrawal' ? 'selected' : '' }}>Withdrawal</option>
                                        <option value="expense" {{ old('cash_type') == 'expense' ? 'selected' : '' }}>Expense</option>
                                    </select>
                                    @error('cash_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group" id="reference_number" style="display: none;">
                                    <label for="reference_number">Reference Number<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control border" name="reference_number" placeholder="Enter Reference Number" >
                                    @error('reference_number')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group" id="cash_amount">
                                    <label for="cash_amount">Amount<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control border" name="cash_amount" placeholder="Enter Cash Amount" required>
                                    @error('cash_amount')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group" id="customer_name" style="display: none;">
                                    <label for="customer_name">Customer Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control border" name="customer_name" placeholder="Enter Customer Name">
                                    @error('customer_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group" id="bonus-amount-field" style="display: none;">
                                    <label for="bonus_amount">Bonus Amount <span class="text-pink">(optional)</span></label>
                                    <input type="text" class="form-control border" name="bonus_amount" placeholder="Enter Bonus Amount if any">
                                    @error('bonus_amount')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group" id="payment-type-field" style="display: none;">
                                    <label>Payment Type<span class="text-danger">*</span></label>
                                    @foreach(['google_pay', 'phone_pay', 'imps', 'neft', 'i20_pay'] as $payment)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="payment_type" required>
                                            <label class="form-check-label">{{ ucfirst(str_replace('_', ' ', $payment)) }}</label>
                                        </div>
                                    @endforeach
                                    @error('payment_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group" id="remarks">
                                    <label for="remarks">Remarks <span class="text-pink">(optional)</span></label>
                                    <input type="text" class="form-control border" name="remarks" placeholder="Enter Remarks if any">
                                    @error('remarks')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-8 ml-auto">
                                <button type="button" class="btn btn-secondary" id="closeModalButton">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#cashTable').DataTable({
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

        const cashTypeSelect = $('#cash_type');
        const cashForm = $('#cashForm');

        function toggleFields() {
            const cashType = cashTypeSelect.val();
            $('#reference_number').toggle(cashType === 'deposit');
            $('#customer_name').toggle(cashType === 'withdrawal' || cashType === 'deposit');
            $('#bonus-amount-field').toggle(cashType === 'deposit');
            $('#payment-type-field').toggle(cashType === 'deposit');
            $('#remarks').toggle(cashType !== '');
            $('#cash_amount').show();
        }

        toggleFields();

        cashTypeSelect.on('change', toggleFields);

        // Handle form submission
        cashForm.on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        $.ajax({
            url: cashForm.attr('action'),
            type: 'POST',
            data: cashForm.serialize(),
            success: function (response) {
                if (response.success) {
                    // Display success message
                    $('#success').text(response.message).show();
                    cashForm[0].reset();
                    $('#error').hide(); // Hide any error message

                    // Close modal and reset form
                    $('#cashTransactionModal').modal('hide');
                    cashForm[0].reset();
                    location.reload(); // Reload the page to update the table
                } else {
                    // Handle errors returned from server
                    $('#error').text(response.message).show();
                    $('#success').hide();
                }
            },
            error: function (xhr) {
                // Handle server errors
                const errorMessage = xhr.responseJSON?.message || 'An unexpected error occurred!';
                $('#error').text(errorMessage).show();
                $('#success').hide();
            }
        });
    });

        // Close modal and reset form
        $('#closeModalButton').on('click', function() {
            cashForm[0].reset();
        });
    });
</script>

@endsection
