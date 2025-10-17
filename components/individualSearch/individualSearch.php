<div class="container-fluid">
    <!-- Card de búsqueda -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-indigo-dark text-white text-center">
                    <h5 class="mb-0">Búsqueda por número de identificación</h5>
                </div>
                <div class="card-body">
                    <div class="row w-100">
                        <div class="col-md-12">
                            <div class="input-group justify-content-center">
                                <input type="number" id="searchNumberId" class="form-control text-center" placeholder="Ingresa el número de ID" min="1" required style="font-size: 1.3rem;">
                                <button id="btnBuscar" class="btn bg-indigo-dark text-white" type="button">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card de resultados -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card shadow-lg border-teal-dark" id="resultCard" style="display: none;">
                <div class="card-header d-flex justify-content-between align-items-center bg-teal-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Información del Usuario</h5>
                    <div>
                        <button id="btnConfirmarEntrega" class="btn bg-purple-dark text-white btn-sm me-2" type="button">
                            <i class="fas fa-gift"></i> Confirmar Entrega
                        </button>
                        <button id="btnEditar" class="btn bg-orange-dark text-white btn-sm me-2" type="button">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button id="btnGuardar" class="btn bg-magenta-dark btn-sm" type="button" style="display: none;">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                    </div>
                </div>
                <div class="card-body bg-light">
                    <input type="hidden" id="originalNumberId">
                    <div class="container-fluid">
                        <!-- Primera fila: Número de ID (col-4) y Nombre (col-8) -->
                        <div class="row mb-4 p-2 bg-white rounded shadow-sm">
                            <div class="col-4">
                                <label class="form-label fw-bold text-teal-dark"><i class="fas fa-id-card"></i> Número de ID:</label>
                                <input type="number" id="resultNumberId" class="form-control border-teal-dark" readonly>
                            </div>
                            <div class="col-8">
                                <label class="form-label fw-bold text-teal-dark"><i class="fas fa-user-tag"></i> Nombre:</label>
                                <input type="text" id="resultName" class="form-control border-teal-dark" readonly>
                            </div>
                        </div>
                        <!-- Segunda fila: Celular, Email, Empresa (col-4 cada uno) -->
                        <div class="row mb-4 p-2 bg-white rounded shadow-sm">
                            <div class="col-4">
                                <label class="fw-bold text-teal-dark"><i class="fas fa-phone"></i> Celular:</label>
                                <input type="number" id="resultCellPhone" class="form-control border-teal-dark" readonly maxlength="10" oninput="this.value = this.value.slice(0, 10);">
                            </div>
                            <div class="col-4">
                                <label class="fw-bold text-teal-dark"><i class="fas fa-envelope"></i> Email:</label>
                                <input type="text" id="resultEmail" class="form-control border-teal-dark" readonly>
                            </div>
                            <div class="col-4">
                                <label class="fw-bold text-teal-dark"><i class="fas fa-building"></i> Empresa:</label>
                                <input type="text" id="resultCompany" class="form-control border-teal-dark" readonly>
                            </div>
                        </div>
                        <!-- Tercera fila: Dirección, Ciudad, Género, Fecha de Registro (col-3 cada uno) -->
                        <div class="row mb-4 p-2 bg-white rounded shadow-sm">
                            <div class="col-3">
                                <label class="fw-bold text-teal-dark"><i class="fas fa-map-marker-alt"></i> Dirección:</label>
                                <input type="text" id="resultAddress" class="form-control border-teal-dark" readonly>
                            </div>
                            <div class="col-3">
                                <label class="fw-bold text-teal-dark"><i class="fas fa-city"></i> Ciudad:</label>
                                <input type="text" id="resultCity" class="form-control border-teal-dark" readonly>
                            </div>
                            <div class="col-3">
                                <label class="fw-bold text-teal-dark"><i class="fas fa-venus-mars"></i> Género:</label>
                                <select id="resultGender" class="form-control border-teal-dark" disabled>
                                    <option value="Mujer">Mujer</option>
                                    <option value="Hombre">Hombre</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label class="fw-bold text-teal-dark"><i class="fas fa-calendar-alt"></i> Fecha de Registro:</label>
                                <input type="date" id="resultRegistrationDate" class="form-control border-teal-dark" readonly>
                            </div>
                        </div>
                        <!-- Última fila: Data Update y Updated By centrados (col-4 cada uno) -->
                        <div class="row mb-2 justify-content-center p-2 bg-white rounded shadow-sm">
                            <div class="col-4">
                                <label class="fw-bold text-teal-dark"><i class="fas fa-sync-alt"></i> Se actualizaron los datos:</label>
                                <select id="resultDataUpdate" class="form-control border-teal-dark" disabled>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label class="fw-bold text-teal-dark"><i class="fas fa-user-edit"></i> Actualizado por:</label>
                                <input type="text" id="resultUpdatedBy" class="form-control border-teal-dark" readonly>
                            </div>
                        </div>
                        <!-- Información de entrega (si existe) -->
                        <div id="deliveryInfo" style="display: none;" class="mt-4 p-3 bg-indigo-light rounded shadow-sm text-center">
                            <h6 class="fw-bold text-teal-dark mb-4"><i class="fas fa-gift"></i> Información de Entrega de Regalo</h6>
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <p class="mb-2"><strong>Fecha de entrega:</strong> <span id="deliveryDate"></span></p>
                                <p class="mb-2"><strong>Entregado por:</strong> <span id="deliveredBy"></span></p>
                                <p class="mb-2"><strong>Sede:</strong> <span id="deliverySede"></span></p>
                                <p class="mb-2"><strong>Firma:</strong></p>
                                <img id="deliverySignature" src="" alt="Firma" style="max-width: 250px; max-height: 120px; border: 1px solid #ccc; margin-bottom: 16px;">
                                <div id="recipientInfo" style="display: none;" class="w-100 d-flex flex-column align-items-center">
                                    <p class="mb-2"><strong>Número de documento del receptor:</strong> <span id="recipientNumber"></span></p>
                                    <p class="mb-2"><strong>Nombre del receptor:</strong> <span id="recipientName"></span></p>
                                    <button id="btnShowCarta" class="btn bg-indigo-dark text-white btn-sm mt-2" style="display: none;">Ver Carta de Autorización</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir Signature Pad para firma digital -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>

