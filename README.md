# test

## Project setup
```
npm install
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Lints and fixes files
```
npm run lint
```

### Configuración de la API
- El directorio api corresponde a los endpoints del backend del sistema. En api/applications/config/config.php se debe configurar el parámetro base_url con la URL donde estará instalada la API.
- En api/applications/config/database.php se deben establecer los datos de conexión a la base de datos tales como el username (nombre del usuario con permisos a la base de datos), password (contraseña del usuario) y database (nombre de la base de datos).
- En src/main.js configure el parámetro Vue.prototype.$base_url con la URL correspondiente a la API.


