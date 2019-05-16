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
                    Listado de Bodegas
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
                <th align="center" style="width: 20%">
                    Código
                </th>
                <th align="center" style="width: 60%">
                    Descripción
                </th>
                <th align="center" style="width: 20%">
                    Estado
                </th>
            </tr>
            <tr>
                <th colspan="7">
                    <hr>
                </th>
            </tr>

            @foreach ($warehouses as $warehouse)
                <tr style="font-size: 15px">
                    <td>
                        {{ $warehouse->code }}
                    </td>
                    <td>
                        {{ $warehouse->description }}
                    </td>
                    <td align="center">
                        {{ $warehouse->status->status }}
                    </td>
                </tr>
            @endforeach

        </table>
    </body>
</html>