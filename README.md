# Desarrollo Frontend - Alejandro Cifuentes

Proyecto del modulo de Desarrollo de Front-end - Politecnico Grancolombiano 2026.

---

## Estructura del proyecto

```
frontend/
├── entrega_1_Alejandro_Cifuentes.html   # Entrega previa 1 (semana 3)
├── entrega_2_Alejandro_Cifuentes.html   # Entrega previa 2 (semana 5)
├── styles.css                           # Estilos CSS entrega 2
├── script.js                            # JavaScript entrega 2
├── alejandro_cifuentes.jpeg
├── disempack.jpeg
├── asosuperfruver.jpeg
├── telemed.jpeg
├── boca-mejoras/                        # Paginas standalone Boca (semana 7)
│   ├── index.html                       # Login mejorado
│   ├── admin/
│   │   ├── dashboard.html
│   │   ├── usuarios.html
│   │   ├── competencias.html
│   │   └── problemas.html
│   ├── css/boca-theme.css
│   └── js/boca-theme.js
└── boca-integracion/                    # Archivos integrados a Boca real (semana 7)
    └── src/
        ├── index.php                    # Login de Boca reemplazado
        ├── boca-theme.css               # Tema CSS
        ├── boca-theme.js                # JavaScript del tema
        └── admin/
            └── header.php              # Header admin de Boca reemplazado
```

---

## Entrega previa 1 - Semana 3

Portafolio personal en un solo archivo HTML con CSS interno.

Contenido: navbar, presentacion, sobre mi, habilidades, proyectos y contacto.

Tecnologias: HTML5, CSS3 interno.

---

## Entrega previa 2 - Semana 5

Version mejorada del portafolio con archivos separados y frameworks.

Cambios principales:
- CSS y JavaScript movidos a archivos externos
- Bootstrap 5.3.2 para diseno responsivo
- Bootstrap Icons para iconografia
- Navbar fija con menu hamburguesa para movil
- Barras de progreso animadas en habilidades
- Contadores numericos animados
- Formulario de contacto con validacion JavaScript campo por campo
- Animaciones fade-in con IntersectionObserver
- Boton volver arriba

Tecnologias: HTML5, CSS3, JavaScript ES6, Bootstrap 5, Bootstrap Icons.

---

## Entrega final - Semana 7

Mejora de la interfaz del software BOCA (Online Contest Administrator) integrada al sistema real corriendo en Ubuntu 25.10 via VirtualBox.

### Paginas standalone (boca-mejoras/)

Paginas HTML/CSS/JS que muestran el diseno mejorado sin necesidad de tener Boca instalado.

- `index.html` - Login moderno con validacion
- `admin/dashboard.html` - Panel con stats, scoreboard en vivo y ultimos envios
- `admin/usuarios.html` - CRUD de usuarios con busqueda, filtros y modales
- `admin/competencias.html` - CRUD de competencias con validacion de fechas
- `admin/problemas.html` - CRUD de problemas con filtro por competencia

### Integracion real (boca-integracion/)

Archivos PHP de Boca modificados para usar el tema mejorado.

- `src/index.php` - Login de Boca reemplazado con diseno moderno
- `src/admin/header.php` - Navegacion reemplazada con sidebar + topbar
- `src/boca-theme.css` - Hoja de estilos del tema
- `src/boca-theme.js` - JavaScript compartido

Mejoras implementadas en Boca:
- Login con tarjeta centrada, iconos y mensaje de error integrado
- Sidebar fija con navegacion categorizada y enlace activo segun pagina
- Topbar con nombre de usuario, sitio, reloj de competencia y boton de salida
- Diseno responsivo con variables CSS
- Tipografia y paleta de colores consistentes en todas las paginas admin

### Instrucciones para instalar y correr Boca

Requisitos: Ubuntu 22.04+ o 25.10, Apache2, PHP 8.x FPM, PostgreSQL.

```bash
# 1. Instalar dependencias
sudo apt update
sudo apt install -y apache2 php8.5-fpm php8.5-pgsql php8.5-mbstring postgresql postgresql-client make wget makepasswd
sudo a2enmod proxy_fcgi setenvif && sudo a2enconf php8.5-fpm

# 2. Descargar Boca
wget https://github.com/cassiopc/boca/archive/refs/heads/master.zip -O boca.zip
unzip boca.zip && cd boca-master

# 3. Instalar Boca
sudo make install-bocawww install-bocaapache install-bocadb install-bocacommon
sudo a2dissite 000-default && sudo a2ensite 000-boca
sudo PASSWD='boca2026' boca-config-dbhost localhost
printf 'YES\n' | sudo boca-createdb
sudo systemctl restart apache2

# 4. Crear usuario admin
HASH=$(php -r "echo hash('sha256', 'boca2026');")
sudo -u postgres psql bocadb -c "
INSERT INTO usertable (contestnumber, usersitenumber, usernumber, username, userfullname, userdesc, usertype, userenabled, usermultilogin, userpassword, updatetime)
VALUES (0, 1, 2, 'admin', 'Administrador', 'Admin principal', 'admin', true, false, '$HASH', EXTRACT(EPOCH FROM NOW())::bigint);"

# 5. Aplicar tema mejorado
sudo cp boca-theme.css /var/www/boca/src/
sudo cp boca-theme.js /var/www/boca/src/
sudo cp src/index.php /var/www/boca/src/index.php
sudo cp src/admin/header.php /var/www/boca/src/admin/header.php
sudo chown -R www-data:www-data /var/www/boca/src/
sudo systemctl reload apache2
```

Acceso: `http://IP-DEL-SERVIDOR/boca/`
- Usuario: `admin`
- Contrasena: `boca2026`

---

## Tecnologias usadas en la entrega final

- HTML5, CSS3, JavaScript ES6
- Bootstrap Icons 1.11.3 (via CDN)
- PHP 8.5 (integracion con Boca)
- PostgreSQL 18 (base de datos de Boca)
- Apache2 con PHP-FPM
- Ubuntu 25.10 en VirtualBox

---

## Autor

Alejandro Cifuentes Osorio
alejandro.cifuentes.osorio@gmail.com
