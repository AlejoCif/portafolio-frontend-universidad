/* ===== NAVBAR: highlight activo al hacer scroll ===== */
const secciones = document.querySelectorAll('section[id], div[id]');
const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

const observerNav = new IntersectionObserver(
    (entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + entry.target.id) {
                        link.classList.add('active');
                    }
                });
            }
        });
    },
    { rootMargin: '-40% 0px -55% 0px' }
);

secciones.forEach(s => observerNav.observe(s));

/* ===== CERRAR MENÚ MÓVIL AL HACER CLIC EN UN ENLACE ===== */
document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
    link.addEventListener('click', () => {
        const colapso = document.getElementById('navbarMenu');
        const bsCollapse = bootstrap.Collapse.getInstance(colapso);
        if (bsCollapse) bsCollapse.hide();
    });
});

/* ===== ANIMACIONES FADE-IN AL HACER SCROLL ===== */
const elementosFade = document.querySelectorAll('.fade-in');

const observerFade = new IntersectionObserver(
    (entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observerFade.unobserve(entry.target);
            }
        });
    },
    { threshold: 0.15 }
);

elementosFade.forEach(el => observerFade.observe(el));

/* ===== BARRAS DE PROGRESO AL ENTRAR EN VISTA ===== */
const barras = document.querySelectorAll('.progress-bar[data-width]');

const observerBarras = new IntersectionObserver(
    (entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const barra = entry.target;
                const porcentaje = barra.getAttribute('data-width');
                setTimeout(() => {
                    barra.style.width = porcentaje + '%';
                }, 200);
                observerBarras.unobserve(barra);
            }
        });
    },
    { threshold: 0.3 }
);

barras.forEach(b => observerBarras.observe(b));

/* ===== BOTÓN VOLVER ARRIBA ===== */
const btnArriba = document.getElementById('btn-arriba');

window.addEventListener('scroll', () => {
    if (window.scrollY > 400) {
        btnArriba.classList.add('visible');
    } else {
        btnArriba.classList.remove('visible');
    }
});

btnArriba.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

/* ===== VALIDACIÓN DEL FORMULARIO DE CONTACTO ===== */
const formulario = document.getElementById('form-contacto');
const alertaExito = document.getElementById('alerta-exito');

formulario.addEventListener('submit', function (e) {
    e.preventDefault();

    let esValido = true;

    // Validar nombre
    const nombre = document.getElementById('nombre');
    if (nombre.value.trim().length < 2) {
        marcarInvalido(nombre, 'El nombre debe tener al menos 2 caracteres.');
        esValido = false;
    } else {
        marcarValido(nombre);
    }

    // Validar correo
    const correo = document.getElementById('correo');
    const regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexCorreo.test(correo.value.trim())) {
        marcarInvalido(correo, 'Ingresa un correo electrónico válido.');
        esValido = false;
    } else {
        marcarValido(correo);
    }

    // Validar asunto
    const asunto = document.getElementById('asunto');
    if (asunto.value.trim().length < 3) {
        marcarInvalido(asunto, 'El asunto debe tener al menos 3 caracteres.');
        esValido = false;
    } else {
        marcarValido(asunto);
    }

    // Validar mensaje
    const mensaje = document.getElementById('mensaje');
    if (mensaje.value.trim().length < 10) {
        marcarInvalido(mensaje, 'El mensaje debe tener al menos 10 caracteres.');
        esValido = false;
    } else {
        marcarValido(mensaje);
    }

    if (esValido) {
        alertaExito.style.display = 'block';
        formulario.reset();
        document.querySelectorAll('.form-control').forEach(campo => {
            campo.classList.remove('is-valid');
        });
        setTimeout(() => {
            alertaExito.style.display = 'none';
        }, 5000);
    }
});

function marcarInvalido(campo, mensaje) {
    campo.classList.remove('is-valid');
    campo.classList.add('is-invalid');
    const feedback = campo.nextElementSibling;
    if (feedback && feedback.classList.contains('invalid-feedback')) {
        feedback.textContent = mensaje;
    }
}

function marcarValido(campo) {
    campo.classList.remove('is-invalid');
    campo.classList.add('is-valid');
}

/* ===== LIMPIAR VALIDACIÓN AL ESCRIBIR ===== */
document.querySelectorAll('.form-contacto .form-control').forEach(campo => {
    campo.addEventListener('input', () => {
        campo.classList.remove('is-invalid');
    });
});

/* ===== CONTADOR ANIMADO EN HERO ===== */
function animarContador(elemento, fin, duracion) {
    let inicio = 0;
    const paso = Math.ceil(duracion / fin);
    const timer = setInterval(() => {
        inicio++;
        elemento.textContent = inicio + '+';
        if (inicio >= fin) {
            elemento.textContent = fin + '+';
            clearInterval(timer);
        }
    }, paso);
}

const observerContadores = new IntersectionObserver(
    (entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const contadores = document.querySelectorAll('.contador');
                contadores.forEach(c => {
                    const valor = parseInt(c.getAttribute('data-valor'));
                    animarContador(c, valor, 1000);
                });
                observerContadores.unobserve(entry.target);
            }
        });
    },
    { threshold: 0.5 }
);

const seccionContadores = document.getElementById('sobre-mi');
if (seccionContadores) observerContadores.observe(seccionContadores);