<script>
    document.getElementById('btnBuscar').addEventListener('click', function() {
        const numberId = document.getElementById('searchNumberId').value.trim();
        if (!numberId || isNaN(numberId)) {
            Swal.fire('Error', 'Ingresa un número de ID válido.', 'error');
            return;
        }

        fetch('components/individualSearch/getData.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'number_id=' + encodeURIComponent(numberId)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Llenar los campos
                    document.getElementById('resultNumberId').value = data.data.number_id;
                    document.getElementById('originalNumberId').value = data.data.number_id; // Guardar original
                    document.getElementById('resultName').value = data.data.name;
                    document.getElementById('resultCompany').value = data.data.company_name;
                    document.getElementById('resultCellPhone').value = data.data.cell_phone;
                    document.getElementById('resultEmail').value = data.data.email;
                    document.getElementById('resultAddress').value = data.data.address;
                    document.getElementById('resultCity').value = data.data.city;
                    document.getElementById('resultRegistrationDate').value = data.data.registration_date;
                    document.getElementById('resultGender').value = data.data.gender;
                    document.getElementById('resultDataUpdate').value = data.data.data_update;
                    document.getElementById('resultUpdatedBy').value = data.data.updated_by || 'N/A'; // Mostrar N/A si vacío
                    // Guardar si tiene entrega
                    window.hasDelivery = data.has_delivery;
                    window.deliveryData = data.delivery;
                    document.getElementById('resultCard').style.display = 'block';
                    // Ocultar botón guardar inicialmente
                    document.getElementById('btnGuardar').style.display = 'none';

                    // Mostrar Swal con datos de entrega si existe
                    if (data.has_delivery) {
                        document.getElementById('deliveryInfo').style.display = 'block';
                        document.getElementById('deliveryDate').textContent = data.delivery.reception_date;
                        document.getElementById('deliveredBy').textContent = data.delivery.delivered_name || data.delivery.delivered_by;
                        document.getElementById('deliverySede').textContent = data.delivery.sede || 'N/A';
                        document.getElementById('deliverySignature').src = 'img/firmasRegalos/' + data.delivery.signature;

                        if (data.delivery.recipient_number_id != data.data.number_id) {
                            document.getElementById('recipientInfo').style.display = 'block';
                            document.getElementById('recipientNumber').textContent = data.delivery.recipient_number_id;
                            // Mostrar el nombre del receptor correctamente
                            document.getElementById('recipientName').textContent = data.delivery.recipient_name || 'No registrado';
                            if (data.delivery.authorization_letter != 'N/A') {
                                document.getElementById('btnShowCarta').style.display = 'inline-block';
                                document.getElementById('btnShowCarta').addEventListener('click', () => {
                                    Swal.fire({
                                        title: 'Carta de Autorización',
                                        html: `<iframe src="uploads/cartasAutorizacion/${data.delivery.authorization_letter}" width="100%" height="400"></iframe>`,
                                        showCloseButton: true,
                                        showConfirmButton: false,
                                        width: '50%'
                                    });
                                });
                            }
                        } else {
                            document.getElementById('recipientInfo').style.display = 'none';
                        }
                    } else {
                        document.getElementById('deliveryInfo').style.display = 'none';
                    }
                } else {
                    Swal.fire('Usuario no encontrado', data.message, 'error');
                    document.getElementById('resultCard').style.display = 'none';
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Error en la solicitud: ' + error.message, 'error');
            });
    });

    // Botón Editar
    document.getElementById('btnEditar').addEventListener('click', function() {
        const inputs = document.querySelectorAll('#resultCard input');
        inputs.forEach(input => {
            input.removeAttribute('readonly');
        });
        const selects = document.querySelectorAll('#resultCard select');
        selects.forEach(select => {
            select.removeAttribute('disabled');
        });
        document.getElementById('btnGuardar').style.display = 'inline-block';
    });

    // Función para validar email
    function isValidEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    // Botón Guardar
    document.getElementById('btnGuardar').addEventListener('click', function() {
        const email = document.getElementById('resultEmail').value.trim();
        if (email && !isValidEmail(email)) {
            Swal.fire('Error', 'Correo electrónico inválido.', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('number_id', document.getElementById('resultNumberId').value);
        formData.append('original_number_id', document.getElementById('originalNumberId').value); // Usar original para WHERE
        formData.append('name', document.getElementById('resultName').value);
        formData.append('company_name', document.getElementById('resultCompany').value);
        formData.append('cell_phone', document.getElementById('resultCellPhone').value);
        formData.append('email', document.getElementById('resultEmail').value);
        formData.append('address', document.getElementById('resultAddress').value);
        formData.append('city', document.getElementById('resultCity').value);
        formData.append('registration_date', document.getElementById('resultRegistrationDate').value);
        formData.append('gender', document.getElementById('resultGender').value);
        formData.append('data_update', document.getElementById('resultDataUpdate').value);
        formData.append('updated_by', document.getElementById('resultUpdatedBy').value);

        fetch('components/individualSearch/updateData.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Éxito', 'Datos actualizados correctamente.', 'success');
                    // Actualizar original con el nuevo si cambió
                    document.getElementById('originalNumberId').value = document.getElementById('resultNumberId').value;
                    // Volver a readonly/disabled
                    const inputs = document.querySelectorAll('#resultCard input');
                    inputs.forEach(input => {
                        input.setAttribute('readonly', true);
                    });
                    const selects = document.querySelectorAll('#resultCard select');
                    selects.forEach(select => {
                        select.setAttribute('disabled', true);
                    });
                    document.getElementById('btnGuardar').style.display = 'none';
                } else {
                    Swal.fire('Error', 'Error al actualizar: ' + data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Error en la solicitud: ' + error.message, 'error');
            });
    });

    // Botón Confirmar Entrega
    document.getElementById('btnConfirmarEntrega').addEventListener('click', function() {
        if (window.hasDelivery) {
            Swal.fire('Entrega ya registrada', 'Esta persona ya cuenta con un regalo entregado en este año.', 'warning');
            return;
        }

        const userNumberId = document.getElementById('resultNumberId').value;
        const userName = document.getElementById('resultName').value;

        Swal.fire({
            title: 'Confirmar Entrega de Regalo',
            html: `
                <div class="container-fluid">
                    <div class="mb-3">
                        <label class="form-label fw-bold">¿La persona que recibe es la misma del registro?</label><br>
                        <input type="radio" id="samePersonYes" name="samePerson" value="yes" checked> <label for="samePersonYes">Sí</label><br>
                        <input type="radio" id="samePersonNo" name="samePerson" value="no"> <label for="samePersonNo">No</label>
                    </div>
                    <div id="additionalFields" style="display: none;">
                        <div class="mb-3">
                            <label for="swalRecipientNumberId" class="form-label">Cédula de quien recibe:</label>
                            <input type="number" id="swalRecipientNumberId" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="swalRecipientName" class="form-label">Nombre de quien recibe:</label>
                            <input type="text" id="swalRecipientName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="swalAuthorizationLetter" class="form-label">Carta de autorización (PDF):</label>
                            <input type="file" id="swalAuthorizationLetter" class="form-control" accept=".pdf" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Firma de recepción:</label>
                        <canvas id="signatureCanvas" width="400" height="200" style="border: 1px solid #ccc;"></canvas>
                        <br><button type="button" id="clearSignature" class="btn btn-secondary btn-sm">Limpiar Firma</button>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Confirmar Entrega',
            cancelButtonText: 'Cancelar',
            didOpen: () => {
                // Inicializar Signature Pad
                const canvas = document.getElementById('signatureCanvas');
                const signaturePad = new SignaturePad(canvas);

                document.getElementById('clearSignature').addEventListener('click', () => {
                    signaturePad.clear();
                });

                // Mostrar/ocultar campos adicionales
                document.getElementById('samePersonYes').addEventListener('change', () => {
                    document.getElementById('additionalFields').style.display = 'none';
                    document.getElementById('swalRecipientNumberId').required = false;
                    document.getElementById('swalRecipientName').required = false;
                    document.getElementById('swalAuthorizationLetter').required = false;
                });
                document.getElementById('samePersonNo').addEventListener('change', () => {
                    document.getElementById('additionalFields').style.display = 'block';
                    document.getElementById('swalRecipientNumberId').required = true;
                    document.getElementById('swalRecipientName').required = true;
                    document.getElementById('swalAuthorizationLetter').required = true;
                });

                // Guardar referencia para usar en preConfirm
                window.signaturePad = signaturePad;
            },
            preConfirm: () => {
                const samePerson = document.querySelector('input[name="samePerson"]:checked').value;
                let recipientNumberId = userNumberId;
                let recipientName = userName;
                let authorizationLetter = 'N/A';

                if (samePerson === 'no') {
                    recipientNumberId = document.getElementById('swalRecipientNumberId').value;
                    recipientName = document.getElementById('swalRecipientName').value;
                    const file = document.getElementById('swalAuthorizationLetter').files[0];
                    if (!file) {
                        Swal.showValidationMessage('Debes seleccionar un archivo PDF');
                        return false;
                    }
                    authorizationLetter = file;
                }

                if (window.signaturePad.isEmpty()) {
                    Swal.showValidationMessage('Debes firmar para confirmar');
                    return false;
                }

                // Dibujar fondo blanco en el canvas
                const ctx = window.signaturePad.canvas.getContext('2d');
                ctx.globalCompositeOperation = 'destination-over';
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, window.signaturePad.canvas.width, window.signaturePad.canvas.height);

                const signatureDataURL = window.signaturePad.toDataURL(); // PNG con fondo blanco

                const formData = new FormData();
                formData.append('user_number_id', userNumberId);
                formData.append('recipient_number_id', recipientNumberId);
                formData.append('recipient_name', recipientName);
                formData.append('signature', signatureDataURL);
                formData.append('authorization_letter', authorizationLetter);

                return fetch('components/individualSearch/confirmDelivery.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json());
            }
        }).then((result) => {
            console.log('Result:', result); // Agrega esto para depurar
            if (result.isConfirmed) {
                const data = result.value;
                console.log('Data:', data); // Agrega esto para depurar
                if (data.success) {
                    Swal.fire('Éxito', 'Entrega confirmada correctamente.', 'success');
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            }
        });
    });
</script>