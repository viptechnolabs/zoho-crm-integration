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
<a href="{{ route('add') }}" class="button button-add">Add Contact</a>

<table>
    <tr>
        <th>#</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Message</th>
        <th colspan="2">Action</th>
    </tr>
    @forelse($data as $key => $d)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $d['First_Name'] }}</td>
            <td>{{ $d['Last_Name'] }}</td>
            <td>{{ $d['Email'] }}</td>
            <td>{{ $d['Description'] }}</td>
            <td><a href="{{ route('edit', $d['id']) }}">Edit</a></td>
            <td><a href="{{ route('delete', $d['id']) }}">Delete</a></td>
        </tr>
    @empty
        <tr>
            <td>Not Data Found</td>
        </tr>
    @endforelse
</table>

</body>
</html>

