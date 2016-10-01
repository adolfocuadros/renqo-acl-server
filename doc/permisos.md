# Lista de todos los permisos.
Aquí encontrará toda la lista de permisos que se necesitan para cada recurso
del sistema.

|Método |Recurso    |Permiso        |Descripción|
|------ |-------    |-------        |-----------|
|GET    |usuarios/  | usuarios.index| Lista de Usuarios|
|POST   |usuarios/  | usuarios.store| Crea nuevo usuario|
|PATCH  |usuarios/{id}| usuarios.update| Modifica datos de usuario|
|GET    |usuarios/{id}| usuarios.show| Ve datos de un usuario (acceso general) |
|DELETE |usuarios/{id}| usuarios.delete| Elimina Usuario |
|GET    |usuarios/{id}| usuarios.own.show| Ve datos del propio usuario |
|PATCH  |usuarios/{id}| usuarios.own.update| Modifica datos del propio usuario|
