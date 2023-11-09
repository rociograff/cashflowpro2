# CashFlowPro
Trabajo Práctico N° 2 

Materia: Framework e Interoperabilidad
Alumnas: Klimisch Marcia y Graff Rocío
Carrera: Tecnicatura Universitaria en Desarrollo Web
Año : 2023



Comandos:

1) crear base de datos con nombre          cashflowpro
2) al tener bajado el repo, entrar a Frontend con :         cd Frontend
3) ejecutar           npm install
4) luego hacer cd..  para subir una carpeta y luego poner     cd Back
5) ejecutar      composer update
6) en el archivo .env poner el nombre de la base de datos
7) para realizar migraciones usamos     php artisan migrate
8) para realizar las ejecuciones de los seeders       php artisan db:seed
9) para ejecutar el backend se usa        php artisan serve
10) para ejecutar el frontend se usa       npm run dev
11) para ejecutar el backend se usa (en una terminal diferente a la anterior)       php artisan serve

primera parte del archivo .env
APP_NAME=Cashflowpro
APP_ENV=local
APP_KEY=base64:TO4nNzLIrLE6On7F/3l4URK25J+e2S4FJ4EZDFFK0+0=
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_LOCALE=es
SESSION_DRIVER=cookie
