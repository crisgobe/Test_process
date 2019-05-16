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
                    Listado de Pedidos
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
                    Número
                </th>
                <th align="center" style="width: 25%">
                    Cliente
                </th>
                <th align="center" style="width: 20%">
                    Fase
                </th>
                <th align="center" style="width: 15%">
                    Etapa
                </th>
                <th align="center" style="width: 10%">
                    Estado
                </th>
                <th align="center" style="width: 15%">
                    Creación
                </th>
                <th align="center" style="width: 5%">
                    Días
                </th>
            </tr>
            <tr>
                <th colspan="7">
                    <hr>
                </th>
            </tr>

            @foreach ($orders as $order)
                <?php
                    $date_created = new DateTime($order->created_at);
                    $date_updated = new DateTime($order->orderStep->created_at);

                    $Today  = date('m/j/Y' , strtotime( $order->orderStep->created_at ));
                    $Fin    = date('m/j/Y' , strtotime( $order->created_at ));
                    $Limit  = strtotime($Today) - strtotime($Fin);
                    $ResOne = ((($Limit / 60) / 60) / 24);
                ?>
                <tr style="font-size: 15px">
                    <td>
                        {{ $order->number }}
                    </td>
                    <td>
                        {{ $order->customer->name }}
                    </td>
                    <td align="center">
                        {{ $order->orderStep->step->step }}
                    </td>
                    <td align="center">
                        {{ $date_updated->format('d/m/Y') }}
                    </td>
                    <td align="center">
                        {{ $order->status->status }}
                    </td>
                    <td align="center">
                        {{ $date_created->format('d/m/Y') }}
                    </td>
                    <td align="center">
                        {{ $ResOne }}
                    </td>
                </tr>
            @endforeach

        </table>
    </body>
</html>