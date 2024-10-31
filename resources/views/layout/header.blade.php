<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/logo.png">
    
    <link rel="icon" type="image/png" href="./assets/img/logo.png">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style> 
    
    .bg-gradient-to-white {
        background: linear-gradient(to bottom, #f0f0f0, white);
    }
    .test1 {
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.9)); /* Replace with your desired gradient */
        color: white;
        opacity: 1;
    }

    .form-control{
        color:black;
        border: 1px solid #ced4da; /* Default Bootstrap border color */
        border-radius: 0.25rem; /* Bootstrap border radius */
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .d-sm-inline, .breadcrumb-item{
        font-weight:bold;
        color:black;
    }

    .form-label{
        color:black;
    }
    
    .text-capitalize{
        font-weight:bold;
        color:white;
    }

    .nav-link-text {
        font-weight: bold;
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
    
    .modal-header { background-color: #343a40; color: white; }
    .table thead tr th {
        color: black !important;          
        font-size: 14px !important;        
        font-weight: bold !important;       
        text-transform: uppercase !important; 
    }
    /* DataTable Custom Styling */
    .table tbody tr:nth-child(odd) {
        background-color: black;
        color: white;
    }

    .table tbody tr:nth-child(odd) td {
        color: white;
    }
    .table tbody tr:nth-child(even) {
        background-color: white !important; /* Use !important if needed */
        color: black !important;
         /* Use !important if needed */
    }
    .table tbody tr:nth-child(even) td {
        background-color: white !important; /* Use !important if needed */
        color: black !important;
         /* Use !important if needed */
    }

    /* Optional: Adjust hover effect to keep text visible */
   
    .table tbody tr:nth-child(odd):hover {
        background-color: black !important; /* Optional: Change background on hover */
        color: white !important;            /* Change text to black */
    }
    .table tbody tr:nth-child(even):hover {
        background-color: white !important; /* Use !important if needed */
        color: black !important;
         /* Use !important if needed */
    }
</style>
<!-- <script>
    document.addEventListener('contextmenu', event => event.preventDefault());
    document.addEventListener('keydown', function(event) {
        if (event.key === 'F12' || (event.ctrlKey && event.shiftKey && event.key === 'I')) {
            event.preventDefault();
        }
    });
</script> -->
</head>