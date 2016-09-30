# Micro servicio Usuarios, Permisos y Sesiones

#Fomato de entrega

GET /personas/

```json
{
    "total": 2,
    "per_page": 20,
    "current_page": 1,
    "last_page": 1,
    "next_page_url": null,
    "prev_page_url": null,
    "from": 1,
    "to": 2,
    "data": [
        {
            "_id": "57ee8e5158586b39dd0076f1",
            "nombre": "Admin",
            "usuario": "admin",
            "nivel": 100
        },
        {
            "_id": "57ee8e5158586b39dd0076f2",
            "nombre": "Usuario 1",
            "usuario": "user1",
            "nivel": 1
        }
    ]
}
```

# [Campos Base de Datos](db.md)

# Configuraciones MongoDB

Eliminar automaticamente las sesiones expiradas, modelo sesiones:
```
db.sesiones.createIndex( { "expira": 1 }, { expireAfterSeconds: 0 } )
```

Nuevo Index nombre de usuario unico
```cmd
db.usuarios.createIndex( { "usuario": 1 }, { unique: true } )
```