<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>

<h2>products table and their related catalogs</h2>

<table>
    <tr>
        <th>Products</th>
        <th>Catalogs</th>
    </tr>
    @foreach($products as $product)
    <tr>
        <td>{{ $product->title }}</td>
        <td><a href="{{ url('/images/'.$product->catalog->pic_address) }}")}}>نمایش کاتالوگ</a></td>
    </tr>
    @endforeach
</table>

</body>
</html>
