<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
        .button {
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }

        .button-add {background-color: #008CBA;}
    </style>
</head>
<body>

<h2>Contact List</h2>
<button class="button button-add">Add Contact</button>

<table>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Message</th>
        <th colspan="2">Action</th>
    </tr>
    <tr>
        <td>Test</td>
        <td>Test</td>
        <td>test@test.test</td>
        <td>Message</td>
        <td>Edit</td>
        <td>Delete</td>
    </tr>
</table>

</body>
</html>

