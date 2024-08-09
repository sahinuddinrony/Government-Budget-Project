<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    body {
        font-family: Arial, sans-serif;
    }

    .container {
        width: 80%;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-horizontal .form-group {
        margin-left: 0;
        margin-right: 0;
    }

    .form-horizontal .control-label {
        text-align: left;
    }

    .form-horizontal .form-control {
        width: 100%;
    }

    .form-horizontal .btn-submit {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .form-horizontal .btn-submit:hover {
        background-color: #0056b3;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border-color: #f5c6cb;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }

    .alert-danger li {
        list-style-type: none;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    table, th, td {
        border: 1px solid #ddd;
    }

    th, td {
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }

    .actions {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .actions form {
        display: inline;
    }

    .success-message {
        color: green;
        margin-bottom: 20px;
        text-align: center;
    }

    .error {
        color: red;
        font-size: 0.875em;
        text-align: left;
    }

    .text-right {
        text-align: right;
    }

    .remove-row {
        cursor: pointer;
        color: red;
    }

    .btn {
        display: inline-block;
        font-weight: 400;
        color: #212529;
        text-align: center;
        vertical-align: middle;
        user-select: none;
        background-color: transparent;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .btn-primary {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        color: #fff;
        background-color: #0056b3;
        border-color: #004085;
    }

    .btn-secondary {
        color: #fff;
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        color: #fff;
        background-color: #5a6268;
        border-color: #545b62;
    }

    .button-container {
        text-align: right;
        margin: 20px 0;
    }

    /* Print styles */
    @media print {
        .no-print {
            display: none;
        }
    }
</style>


