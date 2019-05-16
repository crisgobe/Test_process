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
                    Listado de Clientes
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
                <th colspan="6"><hr></th>
            </tr>
            <tr>
                <th align="center" style="width: 30%">
                    Nombre
                </th>
                <th align="center" style="width: 13%">
                    Identificación
                </th>
                <th align="center" style="width: 30%">
                    Correo Electrónico
                </th>
                <!-- <th align="center" style="width: 20%">
                    Dirección
                </th> -->
                <th align="center" style="width: 17%">
                    Teléfonos
                </th>
                <th align="center" style="width: 10%">
                    Estado
                </th>
                <!-- <th align="center" style="width: 5%">
                    Fecha
                </th> -->
            </tr>
            <tr>
                <th colspan="6">
                    <hr>
                </th>
            </tr>

            @foreach ($customers as $customer)
                <?php $date = new DateTime($customer->created_at) ?>
                <tr style="font-size: 15px">
                    <td>
                        {{ $customer->name }}
                    </td>
                    <td>
                        {{ $customer->nit }}
                    </td>
                    <td align="center">
                        {{ $customer->email }}
                    </td>
                    <!-- <td align="center">
                        {{ $customer->address }}
                    </td> -->
                    <td align="center">
                        ({{ substr( $customer->phone_1 , -8 , -7) }}) {{ substr( $customer->phone_1 , -7 , -4) }}-{{ substr( $customer->phone_1 , -4) }}
                        <br>
                        ({{ substr( $customer->phone_2 , -10 , -7) }}) {{ substr( $customer->phone_2 , -7 , -4) }}-{{ substr( $customer->phone_2 , -4) }}
                    </td>
                    <td align="center">
                        {{ $customer->status->status }}
                    </td>
                    <!-- <td align="center">
                        {{ $date->format('d / m / Y') }}
                    </td> -->
                </tr>
            @endforeach

        </table>
    </body>
</html>