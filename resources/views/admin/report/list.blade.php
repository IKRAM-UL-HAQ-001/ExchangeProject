@extends("layout.main")
@section('content')
    <div class="container-fluid pb-5">
        <br>
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 mt-5">
            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 d-flex justify-content-between align-items-center px-3">
                <p style="color: white;"><strong>Reports</strong></p>
                <div>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#reportModal">Show Report</button>
                </div>
            </div>
        </div>
        
        <br>
        <div class="row">
            <div class="container">
                <div class="row">
                    <!-- Withdrawals and Deposits Chart -->
                    <div class="col-lg-4 col-sm-12">
                        <div class="card equal-height">
                            <div class="card-header">
                                <h4 class="card-title">Withdrawals and Deposits</h4>
                                <span id="withdrawalsDepositsLabel" style="color:black">No Data Available</span>
                            </div>
                            <div class="card-body">
                                <canvas id="withdrawalsChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- Expense and Bonus Chart -->
                    <div class="col-lg-4 col-sm-12">
                        <div class="card equal-height">
                            <div class="card-header">
                                <h4 class="card-title">Expense and Bonus</h4>
                                <span id="expenseBonusLabel" style="color:black">No Data Available</span>
                            </div>
                            <div class="card-body">
                                <canvas id="profitsChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- Total Exchange Profit Chart -->
                    <div class="col-lg-4 col-sm-12">
                        <div class="card equal-height">
                            <div class="card-header">
                                <h4 class="card-title">Total Exchange Profit</h4>
                                <span id="exchangeProfitLabel" style="color:black">No Data Available</span>
                            </div>
                            <div class="card-body">
                                <canvas id="bonusChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Modal -->
        <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center bg-primary">
                        <h5 class="modal-title" id="reportModalLabel" style="color:white">Generate Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Success and Error Messages -->
                        <div class="alert alert-success text-white d-none" id='success'>
                            Report generated successfully.
                        </div>
                        <div class="alert alert-danger text-white d-none" id='error'>
                            Failed to generate report. Please try again.
                        </div>
                        <!-- Report Form -->
                        <form id="reportForm">
                            @csrf
                            <div class="mb-3">
                                <label for="exchange" class="form-label">Exchange</label>
                                <select class="form-select px-3" id="exchange" name="exchange_id" required>
                                    <option value="" disabled selected>Select an exchange</option>
                                    @foreach($exchangeRecords as $exchange)
                                        <option value="{{ $exchange->id }}">{{ $exchange->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="sdate" class="form-label">Start Date:</label>
                                <input type="date" class="form-control border px-3" id="sdate" name="start_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="edate" class="form-label">End Date:</label>
                                <input type="date" class="form-control border px-3" id="edate" name="end_date" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="generateReportBtn">Generate Report</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery and Chart.js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Chart Initialization Script -->
    <script>
        $(document).ready(function() {
            "use strict";

            // Initialize Charts with No Data
            let withdrawalsChart = new Chart(document.getElementById('withdrawalsChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: ['Withdrawals', 'Deposits'],
                    datasets: [{
                        data: [0, 0],
                        backgroundColor: ['rgb(192, 10, 39)', '#75B432'],
                    }]
                },
                options: {
                    responsive: true,
                }
            });

            let profitsChart = new Chart(document.getElementById('profitsChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: ['Expenses', 'Bonuses'],
                    datasets: [{
                        data: [0, 0],
                        backgroundColor: ['#75B432', '#E0E0E0'],
                    }]
                },
                options: {
                    responsive: true,
                }
            });

            let bonusChart = new Chart(document.getElementById('bonusChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: ['Total Exchange Profit', 'Remaining'],
                    datasets: [{
                        data: [0, 0],
                        backgroundColor: ['#FFCE56', '#36A2EB'],
                    }]
                },
                options: {
                    responsive: true,
                }
            });

            // Handle Report Generation
            $('#generateReportBtn').click(function() {
                // Clear previous messages
                $('#success').addClass('d-none').text('');
                $('#error').addClass('d-none').text('');

                // Get form data
                let formData = {
                    exchange_id: $('#exchange').val(),
                    start_date: $('#sdate').val(),
                    end_date: $('#edate').val(),
                    _token: '{{ csrf_token() }}'
                };

                // Validate form inputs
                if (!formData.exchange_id || !formData.start_date || !formData.end_date) {
                    $('#error').removeClass('d-none').text('All fields are required.');
                    return;
                }

                // Send AJAX request
                $.ajax({
                    url: '{{ route("admin.report.generate") }}',
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        // Optionally, you can show a loader here
                        $('#generateReportBtn').prop('disabled', true).text('Generating...');
                    },
                    success: function(response) {
                        // Update Charts with received data
                        withdrawalsChart.data.datasets[0].data = [response.withdrawal, response.deposit];
                        withdrawalsChart.update();

                        profitsChart.data.datasets[0].data = [response.expense, response.bonus];
                        profitsChart.update();

                        // Ensure at least two data points for the pie chart
                        bonusChart.data.datasets[0].data = [response.latestBalance, 0];
                        bonusChart.update();

                        // Update labels
                        $('#withdrawalsDepositsLabel').text(`Date Range: {{ isset($date) ? $date : 'N/A' }}`);
                        $('#expenseBonusLabel').text(`Date Range: {{ isset($date) ? $date : 'N/A' }}`);
                        $('#exchangeProfitLabel').text(`Date Range: {{ isset($date) ? $date : 'N/A' }}`);

                        // Show success message
                        $('#success').removeClass('d-none').text('Report generated successfully.');

                        // Close the modal after a short delay
                        setTimeout(function() {
                            $('#reportModal').modal('hide');
                        }, 1500);
                    },
                    error: function(xhr) {
                        // Handle errors
                        let errorMsg = 'An error occurred. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMsg = xhr.responseJSON.error;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMsg = Object.values(xhr.responseJSON.errors).join(' ');
                        }
                        $('#error').removeClass('d-none').text(errorMsg);
                    },
                    complete: function() {
                        // Re-enable the button
                        $('#generateReportBtn').prop('disabled', false).text('Generate Report');
                    }
                });
            });
        });
    </script>

    <!-- Styles -->
    <style>
        .equal-height {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .card-body {
            flex: 1 1 auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        canvas {
            max-width: 100%;
            max-height: 300px; /* Increased height for better visibility */
        }

        /* Optional: Style the modal header for better visibility */
        .modal-header {
            background-color: #0d6efd;
            color: white;
        }
    </style>
@endsection
