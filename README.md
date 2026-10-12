# Desarrollo Front-end - Alejandro Cifuentes Osorio

Modulo: Desarrollo de Front-end
Institucion: Politecnico Grancolombiano
Ano: 2026

---

## Estructura del proyecto

```
frontend/
|
|-- entrega_1_Alejandro_Cifuentes.html
|-- entrega_2_Alejandro_Cifuentes.html
|-- styles.css
|-- script.js
|-- alejandro_cifuentes.jpeg
|-- disempack.jpeg
|-- asosuperfruver.jpeg
|-- telemed.jpeg
|
|-- boca-mejoras/
|   |-- index.html
|   |-- css/
|   |   `-- boca-theme.css
|   |-- js/
|   |   `-- boca-theme.js
|   `-- admin/
|       |-- dashboard.html
|       |-- usuarios.html
|       |-- competencias.html
|       `-- problemas.html
|
`-- boca-integracion/
    `-- src/
        |-- index.php
        |-- boca-theme.css
        |-- boca-theme.js
        `-- admin/
            `-- header.php
```

---

## Entrega previa 1 - Semana 3

Portafolio personal en un solo archivo HTML con CSS escrito dentro del mismo archivo.

Secciones incluidas:
- Barra de navegacion con anclas a cada seccion
- Presentacion con foto de perfil
- Sobre mi
- Habilidades con etiquetas visuales
- Proyectos con imagen, descripcion y enlace
- Contacto con correo y telefono
- Footer

Tecnologias: HTML5, CSS3 interno.

Para visualizar: abrir `entrega_1_Alejandro_Cifuentes.html` en el navegador.

---

## Entrega previa 2 - Semana 5

Version mejorada del portafolio separando el CSS y el JavaScript en archivos externos e integrando Bootstrap 5.

Archivos: `entrega_2_Alejandro_Cifuentes.html`, `styles.css`, `script.js`.

Cambios respecto a la entrega 1:

- CSS separado en archivo externo `styles.css`
- JavaScript separado en archivo externo `script.js`
- Bootstrap 5.3.2 para grilla responsiva y componentes
- Bootstrap Icons para iconos en toda la pagina
- Navbar fija con menu hamburguesa para pantallas pequenas
- Seccion hero con gradiente y animaciones de entrada
- Datos personales organizados en tarjetas con icono
- Barras de progreso de habilidades que se animan al hacer scroll
- Contadores numericos animados (anos de experiencia, proyectos, tecnologias)
- Grilla de 3 columnas para proyectos con efecto hover
- Formulario de contacto con validacion JavaScript por campo
- Animaciones fade-in usando IntersectionObserver
- Boton de volver arriba que aparece al bajar en la pagina

Para visualizar: abrir `entrega_2_Alejandro_Cifuentes.html` en el navegador. No requiere servidor.

Tecnologias usadas:
- HTML5
- CSS3 (archivo externo)
- JavaScript ES6 (archivo externo)
- Bootstrap 5.3.2 via CDN
- Bootstrap Icons 1.11.3 via CDN

---

## Entrega final - Semana 7

Mejora de la interfaz del software BOCA (Online Contest Administrator), implementada en dos partes: paginas standalone para visualizacion sin servidor, y la integracion real dentro del codigo fuente de Boca corriendo en Ubuntu 25.10 sobre VirtualBox.

### Parte 1 - Paginas standalone (carpeta boca-mejoras/)

Paginas HTML/CSS/JS que muestran el rediseno de la interfaz de Boca sin necesidad de tener el software instalado.

Paginas creadas:

**index.html - Login**
- Tarjeta de login centrada sobre fondo degradado
- Campos de usuario y contrasena con iconos
- Selector de tipo de acceso (administrador, juez, equipo, staff)
- Validacion de campos con mensajes de error
- Mensaje de credenciales incorrectas

**admin/dashboard.html - Panel principal**
- Barra lateral fija con navegacion categorizada
- Barra superior con nombre de usuario y reloj
- Tarjetas de estadisticas (usuarios, competencias, problemas, envios)
- Tabla de ultimos envios con resultado por colores
- Scoreboard en vivo de la competencia activa
- Barra de progreso de tiempo transcurrido en la competencia

**admin/usuarios.html - Gestion de usuarios**
- Tabla con todos los usuarios registrados
- Busqueda en tiempo real por texto
- Filtro por tipo de usuario (administrador, juez, equipo, staff)
- Modal para crear usuario con validacion de contrasenas
- Boton de editar y eliminar con confirmacion

**admin/competencias.html - Gestion de competencias**
- Tabla de competencias con estado (en curso, programada, finalizada)
- Modal para crear competencia con validacion de fechas
- Verificacion de que la fecha de fin sea posterior al inicio

