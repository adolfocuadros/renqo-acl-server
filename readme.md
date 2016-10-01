# Micro servicio Usuarios, Permisos y Sesiones

#Formatos de entrega

### GET /personas/
Entrega la lista de los usuarios del sistema siempre y cuando este tenga
los todos los permisos 

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

# [Arquitectura Base de Datos](doc/db.md)
Se podrá observar la organización de campos en la base de datos y algunas
recomendaciones e indices que se tienen que configurar.

# [Permisos del Sistema](doc/permisos.md)
Toda la lista de los permisos dentro del sistema