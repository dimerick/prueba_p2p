
# Prueba PlacetoPay (Redirección-Pago básico).

Aplicación desarrollada en el framework Laravel que permite integrarse con la plataforma Placetopay para realizar un pago básico desde internet.

## Características
- Sistema de Autenticación
- Permite al usuario consultar las ultimas cinco transacciones realizadas
- Permite al usuario reintentar el proceso de pago en caso de que este falle
- No permite que el usuario realice nuevas transacciones si aun tiene un proceso de pago pendiente

## Instalación

- Clonar el repositorio o descargar
- Actualizar dependencias con el comando "composer update"
- Configurar el archivo .env con las credenciales de la base de datos, y los datos proporcionados por Placetopay (login, secretKey)
- Ejecutar las migraciones y los seeders con el comando "php artisan migrate:refresh --seed"
- Ejecutar el comando "php artisan serve", por defecto nuestra aplicacion se ejecutara en [http://localhost:8000]

#### Usuario por defecto: 
user: admin@tienda.com <br>
password: secret

