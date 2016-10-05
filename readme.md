# RENQO ACL SERVER
Renqo Acl Server, es una aplicación que sirve para poder hacer las
autenticaciones y las validaciones de permisos por medio HTTP, así
también como el LOGIN de usuarios y el registro de los mismos, algunas
de sus funciones son:
    
    - Gestion de usuarios CRUD
    - Autenticación de usuarios
    - Validación de Privilegios (Proximamente Roles) 
        - Funciona con el cliente adolfocuadros/renqo-client-acl
         
Básicamente el servidor se encarga de la autenticación y la validación
de permisos.

## Requerimientos

    - MongoDB
    - PHP 5.6/7.0

## ¿Como instalarlo?
Composer:
```cmd
composer create-project adolfocuadros/renqo-acl-server
```

#Información del API

### POST /login
Autenticación de un usuario por contraseña y password
```cmd
POST /login?usuario=[usuario]&pass=[password]
```

En caso de éxito devolverá un token de acceso temporal con código 201
Ejemplo de respuesta:
```json
POST /login?usuario=admin&pass=secreto

 -- response --
201 Created
Content-Type:  application/json

{
    "token": "57f4608aa232440718000230",
    "expira": {
        "date": "2016-10-05 05:08:10.000000",
        "timezone_type": 3,
        "timezone": "UTC"
    },
    "usuario": {
        "_id": "57f097cba232441bb4002961",
        "nombre": "Admin",
        "usuario": "admin",
        "nivel": 100
    }
}
```
En caso de error devolverá un una lista indicando los errores:
```json
POST /login?usuario=admin&pass=asd

 -- response --
422 Unprocessable Entity
Content-Type:  application/json

{
    "pass": [
        "La contraseña no es válida"
    ]
}
```
# [Arquitectura Base de Datos](doc/db.md)
Se podrá observar la organización de campos en la base de datos y algunas
recomendaciones e indices que se tienen que configurar.

# [Permisos del Sistema](doc/permisos.md)
Toda la lista de los permisos dentro del sistema