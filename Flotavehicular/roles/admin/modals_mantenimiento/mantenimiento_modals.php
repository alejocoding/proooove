<?php
require_once('../../conecct/conex.php');

$db = new Database();
$con = $db->conectar();

$vehiculos_query = $con->prepare("SELECT placa, CONCAT(placa, ' - ', u.nombre_completo) as display_text FROM vehiculos v LEFT JOIN usuarios u ON v.Documento = u.documento ORDER BY placa");
$vehiculos_query->execute();
$vehiculos = $vehiculos_query->fetchAll(PDO::FETCH_ASSOC);

$tipos_query = $con->prepare("SELECT id_tipo_mantenimiento, descripcion FROM tipo_mantenimiento ORDER BY descripcion");
$tipos_query->execute();
$tipos = $tipos_query->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="modal fade" id="modalAgregarMantenimiento" tabindex="-1" aria-labelledby="modalAgregarMantenimientoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarMantenimientoLabel">
          <i class="bi bi-plus-circle"></i> Agregar Nuevo Mantenimiento
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form id="formAgregarMantenimiento" onsubmit="return validarFormulario(this)">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="placaAgregar" class="form-label">Placa del Vehículo</label>
              <select class="form-select" id="placaAgregar" name="placa" required>
                <option value="">Seleccionar vehículo...</option>
                <?php foreach($vehiculos as $vehiculo): ?>
                  <option value="<?= $vehiculo['placa'] ?>"><?= htmlspecialchars($vehiculo['display_text']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="mb-3">
              <label for="tipoMantenimientoAgregar" class="form-label">Tipo de Mantenimiento</label>
              <select class="form-select" id="tipoMantenimientoAgregar" name="id_tipo_mantenimiento" required>
                <option value="">Seleccionar tipo...</option>
                <?php foreach($tipos as $tipo): ?>
                  <option value="<?= $tipo['id_tipo_mantenimiento'] ?>"><?= htmlspecialchars($tipo['descripcion']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="fechaProgr" class="form-label">Fecha Programada</label>
              <input type="date" class="form-control" id="fechaProgr" name="fecha_programada" required>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="mb-3">
              <label for="fechaRealizadaAgregar" class="form-label">Fecha Realizada</label>
              <input type="date" class="form-control" id="fechaRealizadaAgregar" name="fecha_realizada">
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="kilometrajeActualAgregar" class="form-label">Kilometraje Actual</label>
              <input type="number" class="form-control" id="kilometrajeActualAgregar" name="kilometraje_actual" min="0" max="999999" maxlength="6">
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="mb-3">
              <label for="proximoCambioKmAgregar" class="form-label">Próximo Cambio (Km)</label>
              <input type="number" class="form-control" id="proximoCambioKmAgregar" name="proximo_cambio_km" min="0" max="999999" maxlength="6">
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="proximoCambioFechaAgregar" class="form-label">Próximo Cambio (Fecha)</label>
              <input type="date" class="form-control" id="proximoCambioFechaAgregar" name="proximo_cambio_fecha">
            </div>
          </div>
        </div>
        
        <div class="mb-3">
          <label for="observacionesAgregar" class="form-label">Observaciones</label>
          <textarea class="form-control" id="observacionesAgregar" name="observaciones" rows="3" maxlength="500"></textarea>
        </div>
      </div>
      
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle"></i> Guardar Mantenimiento
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalEditarMantenimiento" tabindex="-1" aria-labelledby="modalEditarMantenimientoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarMantenimientoLabel">
          <i class="bi bi-pencil-square"></i> Editar Mantenimiento
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form id="formEditarMantenimiento" onsubmit="return validarFormulario(this)">
        <input type="hidden" id="idMantenimientoEditar" name="id_mantenimiento">
        
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="placaEditar" class="form-label">Placa del Vehículo</label>
                <select class="form-select" id="placaEditar" name="placa" required>
                  <option value="">Seleccionar vehículo...</option>
                  <?php foreach($vehiculos as $vehiculo): ?>
                    <option value="<?= $vehiculo['placa'] ?>"><?= htmlspecialchars($vehiculo['display_text']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="tipoMantenimientoEditar" class="form-label">Tipo de Mantenimiento</label>
                <select class="form-select" id="tipoMantenimientoEditar" name="id_tipo_mantenimiento" required>
                  <option value="">Seleccionar tipo...</option>
                  <?php foreach($tipos as $tipo): ?>
                    <option value="<?= $tipo['id_tipo_mantenimiento'] ?>"><?= htmlspecialchars($tipo['descripcion']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="fechaProgramadaEditar" class="form-label">Fecha Programada</label>
                <input type="date" class="form-control" id="fechaProgramadaEditar" name="fecha_programada" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="fechaRealizadaEditar" class="form-label">Fecha Realizada</label>
                <input type="date" class="form-control" id="fechaRealizadaEditar" name="fecha_realizada">
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="kilometrajeActualEditar" class="form-label">Kilometraje Actual</label>
                <input type="number" class="form-control" id="kilometrajeActualEditar" name="kilometraje_actual" min="0" max="999999" maxlength="6">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="proximoCambioKmEditar" class="form-label">Próximo Cambio (Km)</label>
                <input type="number" class="form-control" id="proximoCambioKmEditar" name="proximo_cambio_km" min="0" max="999999" maxlength="6">
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="proximoCambioFechaEditar" class="form-label">Próximo Cambio (Fecha)</label>
                <input type="date" class="form-control" id="proximoCambioFechaEditar" name="proximo_cambio_fecha">
              </div>
            </div>
          </div>
          
          <div class="mb-3">
            <label for="observacionesEditar" class="form-label">Observaciones</label>
            <textarea class="form-control" id="observacionesEditar" name="observaciones" rows="3" maxlength="500"></textarea>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle"></i> Actualizar Mantenimiento
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalVerMantenimiento" tabindex="-1" aria-labelledby="modalVerMantenimientoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalVerMantenimientoLabel">
          <i class="bi bi-eye"></i> Detalles del Mantenimiento
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">ID Mantenimiento:</label>
              <p class="form-control-plaintext" id="verIdMantenimiento"></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Estado:</label>
              <p class="form-control-plaintext" id="verEstado"></p>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Placa del Vehículo:</label>
              <p class="form-control-plaintext" id="verPlaca"></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Tipo de Mantenimiento:</label>
              <p class="form-control-plaintext" id="verTipoMantenimiento"></p>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Fecha Programada:</label>
              <p class="form-control-plaintext" id="verFechaProgramada"></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Fecha Realizada:</label>
              <p class="form-control-plaintext" id="verFechaRealizada"></p>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Kilometraje Actual:</label>
              <p class="form-control-plaintext" id="verKilometrajeActual"></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Próximo Cambio (Km):</label>
              <p class="form-control-plaintext" id="verProximoCambioKm"></p>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Próximo Cambio (Fecha):</label>
              <p class="form-control-plaintext" id="verProximoCambioFecha"></p>
            </div>
          </div>
        </div>
        
        <div class="mb-3">
          <label class="form-label">Observaciones:</label>
          <p class="form-control-plaintext" id="verObservaciones"></p>
        </div>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="bi bi-x-circle"></i> Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalEliminarMantenimiento" tabindex="-1" aria-labelledby="modalEliminarMantenimientoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEliminarMantenimientoLabel">
          <i class="bi bi-exclamation-triangle"></i> Confirmar Eliminación
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <div class="alert alert-danger" role="alert">
          <i class="bi bi-exclamation-triangle"></i>
          <strong>¡Atención!</strong> Esta acción no se puede deshacer.
        </div>
        
        <p>¿Estás seguro de que deseas eliminar este registro de mantenimiento?</p>
        
        <div class="mt-3">
          <strong>Detalles del mantenimiento:</strong>
          <ul class="list-unstyled mt-2">
            <li><strong>Placa:</strong> <span id="placaEliminar"></span></li>
            <li><strong>Tipo:</strong> <span id="tipoEliminar"></span></li>
            <li><strong>Fecha:</strong> <span id="fechaEliminar"></span></li>
          </ul>
        </div>
        
        <input type="hidden" id="idMantenimientoEliminar" name="id_mantenimiento">
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="bi bi-x-circle"></i> Cancelar
        </button>
        <button type="button" class="btn btn-danger" id="confirmarEliminar">
          <i class="bi bi-trash"></i> Eliminar Mantenimiento
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="alertModalLabel">
          <i class="bi bi-info-circle"></i> Información
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <div id="alertContent"></div>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
          <i class="bi bi-check-circle"></i> Entendido
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  // Eliminar cualquier restricción de fecha mínima
document.getElementById('fechaProgr').min = '';
document.getElementById('fechaRealizadaAgregar').min = '';
document.getElementById('proximoCambioFechaAgregar').min = '';

function validarFormulario(form) {
  // Obtener valores del formulario
  const fechaProgramada = form.querySelector('[name="fecha_programada"]').value;
  const fechaRealizada = form.querySelector('[name="fecha_realizada"]').value;
  const fechaProxima = form.querySelector('[name="proximo_cambio_fecha"]').value;
  const kmActual = form.querySelector('[name="kilometraje_actual"]').value;
  const kmProximo = form.querySelector('[name="proximo_cambio_km"]').value;

  // Convertir fechas a formato Date para comparación
  const parseDate = (dateString) => {
    if (!dateString) return null;
    const [day, month, year] = dateString.split('/');
    return new Date(year, month - 1, day);
  };

  const fechaProgDate = parseDate(fechaProgramada);
  const fechaRealDate = parseDate(fechaRealizada);
  const fechaProxDate = parseDate(fechaProxima);
  const hoy = new Date();
  hoy.setHours(0, 0, 0, 0);

  // 1. Validación fecha programada (puede ser cualquier fecha, incluso pasada)
  // No necesita validación específica

  // 2. Validación fecha realizada:
  // - Si existe, debe ser igual o posterior a la programada
  // - No puede ser futura (posterior a hoy)
  if (fechaRealizada) {
    if (fechaRealDate < fechaProgDate) {
      mostrarAlerta('Error', 'La fecha realizada no puede ser anterior a la fecha programada');
      return false;
    }
    if (fechaRealDate > hoy) {
      mostrarAlerta('Error', 'La fecha realizada no puede ser futura');
      return false;
    }
  }

  // 3. Validación kilometraje:
  // - Próximo km debe ser mayor al actual (si ambos existen)
  if (kmActual && kmProximo && parseInt(kmProximo) <= parseInt(kmActual)) {
    mostrarAlerta('Error', 'El kilometraje del próximo cambio debe ser mayor al kilometraje actual');
    return false;
  }

  // 4. Validación próxima fecha de mantenimiento:
  // - Debe ser posterior a la fecha programada
  if (fechaProxima && fechaProxDate <= fechaProgDate) {
    mostrarAlerta('Error', 'La fecha del próximo mantenimiento debe ser posterior a la fecha programada');
    return false;
  }

  return true;
}

function mostrarAlerta(titulo, mensaje) {
  const alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
  document.getElementById('alertModalLabel').textContent = titulo;
  document.getElementById('alertContent').innerHTML = `
    <div class="alert alert-warning">
      <i class="bi bi-exclamation-triangle-fill"></i> ${mensaje}
    </div>
  `;
  alertModal.show();
}
</script>