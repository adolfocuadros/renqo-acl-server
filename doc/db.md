# Estructura de Base de Datos

## usuarios
Colección donde se almacenarán todos los usuarios del sistema

|Tipo       |Nombre |Descripción|
|--------|----------|-----------------------|
|ObjectId   | _id   |Generador por MongoDB|
|string     |nombre |Nombre del usuario del sistema|
|string     |usuario|Nick, documento o cualquier identificador de usuario único|
|string     | pass  |contraseña cifrada|
|int        | nivel |Numero que identifica al nivel|
|email      | email |Correo electrónico|
|array      | permisos|Lista de los permisos de este usuario|

Se recomienda añadir un índice único para el campo usuario de la siguiente
manera.

Nuevo Index nombre de usuario único
```cmd
db.usuarios.createIndex( { "usuario": 1 }, { unique: true } )
```

## sesiones
Colección donde se almacenarán las sesiones y estas a su vez expirarán,
se eliminarán automáticamente.

|Tipo       |Nombre |Descripción|
|--------   |----------|-----------------------|
|ObjectId   | _id   |Generador por MongoDB id TOKEN|
|string     | ip    |Dirección Ip desde la ultima conexión en esta sesión|
|string     | usuario_id|Relación con la colección "usuarios"|
|Date       | expira|Fecha que expirará la session|

Eliminar automáticamente las sesiones expiradas, modelo sesiones:
```cmd
db.sesiones.createIndex( { "expira": 1 }, { expireAfterSeconds: 0 } )
```