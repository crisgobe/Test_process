<!DOCTYPE html>

<html>
    <head></head>
    <body>
        <table style="width: 100%">
            <tr>
                <th align="center" style="font-size: 30px">
                    TRACKING SYSTEM
                </th>
            </tr>
            <tr align="center" style="font-size: 25px">
                <th>
                    Listado de Productos
                </th>
            </tr>
            <tr align="center">
                <th>
                    Fecha: <?php echo date('d / m / Y') ?>
                </th>
            </tr>
        </table>
        <br>

        <table style="width: 100%">
            <tr>
                <th colspan="7">
                    <hr>
                </th>
            </tr>
            <tr>
                <th align="center" style="width: 15%">
                    Código
                </th>
                <th align="center" style="width: 35%">
                    Descripción
                </th>
                <th align="center" style="width: 10%">
                    Precio
                </th>
                <th align="center" style="width: 10%">
                    Cantidad
                </th>
                <th align="center" style="width: 20%">
                    Categoría
                </th>
                <th align="center" style="width: 10%">
                    Estado
                </th>
            </tr>
            <tr>
                <th colspan="7">
                    <hr>
                </th>
            </tr>

            @foreach ($products as $product)
                <tr style="font-size: 15px">
                    <td>
                        {{ $product->code }}
                    </td>
                    <td>
                        {{ $product->description }}
                    </td>
                    <td align="right">
                        $ {{ number_format( $product->price ) }}
                    </td>
                    <td align="right">
                        {{ number_format( $product->quantity ) }}
                    </td>
                    <td align="center">
                        {{ $product->category }}
                    </td>
                    <td align="center">
                        {{ $product->status }}
                    </td>
                </tr>
            @endforeach

        </table>
    </body>
</html>