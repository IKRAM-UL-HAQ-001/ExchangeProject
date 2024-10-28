<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">
    <title>
        Exchange Management System   
    </title>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <style>
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f2f2f2;
    }

    .table-hover tbody tr:hover {
        background-color: #e0e0e0;
    }
    .form-control{
        border: 1px solid #ced4da; /* Default Bootstrap border color */
        border-radius: 0.25rem; /* Bootstrap border radius */
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .table{
        color:black;
    }
    .tbody{
        color:black
    }
    .form-control:focus {
        border-color: #80bdff; /* Border color on focus */
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Shadow on focus */
    }

    input::placeholder {
        padding-left: 10px;
        color: #aaa; 
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
</head>