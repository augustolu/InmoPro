<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header Transparente con Imagen de Fondo -->
<div style="position: relative; height: 500px; background-color: #1f2937; overflow: hidden; display: flex; align-items: flex-end; padding-bottom: 40px;">
    <?php if (!empty($propiedad['imagen_principal'])): ?>
        <img src="<?= base_url(esc($propiedad['imagen_principal'])) ?>" alt="<?= esc($propiedad['titulo']) ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.6; z-index: 0;">
    <?php endif; ?>
    
    <!-- Gradiente para que el texto se lea bien -->
    <div style="position: absolute; bottom: 0; left: 0; width: 100%; height: 60%; background: linear-gradient(to top, rgba(0,0,0,0.9), transparent); z-index: 1;"></div>

    <div style="position: relative; z-index: 2; width: 100%; max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div style="display: flex; gap: 10px; margin-bottom: 15px;">
            <a href="<?= esc('https://www.google.com/maps/search/?api=1&query=' . urlencode($propiedad['ubicacion'])) ?>" target="_blank" rel="noopener noreferrer" style="background-color: rgba(255,255,255,0.2); backdrop-filter: blur(4px); color: white; padding: 6px 15px; border-radius: 20px; font-weight: 600; font-size: 0.9rem; text-decoration: none; transition: background 0.3s;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.4)'" onmouseout="this.style.backgroundColor='rgba(255,255,255,0.2)'">
                <i class="fas fa-map-marker-alt"></i> <?= esc($propiedad['ubicacion']) ?> <i class="fas fa-external-link-alt" style="font-size: 0.7rem; margin-left: 5px;"></i>
            </a>
            <?php if (!empty($imagenes)): ?>
                <span style="background-color: rgba(255,255,255,0.2); backdrop-filter: blur(4px); color: white; padding: 6px 15px; border-radius: 20px; font-weight: 600; font-size: 0.9rem;">
                    <i class="fas fa-images"></i> <?= count($imagenes) ?> fotos
                </span>
            <?php endif; ?>
        </div>
        
        <h1 style="color: white; font-size: 3.5rem; margin: 0 0 10px 0; font-weight: 800; text-shadow: 0 2px 10px rgba(0,0,0,0.5);">
            <?= esc($propiedad['titulo']) ?>
        </h1>
        
        <div style="color: #10b981; font-size: 2.5rem; font-weight: 800; text-shadow: 0 2px 10px rgba(0,0,0,0.5);">
            $<?= number_format($propiedad['precio'], 0, ',', '.') ?> <span style="font-size: 1.2rem; color: #e5e7eb; font-weight: 500;">/ noche</span>
        </div>
    </div>
</div>

