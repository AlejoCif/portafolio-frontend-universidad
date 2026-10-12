/* ===== MODALES ===== */
function abrirModal(id) {
    const m = document.getElementById(id);
    if (m) m.classList.add('open');
}

function cerrarModal(id) {
    const m = document.getElementById(id);
    if (m) {
        m.classList.remove('open');
        limpiarFormulario(m);
    }
}

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('modal-overlay')) {
        e.target.classList.remove('open');
        limpiarFormulario(e.target);
    }
});

function limpiarFormulario(modal) {
    modal.querySelectorAll('input, select, textarea').forEach(el => {
        el.value = '';
        el.classList.remove('is-invalid', 'is-valid');
    });
    modal.querySelectorAll('.form-error').forEach(el => el.style.display = 'none');
}

/* ===== VALIDACION DE FORMULARIOS ===== */
function validarCampo(input, regla, mensaje) {
    const errorEl = input.parentElement.querySelector('.form-error');
    let valido = regla(input.value.trim());
    input.classList.toggle('is-invalid', !valido);
    input.classList.toggle('is-valid', valido);
    if (errorEl) errorEl.style.display = valido ? 'none' : 'block';
    if (errorEl && !valido) errorEl.textContent = mensaje;
    return valido;
}

function validarFormulario(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    let valido = true;
    form.querySelectorAll('[data-requerido]').forEach(input => {
        if (!validarCampo(input, v => v.length >= 1, 'Este campo es requerido.')) valido = false;
    });
    form.querySelectorAll('[data-min]').forEach(input => {
        const min = parseInt(input.getAttribute('data-min'));
        if (!validarCampo(input, v => v.length >= min, `Minimo ${min} caracteres.`)) valido = false;
    });
    form.querySelectorAll('[data-email]').forEach(input => {
        if (!validarCampo(input, v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v), 'Correo invalido.')) valido = false;
    });
    return valido;
}

/* ===== TOAST ===== */
function mostrarToast(mensaje, tipo = 'success') {
    let contenedor = document.querySelector('.toast-container');
    if (!contenedor) {
        contenedor = document.createElement('div');
        contenedor.className = 'toast-container';
        document.body.appendChild(contenedor);
    }
    const iconos = { success: 'bi-check-circle-fill', error: 'bi-x-circle-fill', warning: 'bi-exclamation-circle-fill' };
    const colores = { success: '#27ae60', error: '#e74c3c', warning: '#f39c12' };
    const toast = document.createElement('div');
    toast.className = `toast ${tipo}`;
    toast.innerHTML = `<i class="bi ${iconos[tipo]}" style="color:${colores[tipo]};font-size:1rem;"></i><span>${mensaje}</span>`;
    contenedor.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.3s';
        setTimeout(() => toast.remove(), 300);
    }, 3500);
}

/* ===== BUSQUEDA EN TABLA ===== */
function filtrarTabla(inputId, tablaId) {
    const input = document.getElementById(inputId);
    const tabla = document.getElementById(tablaId);
    if (!input || !tabla) return;
    input.addEventListener('input', function () {
        const texto = this.value.toLowerCase();
        tabla.querySelectorAll('tbody tr').forEach(fila => {
            const contenido = fila.textContent.toLowerCase();
            fila.style.display = contenido.includes(texto) ? '' : 'none';
        });
    });
}

/* ===== CONFIRMACION DE ELIMINAR ===== */
function confirmarEliminar(nombre, callback) {
    const modal = document.getElementById('modal-confirmar');
    if (!modal) return;
    modal.querySelector('#confirmar-nombre').textContent = nombre;
    modal.classList.add('open');
    const btnConfirmar = modal.querySelector('#btn-confirmar-eliminar');
    const nuevo = btnConfirmar.cloneNode(true);
    btnConfirmar.parentNode.replaceChild(nuevo, btnConfirmar);
    nuevo.addEventListener('click', () => {
        modal.classList.remove('open');
        callback();
    });
}

/* ===== SELECCIONAR FILTRO POR TIPO ===== */
function filtrarPorSelect(selectId, tablaId, columna) {
    const select = document.getElementById(selectId);
    const tabla = document.getElementById(tablaId);
    if (!select || !tabla) return;
    select.addEventListener('change', function () {
        const valor = this.value.toLowerCase();
        tabla.querySelectorAll('tbody tr').forEach(fila => {
            const celda = fila.querySelectorAll('td')[columna];
            if (!celda) return;
            fila.style.display = (!valor || celda.textContent.toLowerCase().includes(valor)) ? '' : 'none';
        });
    });
}

/* ===== SIDEBAR MOVIL ===== */
const btnMenuMovil = document.getElementById('btn-menu-movil');
const sidebar = document.querySelector('.sidebar');
if (btnMenuMovil && sidebar) {
    btnMenuMovil.addEventListener('click', () => sidebar.classList.toggle('open'));
}
