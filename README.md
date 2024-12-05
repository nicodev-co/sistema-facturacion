# Sistema de Facturación - Laravel 11

## Requisitos de Instalación

1. **Servidor Web**: Apache/Nginx
2. **PHP**: Versión 8.2 o superior
3. **Composer**: Versión 2.0 o superior
4. **Base de Datos**: MySQL/MariaDB
5. **Node.js**: Versión 18.x
6. **npm**: Versión 9.x

## Instalación

1. **Clonar el repositorio**:

    ```bash
    git clone https://github.com/nicodev-co/sistema-facturacion.git
    cd sistema-facturacion
    ```

2. **Instalar dependencias de PHP**:

    ```bash
    composer install
    ```

3. **Instalar dependencias de Node.js**:

    ```bash
    npm install
    ```

4. **Copiar el archivo de entorno**:

    ```bash
    cp .env.example .env
    ```

5. **Generar la clave de la aplicación**:

    ```bash
    php artisan key:generate
    ```

6. **Configurar la base de datos**:

    - Editar el archivo `.env` y configurar los parámetros de conexión a la base de datos:
        ```
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=nombre_base_datos
        DB_USERNAME=usuario
        DB_PASSWORD=contraseña
        ```

7. **Migrar la base de datos**:

    ```bash
    php artisan migrate
    ```

8. **Ejecutar los seeders para poblar la base de datos**:

    ```bash
    php artisan db:seed
    ```

9. **Iniciar el servidor de desarrollo**:
    ```bash
    php artisan serve
    ```

10. **Acceder a la aplicación**:

    Abre tu navegador y visita la siguiente URL para acceder a la aplicación:

    ```
    http://127.0.0.1:8000
    ```

## Configuración Adicional

-   **Permisos de Carpeta**: Asegúrate de que el servidor web tenga permisos de escritura en las carpetas `storage` y `bootstrap/cache`.

    ```bash
    chmod -R 775 storage
    chmod -R 775 bootstrap/cache
    ```

## Capturas de Pantalla

A continuación, se presentan algunas capturas de pantalla de la aplicación:

### Página de Inicio

![Página de Inicio](/images/screen1.png)

### Página de Factura

![Registro de Facturas](/images/screen2.png)
![Registro de Facturas](/images/screen3.png)
![Vista de Facturas](/images/screen4.png)

## Licencia

Este proyecto está licenciado bajo la [MIT License](LICENSE).