<!-- Contenido Principal -->
<div style="background-color: #f3f4f6; padding: 60px 20px;">
    <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
        
        <!-- Columna Izquierda (Detalles) -->
        <div>
            <!-- Galería de Imágenes -->
            <?php if (!empty($imagenes)): ?>
            <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px; overflow: hidden;">
                <h3 style="font-size: 1.2rem; color: #1f2937; margin: 0 0 15px 0; font-weight: 700;">Galería de Fotos</h3>
                
                <!-- Imagen Principal de Galería -->
                <div style="position: relative; width: 100%; height: 400px; border-radius: 8px; overflow: hidden; background-color: #e5e7eb; margin-bottom: 15px;">
                    <img id="main-gallery-img" src="<?= base_url(esc($imagenes[0]['ruta'])) ?>" alt="Foto de la propiedad" style="width: 100%; height: 100%; object-fit: cover;">
                    <button onclick="previousImage()" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background-color: rgba(0,0,0,0.5); color: white; border: none; padding: 10px 14px; border-radius: 6px; cursor: pointer; font-size: 1.2rem; transition: background 0.3s;" onmouseover="this.style.backgroundColor='rgba(0,0,0,0.8)'" onmouseout="this.style.backgroundColor='rgba(0,0,0,0.5)'">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button onclick="nextImage()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background-color: rgba(0,0,0,0.5); color: white; border: none; padding: 10px 14px; border-radius: 6px; cursor: pointer; font-size: 1.2rem; transition: background 0.3s;" onmouseover="this.style.backgroundColor='rgba(0,0,0,0.8)'" onmouseout="this.style.backgroundColor='rgba(0,0,0,0.5)'">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <div style="position: absolute; bottom: 10px; right: 10px; background-color: rgba(0,0,0,0.7); color: white; padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600;">
                        <span id="current-image">1</span> / <span id="total-images"><?= count($imagenes) ?></span>
                    </div>
                </div>

                <!-- Miniaturas -->
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 10px;">
                    <?php foreach ($imagenes as $index => $imagen): ?>
                    <img src="<?= base_url(esc($imagen['ruta'])) ?>" alt="Miniatura" 
                         onclick="goToImage(<?= $index ?>)" 
                         style="width: 100%; height: 80px; object-fit: cover; border-radius: 6px; cursor: pointer; border: 2px solid transparent; transition: all 0.3s;" 
                         class="gallery-thumbnail" 
                         onmouseover="this.style.borderColor='#10b981'; this.style.opacity='0.8'" 
                         onmouseout="this.style.borderColor='transparent'; this.style.opacity='1'">
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Tarjeta de Características Clave -->
            <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px; display: flex; justify-content: space-around; text-align: center;">
                <div>
                    <i class="fas fa-bed" style="font-size: 2rem; color: #9ca3af; margin-bottom: 10px;"></i>
                    <h4 style="margin: 0; color: #1f2937; font-size: 1.2rem; font-weight: 700;"><?= esc($propiedad['habitaciones']) ?></h4>
                    <p style="margin: 0; color: #6b7280; font-size: 0.9rem; text-transform: uppercase;">Habitaciones</p>
                </div>
                <div style="width: 1px; background-color: #e5e7eb;"></div>
                <div>
                    <i class="fas fa-bath" style="font-size: 2rem; color: #9ca3af; margin-bottom: 10px;"></i>
                    <h4 style="margin: 0; color: #1f2937; font-size: 1.2rem; font-weight: 700;"><?= esc($propiedad['banos']) ?></h4>
                    <p style="margin: 0; color: #6b7280; font-size: 0.9rem; text-transform: uppercase;">Baños</p>
                </div>
                <?php if (!empty($propiedad['metros_cuadrados'])): ?>
                <div style="width: 1px; background-color: #e5e7eb;"></div>
                <div>
                    <i class="fas fa-vector-square" style="font-size: 2rem; color: #9ca3af; margin-bottom: 10px;"></i>
                    <h4 style="margin: 0; color: #1f2937; font-size: 1.2rem; font-weight: 700;"><?= esc($propiedad['metros_cuadrados']) ?> <span style="font-size: 0.9rem; font-weight: normal;">m&sup2;</span></h4>
                    <p style="margin: 0; color: #6b7280; font-size: 0.9rem; text-transform: uppercase;">Superficie</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Tarjeta de Descripción -->
            <div style="background: white; border-radius: 12px; padding: 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <h3 style="font-size: 1.5rem; color: #1f2937; margin: 0 0 20px 0; font-weight: 700; padding-bottom: 15px; border-bottom: 1px solid #f3f4f6;">Acerca de esta propiedad</h3>
                <div style="color: #4b5563; font-size: 1.1rem; line-height: 1.8; white-space: pre-line;">
                   <?= esc($propiedad['descripcion'] ?: 'No hay descripción disponible para esta propiedad.') ?>
                </div>
            </div>
        </div>

        <!-- Columna Derecha (Reserva con Calendario) -->
        <div>
            <!-- Widget de Reserva -->
            <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); position: sticky; top: 100px;">
                <h3 style="font-size: 1.3rem; color: #1f2937; margin: 0 0 8px 0; font-weight: 700; text-align: center;">Reservar esta Propiedad</h3>
                <p style="color: #6b7280; font-size: 0.9rem; text-align: center; margin-bottom: 20px;">
                    $<?= number_format($propiedad['precio'], 0, ',', '.') ?> por noche
                </p>

                <?php if (session()->get('logged_in')): ?>
                    <!-- Calendario -->
                    <div id="calendar-container" style="margin-bottom: 20px;"></div>

                    <!-- Resumen de Selección -->
                    <div id="selection-summary" class="selection-summary" style="background-color: #f3f4f6; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <div style="margin-bottom: 10px;">
                            <p style="margin: 0 0 5px 0; color: #6b7280; font-size: 0.85rem; font-weight: 600;">
                                <i class="fas fa-calendar-check"></i> Entrada:
                            </p>
                            <p style="margin: 0; color: #1f2937; font-weight: 600;" id="summary-checkin">—</p>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <p style="margin: 0 0 5px 0; color: #6b7280; font-size: 0.85rem; font-weight: 600;">
                                <i class="fas fa-calendar-times"></i> Salida:
                            </p>
                            <p style="margin: 0; color: #1f2937; font-weight: 600;" id="summary-checkout">—</p>
                        </div>
                        <div style="border-top: 1px solid #e5e7eb; padding-top: 10px; display: flex; justify-content: space-between;">
                            <span style="color: #6b7280; font-weight: 600;">
                                <i class="fas fa-moon"></i> <span id="summary-nights">0</span> noche(s)
                            </span>
                            <span style="color: #10b981; font-weight: 700; font-size: 1.1rem;">
                                $<span id="summary-total">0</span>
                            </span>
                        </div>
                    </div>

                    <!-- Huéspedes y Comentarios -->
                    <form action="<?= base_url('reservas/confirmar-propiedad') ?>" method="post" id="reservation-form" style="display: none;">
                        <?= csrf_field() ?>
                        <input type="hidden" name="idPropiedad" value="<?= $propiedad['idPropiedad'] ?>">
                        <input type="hidden" name="fechaInicio" id="form-fechaInicio">
                        <input type="hidden" name="fechaFin" id="form-fechaFin">

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 0.9rem;">
                                <i class="fas fa-users" style="margin-right: 5px;"></i>Cantidad de Huéspedes
                            </label>
                            <input type="number" name="cantidadHuespedes" id="huespedes" required min="1" 
                                   value="1" max="<?= $propiedad['habitaciones'] * 2 ?>"
                                   style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.95rem;">
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 0.9rem;">
                                <i class="fas fa-comment" style="margin-right: 5px;"></i>Comentarios (Opcional)
                            </label>
                            <textarea name="comentarios" rows="3" placeholder="Déjanos saber si tienes alguna petición especial..."
                                      style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.9rem; font-family: inherit; resize: vertical;"></textarea>
                        </div>

                        <button type="submit" style="display: block; width: 100%; padding: 15px 0; background-color: #10b981; color: white; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 1.1rem; transition: background 0.3s; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2); border: none; cursor: pointer;" onmouseover="this.style.backgroundColor='#059669'" onmouseout="this.style.backgroundColor='#10b981'">
                            <i class="fas fa-check-circle" style="margin-right: 8px;"></i>Confirmar Reserva
                        </button>
                    </form>

                    <p style="color: #6b7280; font-size: 0.8rem; text-align: center; margin-top: 15px;">
                        <i class="fas fa-info-circle" style="margin-right: 4px;"></i>Haz clic en dos fechas para seleccionar tu estancia
                    </p>

                <?php else: ?>
                    <div style="background-color: #fef2f2; border: 1px solid #fee2e2; padding: 20px; border-radius: 8px; text-align: center; margin-bottom: 25px;">
                        <i class="fas fa-lock" style="font-size: 2rem; color: #dc2626; margin-bottom: 10px;"></i>
                        <p style="margin: 10px 0 0 0; color: #991b1b; font-size: 0.95rem;">Inicia sesión para hacer una reserva</p>
                    </div>
                    <a href="<?= base_url('auth/login') ?>" style="display: block; text-align: center; width: 100%; padding: 15px 0; background-color: #1f2937; color: white; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 1.1rem; transition: background 0.3s; margin-bottom: 15px;" onmouseover="this.style.backgroundColor='#111827'" onmouseout="this.style.backgroundColor='#1f2937'">
                        <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>Iniciar Sesión
                    </a>
                    <a href="<?= base_url('auth/register') ?>" style="display: block; text-align: center; width: 100%; padding: 15px 0; background-color: white; color: #1f2937; text-decoration: none; border-radius: 8px; font-weight: 700; border: 2px solid #1f2937; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#f3f4f6'" onmouseout="this.style.backgroundColor='white'">
                        <i class="fas fa-user-plus" style="margin-right: 8px;"></i>Registrarse
                    </a>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

    <style>
    /* animated summary box: fade in/out without affecting layout
       we reserve space so the surrounding container doesn't jump. */
    #selection-summary.selection-summary {
        opacity: 0;
        visibility: hidden;
        /* ensure a minimum height so surrounding blocks don't collapse */
        min-height: 120px;
        transition: opacity 0.3s ease;
    }
    #selection-summary.selection-summary.visible {
        opacity: 1;
        visibility: visible;
    }
