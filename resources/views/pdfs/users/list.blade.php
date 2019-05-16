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
                    Listado de Usuarios
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
                <th colspan="6">
                    <hr>
                </th>
            </tr>
            <tr>
                <th align="center" style="width: 20%">
                    Nombre
                </th>
                <th align="center" style="width: 20%">
                    Correo Electrónico
                </th>
                <th align="center" style="width: 10%">
                    Cargo
                </th>
                <th align="center" style="width: 20%">
                    Tipo de Usuario
                </th>
                <th align="center" style="width: 15%">
                    Estado
                </th>
                <th align="center" style="width: 15%">
                    Fecha
                </th>
            </tr>
            <tr>
                <th colspan="6">
                    <hr>
                </th>
            </tr>

            @foreach ($users as $user)
                <?php $date = new DateTime($user->created_at) ?>
                <tr style="font-size: 15px">
                    <td>
                        {{ $user->name }}
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td align="center">
                        {{ $user->position->description }}
                    </td>
                    <td align="center">
                        {{ $user->area->description }}
                    </td>
                    <td align="center">
                        {{ $user->status->status }}
                    </td>
                    <td align="center">
                        {{ $date->format('d / m / Y') }}
                    </td>
                </tr>
            @endforeach

        </table>
    </body>
</html>