<?php

/**
 * ============================================
 * Barra superior y navegación principal (header.php)
 * ============================================
 * Este componente muestra la barra superior fija del dashboard.
 * Incluye el logo, menú principal, accesos rápidos, perfil del usuario y botones flotantes.
 * Las opciones del menú y los accesos dependen del rol del usuario logueado.
 * 
 * - Los roles controlan el acceso a cada funcionalidad (Administrador, Control maestro, Empleabilidad, Permanencia, Académico, etc).
 * - Se integra con los componentes de barra lateral y correo flotante.
 * - Incluye menús desplegables para informes, PQRS, periodos, aulas y perfil.
 * - Permite la descarga de informes con control de tiempo y feedback visual.
 * - El diseño es responsivo y utiliza Bootstrap.
 */

$rol = $infoUsuario['rol']; // Obtener el rol del usuario
$extraRol = $infoUsuario['extra_rol']; // Obtener el extra_rol del usuario

include 'components/importBase/importSwal.php'; 

?>

<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
    <div class="container-fluid">
        <button class="btn btn-tertiary mr-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptionsLabel">
            <i class="bi bi-list"></i>
        </button>
        <a class="navbar-brand" href="#"><img src="img/gf_header.png" alt="logo" width="120px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="main.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="btnAgregarSede">Sedes</a>
                </li>
            </ul>
        </div>

        <button id="btnSubirBase" class="btn bg-magenta-dark me-2 text-white" type="button">
            <i class="bi bi-cloud-upload me-1"></i>Subir base
        </button>

        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?php echo htmlspecialchars($infoUsuario['foto']); ?>" alt="Perfil" class="rounded-circle" width="40" height="40">
                <?php echo htmlspecialchars($infoUsuario['nombre']); ?>
                <div class="spinner-grow spinner-grow-sm" role="status" style="color:#00976a">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <button type="button" class="btn" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="<?php echo htmlspecialchars($infoUsuario['rol']); ?>" data-bs-trigger="hover">
                    <i class="bi bi-info-circle-fill colorVerde" style="color: #00976a;"></i>
                </button>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="profile.php">Perfil</a></li>
                <li><a class="dropdown-item" href="close.php">Cerrar sesión</a></li>
            </ul>
        </div> <!-- Cierre del dropdown -->

    </div> <!-- Cierre del container-fluid -->
</nav>

<!-- Incluir SweetAlert2 si no está ya incluido -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('btnAgregarSede').addEventListener('click', function(event) {
        event.preventDefault(); // Prevenir navegación del enlace
        Swal.fire({
            title: '¿Qué deseas hacer?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Agregar Nueva Sede',
            confirmButtonColor: '#ec008c',
            denyButtonText: 'Gestionar Sedes Existentes',
            denyButtonColor: '#007a7a',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Agregar nueva sede
                Swal.fire({
                    title: 'Agregar Nueva Sede',
                    input: 'text',
                    inputLabel: 'Nombre de la Sede',
                    inputPlaceholder: 'Ingresa el nombre de la sede',
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    cancelButtonText: 'Cancelar',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'El nombre no puede estar vacío!';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('controller/guardar_sede.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: 'nombre_sede=' + encodeURIComponent(result.value)
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('¡Éxito!', data.message, 'success');
                                } else {
                                    Swal.fire('Error', data.message, 'error');
                                }
                            })
                            .catch(error => {
                                Swal.fire('Error', 'Hubo un problema al guardar.', 'error');
                            });
                    }
                });
            } else if (result.isDenied) {
                // Gestionar sedes existentes
                fetch('controller/obtener_sedes.php')
                    .then(response => response.json())
                    .then(sedes => {
                        if (sedes.length === 0) {
                            Swal.fire('Sin Sedes', 'No hay sedes registradas.', 'info');
                            return;
                        }
                        let html = '<div style="max-height: 400px; overflow-y: auto;"><table class="table table-striped table-hover table-bordered"><thead><tr><th>Nombre de Sede</th><th>Fecha de Creación</th><th>Creado por</th><th>Acciones</th></tr></thead><tbody>';
                        sedes.forEach(sede => {
                            html += `<tr><td>${sede.nombre}</td><td>${sede.fecha_creacion}</td><td>${sede.nombre_creador}</td><td><button class="btn btn-danger btn-sm" onclick="eliminarSede(${sede.id})">Eliminar</button></td></tr>`;
                        });
                        html += '</tbody></table></div>';
                        Swal.fire({
                            title: 'Gestionar Sedes Existentes',
                            html: html,
                            showCancelButton: true,
                            cancelButtonText: 'Cerrar',
                            width: '75%' // Aumentado para más ancho
                        });
                    })
                    .catch(error => {
                        Swal.fire('Error', 'No se pudieron cargar las sedes.', 'error');
                    });
            }
        });
    });

    // Funciones básicas para editar/eliminar (implementa en archivos PHP separados si es necesario)
    function editarSede(id) {
        Swal.fire('Editar', 'Funcionalidad de edición no implementada aún. ID: ' + id, 'info');
    }

    function eliminarSede(id) {
        Swal.fire({
            title: '¿Eliminar sede?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('controller/eliminar_sede.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'id_sede=' + id
                    })
                    .then(response => response.json())
                    .then((data) => {
                        if (data.success) {
                            Swal.fire('¡Eliminado!', data.message, 'success').then(() => {
                                // Opcional: Recargar la tabla o cerrar el SWAL
                                location.reload(); // Recarga la página para actualizar la vista
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'Hubo un problema al eliminar.', 'error');
                    });
            }
        });
    }
</script>