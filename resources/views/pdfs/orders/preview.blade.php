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
                    Pedido de Venta
                </th>
            </tr>
            <tr align="center">
                <th>
                    Fecha: <?php
                        if (isset($date)) {
                            $date_created = new DateTime( $date );

                            echo $date_created->format('d / m / Y');
                        }
                        else {
                            echo date('d / m / Y');
                        }
                    ?>
                </th>
            </tr>
        </table>
        <br>

        <table style="width: 100%">
            <tr>
                <td style="width: 70%; font-size: 23px">
                    {{ $customer->name }}
                </td>
                <td style="width: 30%">
                    <strong>Nit:</strong> {{ $customer->nit }}
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <strong>Dirección:</strong> {{ $customer->address }}
                </td>
                <td>
                    <strong>Teléfono: </strong> ({{ substr( $customer->phone_1 , -8 , -7) }}) {{ substr( $customer->phone_1 , -7 , -4) }}-{{ substr( $customer->phone_1 , -4) }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Correo electrónico:</strong> {{ $customer->email }}
                </td>
                <td>
                    <strong>Celular:</strong> ({{ substr( $customer->phone_2 , -10 , -7) }}) {{ substr( $customer->phone_2 , -7 , -4) }}-{{ substr( $customer->phone_2 , -4) }}
                </td>
            </tr>
        </table>

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
                    Cantidad
                </th>
                <th align="center" style="width: 20%">
                    Costo Unitario
                </th>
                <th align="center" style="width: 20%">
                    Costo Total
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
                        {{ $product['code'] }}
                    </td>
                    <td>
                        {{ $product['description'] }}
                    </td>
                    <td align="right">
                        {{ number_format( $product['quantity'] ) }}
                    </td>
                    <td align="right">
                        $ {{ number_format( $product['price'] ) }}
                    </td>
                    <td align="right">
                        $ {{ number_format( $product['price_total'] ) }}
                    </td>
                </tr>
            @endforeach

            <tr>
                <td colspan="5"><hr></td>
            </tr>
            <tr>
                <th>
                    Total
                </th>
                <th colspan="4" align="right">
                    $ {{ number_format( $total ) }}
                </th>
            </tr>

        </table>
    </body>
</html>