@media (max-width: 768px) {
    div[style*="grid-template-columns: 2fr 1fr;"] {
        grid-template-columns: 1fr !important;
    }
}
</style>

<script>
const precioPorNoche = <?= $propiedad['precio'] ?>;
let fechaSeleccionada1 = null;
let fechaSeleccionada2 = null;
let currentMonth = new Date();

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`
}

function estaReservado(fecha) {
    return false; // TODO: load from server
}

// Helper that checks if a date falls strictly between the two selected points
function inRange(fecha) {
    if (!fechaSeleccionada1 || !fechaSeleccionada2) return false;
    const start = fechaSeleccionada1 < fechaSeleccionada2 ? fechaSeleccionada1 : fechaSeleccionada2;
    const end = fechaSeleccionada1 < fechaSeleccionada2 ? fechaSeleccionada2 : fechaSeleccionada1;
    return fecha > start && fecha < end;
}

function isStartDate(fecha) {
    if (!fechaSeleccionada1) return false;
    // if we only have the first date, treat it as the start (and also the only) date
    if (!fechaSeleccionada2) {
        return formatDate(fecha) === formatDate(fechaSeleccionada1);
    }
    const start = fechaSeleccionada1 < fechaSeleccionada2 ? fechaSeleccionada1 : fechaSeleccionada2;
    return formatDate(fecha) === formatDate(start);
}

function isEndDate(fecha) {
    if (!fechaSeleccionada1 || !fechaSeleccionada2) return false;
    const end = fechaSeleccionada1 < fechaSeleccionada2 ? fechaSeleccionada2 : fechaSeleccionada1;
    return formatDate(fecha) === formatDate(end);
}

function seleccionarFecha(fecha) {
    if (estaReservado(fecha)) return;

    if (!fechaSeleccionada1) {
        // first click ever
        fechaSeleccionada1 = fecha;
    } else if (!fechaSeleccionada2) {
        // this is the second click: establish a range or clear
        if (formatDate(fecha) === formatDate(fechaSeleccionada1)) {
            // clicked same day twice: clear selection altogether
            fechaSeleccionada1 = null;
        } else if (fecha < fechaSeleccionada1) {
            // second click earlier than first: swap roles
            fechaSeleccionada2 = fechaSeleccionada1;
            fechaSeleccionada1 = fecha;
        } else {
            fechaSeleccionada2 = fecha;
        }
    } else {
        // already have a full range (two distinct dates)
        const startStr = formatDate(fechaSeleccionada1);
        const endStr   = formatDate(fechaSeleccionada2);
        const clickedStr = formatDate(fecha);

        if (clickedStr === startStr && clickedStr === endStr) {
            // both are equal (rare), clear everything
            fechaSeleccionada1 = null;
            fechaSeleccionada2 = null;
        } else if (clickedStr === startStr) {
            // drop the start; end becomes lone selection
            fechaSeleccionada1 = fechaSeleccionada2;
            fechaSeleccionada2 = null;
        } else if (clickedStr === endStr) {
            // drop the end; start remains
            fechaSeleccionada2 = null;
        } else {
            // click on a different date: adjust the closer endpoint instead
            const distToStart = Math.abs(fecha - fechaSeleccionada1);
            const distToEnd   = Math.abs(fecha - fechaSeleccionada2);
            if (distToStart <= distToEnd) {
                fechaSeleccionada1 = fecha;
            } else {
                fechaSeleccionada2 = fecha;
            }
            // normalize order if they crossed
            if (fechaSeleccionada1 && fechaSeleccionada2 && fechaSeleccionada1 > fechaSeleccionada2) {
                const tmp = fechaSeleccionada1;
                fechaSeleccionada1 = fechaSeleccionada2;
                fechaSeleccionada2 = tmp;
            }
        }
    }

    // if after adjustments we are left with a single date that's not in
    // the currently visible month, clear it too. This prevents a "hidden"
    // selection remaining when the user unmarks one endpoint on another
    // month where the complementary date is no longer visible.
    if (fechaSeleccionada1 && !fechaSeleccionada2) {
        const rem = fechaSeleccionada1;
        if (rem.getMonth() !== currentMonth.getMonth() ||
            rem.getFullYear() !== currentMonth.getFullYear()) {
            fechaSeleccionada1 = null;
        }
    }

    renderCalendar();
    actualizarResumen();
}

function renderCalendar() {
    const year = currentMonth.getFullYear();
    const month = currentMonth.getMonth();
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const daysInMonth = lastDay.getDate();
    const startingDayOfWeek = firstDay.getDay();
    const hoy = new Date(); hoy.setHours(0,0,0,0);

    let html = `
        <div style="background-color:#fff; border-radius:8px; padding:15px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <button type="button" onclick="previousMonth()" style="background:none; border:none; padding:8px 12px; color:#374151; font-size:1.2rem; cursor:pointer; border-radius:6px; transition:background 0.3s;" onmouseover="this.style.backgroundColor='#f3f4f6'" onmouseout="this.style.backgroundColor='transparent'">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <h4 style="margin:0; color:#1f2937; font-weight:700; text-align:center; flex:1; text-transform:capitalize;">
                    ${new Date(year, month).toLocaleDateString('es-ES', { month: 'long', year: 'numeric' })}
                </h4>
                <button type="button" onclick="nextMonth()" style="background:none; border:none; padding:8px 12px; color:#374151; font-size:1.2rem; cursor:pointer; border-radius:6px; transition:background 0.3s;" onmouseover="this.style.backgroundColor='#f3f4f6'" onmouseout="this.style.backgroundColor='transparent'">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <div style="display:grid; grid-template-columns:repeat(7,1fr); gap:4px;">
    `;

    ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'].forEach(d => {
        html += `<div style="text-align:center; color:#9ca3af; font-size:0.7rem; font-weight:700; padding:6px 0;">${d}</div>`;
    });

    for (let i = 0; i < startingDayOfWeek; i++) {
        html += `<div></div>`;
    }

    for (let day = 1; day <= daysInMonth; day++) {
        const fecha = new Date(year, month, day);
        const esPasado = fecha < hoy;
        const esReservado = estaReservado(fecha);
        const esStart = isStartDate(fecha);
        const esEnd = isEndDate(fecha);
        const esMedio = inRange(fecha);
        const sinSeleccion = !fechaSeleccionada1;
        // const esHoy = formatDate(fecha) === formatDate(hoy); // no longer highlighted separately

        let bg, color, fw, cursor, radius, border;
        radius = '6px';
        border = 'none';
        fw = '600';
        
        if (esPasado || esReservado) {
            bg = '#e5e7eb'; color = '#9ca3af'; cursor = 'not-allowed';
        } else if (esStart || esEnd) {
            bg = '#059669'; color = '#fff'; fw = '800'; cursor = 'pointer';
            // Rounded only on the outer side
            radius = esStart && esEnd ? '6px' :
                     esStart ? '6px 0 0 6px' : '0 6px 6px 0';
        } else if (esMedio) {
            bg = '#d1fae5'; color = '#065f46'; cursor = 'pointer'; radius = '0';
        } else {
            // default appearance: available day
            bg = 'transparent'; color = '#374151'; cursor = 'pointer';
        }

        const clickable = !esPasado && !esReservado;
        html += `
                <div 
                    onclick="${clickable ? `seleccionarFecha(new Date(${year},${month},${day}))` : ''}"
                    style="
                    padding: 9px 4px;
                    background-color: ${bg};
                    color: ${color};
                    cursor: ${cursor};
                    font-weight: ${fw};
                    text-align: center;
                    border-radius: ${radius};
                    border: ${border};
                    font-size: 0.9rem;
                    transition: background-color 0.15s, transform 0.1s;
                    user-select: none;
                "
                ${clickable ? `onmouseover="this.style.transform='scale(1.15)'" onmouseout="this.style.transform='scale(1)'"` : ''}
            >${day}</div>
        `;
    }

    html += `</div></div>`;
    document.getElementById('calendar-container').innerHTML = html;
}

function previousMonth() {
    currentMonth.setMonth(currentMonth.getMonth() - 1);
    renderCalendar();
}

function nextMonth() {
    currentMonth.setMonth(currentMonth.getMonth() + 1);
    renderCalendar();
}

function actualizarResumen() {
    const summaryDiv = document.getElementById('selection-summary');
    const form = document.getElementById('reservation-form');

    if (!fechaSeleccionada1 || !fechaSeleccionada2) {
        summaryDiv.classList.remove('visible');
        form.style.display = 'none';
        return;
    }

    const inicio = fechaSeleccionada1 < fechaSeleccionada2 ? fechaSeleccionada1 : fechaSeleccionada2;
    const fin    = fechaSeleccionada1 < fechaSeleccionada2 ? fechaSeleccionada2 : fechaSeleccionada1;
    const noches = Math.ceil((fin - inicio) / (1000 * 60 * 60 * 24));
    const total  = noches * precioPorNoche;

    document.getElementById('summary-checkin').textContent  = inicio.toLocaleDateString('es-ES', {day:'2-digit', month:'short', year:'numeric'});
    document.getElementById('summary-checkout').textContent = fin.toLocaleDateString('es-ES',   {day:'2-digit', month:'short', year:'numeric'});
    document.getElementById('summary-nights').textContent   = noches;
    document.getElementById('summary-total').textContent    = total.toLocaleString('es-ES');
    document.getElementById('form-fechaInicio').value = formatDate(inicio);
    document.getElementById('form-fechaFin').value    = formatDate(fin);

    summaryDiv.classList.add('visible');
    form.style.display = 'block';
}

document.addEventListener('DOMContentLoaded', renderCalendar);
</script>

<script>
let currentImageIndex = 0;
const images = [
    <?php foreach ($imagenes as $index => $imagen): ?>
    '<?= base_url(esc($imagen['ruta'])) ?>'<?= $index < count($imagenes) - 1 ? ',' : '' ?>
    <?php endforeach; ?>
];

function updateGalleryImage() {
    if (images.length > 0) {
        document.getElementById('main-gallery-img').src = images[currentImageIndex];
        document.getElementById('current-image').textContent = currentImageIndex + 1;
        
        // Actualizar border de miniaturas
        const thumbnails = document.querySelectorAll('.gallery-thumbnail');
        thumbnails.forEach((thumb, index) => {
            if (index === currentImageIndex) {
                thumb.style.borderColor = '#10b981';
            } else {
                thumb.style.borderColor = 'transparent';
            }
        });
    }
}

function nextImage() {
    if (images.length > 0) {
        currentImageIndex = (currentImageIndex + 1) % images.length;
        updateGalleryImage();
    }
}

function previousImage() {
    if (images.length > 0) {
        currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
        updateGalleryImage();
    }
}

function goToImage(index) {
    currentImageIndex = index;
    updateGalleryImage();
}

// Teclado: flechas para navegar galería
document.addEventListener('keydown', function(event) {
    if (event.key === 'ArrowRight') {
        nextImage();
    } else if (event.key === 'ArrowLeft') {
        previousImage();
    }
});

// Inicializar galería
document.addEventListener('DOMContentLoaded', function() {
    updateGalleryImage();
});
</script>

<?= $this->endSection() ?>
