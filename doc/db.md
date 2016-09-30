# Estructura de Base de Datos

## usuarios

    - (ObjectId) _id: Generador por MongoDB
    - (string) nombre: Nombre del usuario del sistema
    - (string) usuario: Nick, documento o cualquier identificador de usuario unico
    - (string) pass: contraseña cifrada
    - (int) nivel: Numero que identifica al nivel
    - (array) permisos: Lista de los permisos de este usuario

## sesiones
    - (ObjectId) _id: Generador por MongoDB
    - (string) ip: Direccion Ip desde la ultima conexion en esta sesión
    - (string) token: Token de acceso al sistema
    - (string) usuario_id: Relación con la colección "usuarios"
    - (Date) expira: Fecha que expirará la session