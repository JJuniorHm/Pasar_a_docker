console.log('JS de registro cargado');

// =====================
// EVENTOS GENERALES
// =====================
document.addEventListener('click', function (e) {

  // Generar password
if (e.target && e.target.id === 'genPass') {
    generarPassword();
}

  // Agregar teléfono
if (e.target && e.target.id === 'btnAddPhone') {
    agregarTelefono();
}
});

// =====================
// NOMBRE COMPLETO AUTO
// =====================
document.addEventListener('input', function (e) {
const campos = ['unombre1', 'unombre2', 'upaterno', 'umaterno'];
if (campos.includes(e.target.name)) {
    generarNombreCompleto();
}
});

// =====================
// INIT
// =====================
document.addEventListener('DOMContentLoaded', () => {
const form = document.getElementById('frmRegisterUser');
if (!form) return;

  generarPassword(); // password automático al cargar
form.addEventListener('submit', enviarFormulario);
});

// =====================
// FUNCIONES
// =====================
function generarPassword() {
const chars = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789";
let pass = "";
for (let i = 0; i < 10; i++) {
    pass += chars.charAt(Math.floor(Math.random() * chars.length));
}

const input = document.querySelector('[name="upassword"]');
if (input) input.value = pass;
}

function generarNombreCompleto() {
const n1  = document.querySelector('[name="unombre1"]')?.value || '';
const n2  = document.querySelector('[name="unombre2"]')?.value || '';
const pat = document.querySelector('[name="upaterno"]')?.value || '';
const mat = document.querySelector('[name="umaterno"]')?.value || '';

const full = `${n1} ${n2} ${mat} ${pat}`.replace(/\s+/g, ' ').trim();
const out = document.querySelector('[name="unombrecompleto"]');
if (out) out.value = full;
}

function agregarTelefono() {
const cont = document.getElementById('phonesContainer');
if (!cont) return;

const div = document.createElement('div');
div.className = 'mb-3';
div.innerHTML = `
    <label>Teléfono</label>
    <input type="text" class="form-control" name="utelefono[]" required>
`;
cont.appendChild(div);
}

function enviarFormulario(e) {
e.preventDefault();

fetch(BASE_URL + 'ajaxjs/user/register.php', {
    method: 'POST',
    body: new FormData(e.target)
})
.then(r => r.json())
.then(r => {
    alert(r.message);
    if (r.status) {
    e.target.reset();
      generarPassword(); // solo password
    }
})
.catch(err => {
    console.error(err);
    alert('Error al registrar');
});
}
