# CashFlowPro - Trabajo Práctico N°2

Este repositorio corresponde al Trabajo Práctico N°2 de la materia "Framework e Interoperabilidad" de la Tecnicatura Universitaria en Desarrollo Web. Fue desarrollado por las alumnas Marcia Klimisch y Rocío Graff durante el año 2023.

## Instrucciones de Uso:

### 1. Crear Base de Datos:

Ejecutar el siguiente comando para crear una base de datos con el nombre `cashflowpro`.

```sql
CREATE DATABASE cashflowpro;
```

### 2. Instalación de Dependencias:

1. Navegar a la carpeta `Frontend`:

```bash
cd Frontend
```

2. Ejecutar el siguiente comando para instalar las dependencias necesarias:

```bash
npm install
```

### 3. Configuración del Backend:

1. Regresar a la carpeta principal:

```bash
cd ..
```

2. Ingresar a la carpeta `Back`:

```bash
cd Back
```

3. Actualizar las dependencias mediante Composer:

```bash
composer update
```

4. En el archivo `.env`, asegurarse de configurar el nombre de la base de datos correctamente.

### 4. Migraciones y Seeders:

1. Para realizar las migraciones, ejecutar el siguiente comando:

```bash
php artisan migrate
```

2. Para ejecutar los seeders y poblar la base de datos:

```bash
php artisan db:seed
```

### 5. Ejecución de Backend y Frontend:

1. Para ejecutar el backend, utilizar el siguiente comando:

```bash
php artisan serve
```

2. Para ejecutar el frontend, utilizar el siguiente comando (en una terminal diferente a la del backend):

```bash
npm run dev
```

---

### Primera parte del archivo .env
```bash
APP_NAME=Cashflowpro
APP_ENV=local
APP_KEY=base64:TO4nNzLIrLE6On7F/3l4URK25J+e2S4FJ4EZDFFK0+0=
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_LOCALE=es
SESSION_DRIVER=cookie
```
