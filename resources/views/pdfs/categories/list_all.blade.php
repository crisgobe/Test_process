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
                    Listado de Categorías
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
                <th align="center" style="width: 30%">
                    Código
                </th>
                <th align="center" style="width: 70%">
                    Descripción
                </th>
            </tr>
            <tr>
                <th colspan="7">
                    <hr>
                </th>
            </tr>

            @foreach ($categories as $category)
                <tr style="font-size: 15px">
                    <td>
                        {{ $category->code }}
                    </td>
                    <td>
                        {{ $category->description }}
                    </td>
                </tr>
            @endforeach

        </table>
    </body>
</html>