# Microservicio: Miramar-Productos 📦

Microservicio encargado de la gestión de productos turísticos (servicios y paquetes) para el sistema de la agencia de viajes **MiraMar**.

## Descripción del Servicio

Este componente forma parte de una arquitectura de microservicios y su responsabilidad exclusiva es gestionar la lógica de negocio y la persistencia de datos relacionada con los productos. Esto incluye:

* **Servicios Individuales**: Administración (CRUD) de productos como vuelos, hospedajes, alquiler de autos, etc..
* **Paquetes Turísticos**: Creación y gestión de paquetes que agrupan dos o más servicios.
* **Cálculo de Costos**: Este servicio es el único que conoce la estructura interna de los productos y cómo se calculan sus costos, incluyendo la aplicación de un **descuento del 10%** al costo final de los paquetes turísticos.

---

## Tecnologías Utilizadas ⚙️

* **Framework**: Lumen (PHP)
* **Base de Datos**: Configurado para MySQL/PostgreSQL (configurable en `.env`)
* **Gestor de Dependencias**: Composer

---

## Instalación y Configuración Local

Sigue estos pasos para levantar el proyecto en un entorno local.

1.  **Clonar el repositorio**
    ```bash
    git clone https://github.com/Tate-147/miramar-productos.git
    cd miramar-productos
    ```

2.  **Instalar dependencias de PHP**
    ```bash
    composer install
    ```

3.  **Crear el archivo de entorno**
    Copia el archivo de ejemplo para crear tu configuración local.
    ```bash
    cp .env.example .env
    ```

4.  **Configurar la base de datos**
    Abre el archivo `.env` y configura las variables de conexión a tu base de datos:
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=miramar_productos
    DB_USERNAME=root
    DB_PASSWORD=tu_contraseña
    ```

5.  **Ejecutar las migraciones**
    Este comando creará la estructura de tablas en tu base de datos.
    ```bash
    php artisan migrate
    ```

6.  **(Opcional) Poblar la base de datos**
    Para cargar datos de prueba (servicios y paquetes de ejemplo) ejecuta:
    ```bash
    php artisan db:seed
    ```

---

## Ejecución 🚀

Para iniciar el servidor de desarrollo de Lumen, ejecuta el siguiente comando desde la raíz del proyecto:

```bash
php -S localhost:8001 -t public