**admin/problemas.html - Gestion de problemas**
- Tabla de problemas con letra identificadora, limite de tiempo, memoria y porcentaje de acierto
- Filtro por competencia
- Modal para cargar problema con archivo PDF y casos de prueba ZIP

Funcionalidades JavaScript compartidas (boca-theme.js):
- Apertura y cierre de modales con animacion
- Validacion de formularios con marcado por campo
- Notificaciones toast en la esquina inferior derecha
- Busqueda en tiempo real sobre tablas
- Dialogo de confirmacion para eliminar registros
- Filtro por columna usando select

### Parte 2 - Integracion real en Boca (carpeta boca-integracion/)

Archivos PHP de Boca modificados para incorporar el tema mejorado dentro del sistema real.

**src/index.php**

Reemplaza el login original de Boca (tabla HTML centrada sin estilos) por:
- Diseno con tarjeta centrada sobre fondo degradado oscuro
- Campos con iconos usando Bootstrap Icons via CDN
- Mensaje de error integrado en la pagina en lugar de alert() del navegador
- Toda la logica PHP original conservada: sesion, cookies, hash de contrasena, redireccion por tipo de usuario

**src/admin/header.php**

Reemplaza la navegacion original (tabla horizontal amarilla) por:
- Sidebar fija a la izquierda con logo, secciones y enlaces
- Enlace activo resaltado segun la pagina actual (detectado con basename())
- Topbar fija en la parte superior con titulo de pagina, reloj de la competencia, nombre de usuario y boton de salida
- El contenido de cada pagina admin carga dentro de un div con los estilos del tema

**src/boca-theme.css y src/boca-theme.js**

Los mismos archivos de las paginas standalone, copiados al directorio de Boca para que los PHP puedan referenciarlos.

---

## Instrucciones para instalar y correr Boca con el tema aplicado

Sistema operativo requerido: Ubuntu 22.04 o superior (probado en Ubuntu 25.10).
Puede correrse en VirtualBox desde cualquier sistema operativo anfitrion.

### 1. Instalar dependencias

```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y apache2 php8.5-fpm php8.5-pgsql php8.5-mbstring \
  postgresql postgresql-client make wget unzip makepasswd
sudo a2enmod proxy_fcgi setenvif
sudo a2enconf php8.5-fpm
sudo systemctl restart apache2
```

### 2. Descargar e instalar Boca

```bash
cd ~
wget https://github.com/cassiopc/boca/archive/refs/heads/master.zip -O boca.zip
unzip boca.zip
cd boca-master
sudo make install-bocawww install-bocaapache install-bocadb install-bocacommon
```

### 3. Configurar Apache

```bash
sudo a2dissite 000-default
sudo a2ensite 000-boca
sudo systemctl reload apache2
```

### 4. Configurar la base de datos

```bash
sudo -u postgres psql -c "ALTER USER bocauser WITH PASSWORD 'boca2026';"
sudo PASSWD='boca2026' boca-config-dbhost localhost
printf 'YES\n' | sudo boca-createdb
```

### 5. Crear el usuario administrador

```bash
HASH=$(php -r "echo hash('sha256', 'boca2026');")
sudo -u postgres psql bocadb -c "
INSERT INTO usertable
  (contestnumber, usersitenumber, usernumber, username, userfullname,
   userdesc, usertype, userenabled, usermultilogin, userpassword, updatetime)
VALUES
  (0, 1, 2, 'admin', 'Administrador', 'Admin principal',
   'admin', true, false, '$HASH', EXTRACT(EPOCH FROM NOW())::bigint);"
```

### 6. Aplicar el tema mejorado

Copiar los archivos de la carpeta `boca-integracion/src/` al servidor:

```bash
sudo cp boca-theme.css /var/www/boca/src/
sudo cp boca-theme.js /var/www/boca/src/
sudo cp index.php /var/www/boca/src/index.php
sudo cp admin/header.php /var/www/boca/src/admin/header.php
sudo chown -R www-data:www-data /var/www/boca/src/
sudo systemctl reload apache2
```

### 7. Acceder al sistema

Abrir en el navegador: `http://IP-DEL-SERVIDOR/boca/`

Credenciales:
- Usuario: `admin`
- Contrasena: `boca2026`

---

## Tecnologias usadas

- HTML5
- CSS3 con variables, flexbox y grid
- JavaScript ES6 con IntersectionObserver y manipulacion del DOM
- Bootstrap Icons 1.11.3
- PHP 8.5
- PostgreSQL 18
- Apache 2 con PHP-FPM
- Ubuntu 25.10 en VirtualBox

---

## Autor

Alejandro Cifuentes Osorio
alejandro.cifuentes.osorio@gmail.com
