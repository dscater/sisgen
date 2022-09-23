<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Asistencias</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-lightblue">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 v-html="textoTitulo"></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <div
                                            id="reloj"
                                            v-text="txtHora + ' ' + ampm"
                                        ></div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Ingrese su C.I.*</label>
                                        <el-input
                                            placeholder="Ingrese su C.I."
                                            v-model="txt_ci"
                                            @keypress.enter.native="getTipo"
                                            clearable
                                            maxlength="150"
                                            show-word-limit
                                        >
                                        </el-input>
                                        <small class="info-container">
                                            <span class="info"
                                                >Presione enter para buscar el
                                                registro</span
                                            >
                                        </small>
                                    </div>
                                    <div
                                        class="form-group col-md-12"
                                        v-if="oPersonal != null"
                                    >
                                        <div class="informacion">
                                            <div class="foto">
                                                <b-avatar
                                                    :src="oPersonal.path_image"
                                                    size="6rem"
                                                ></b-avatar>
                                            </div>
                                            <div class="tipo">
                                                {{ oAsistencia.tipo }}
                                            </div>
                                            <div class="nombre">
                                                {{ oPersonal.full_name }}
                                            </div>
                                            <div class="fecha">
                                                {{
                                                    formatoFecha(
                                                        oAsistencia.fecha
                                                    )
                                                }}
                                            </div>
                                            <div class="hora">
                                                {{ oAsistencia.hora }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button
                                            type="button"
                                            class="btn btn-outline-light btn-block"
                                            data-dismiss="modal"
                                            @click="limpiaAsistencia"
                                        >
                                            Reiniciar
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <el-button
                                            type="primary"
                                            class="bg-lightblue w-100"
                                            :loading="enviando"
                                            :disabled="oPersonal == null"
                                            @click="enviarRegistro()"
                                            >{{ textoBoton }}</el-button
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card border-primary">
                            <div class="card-body">
                                <div class="row">
                                    <b-col lg="10" class="my-1">
                                        <b-form-group
                                            label="Buscar"
                                            label-for="filter-input"
                                            label-cols-sm="3"
                                            label-align-sm="right"
                                            label-size="sm"
                                            class="mb-0"
                                        >
                                            <b-input-group size="sm">
                                                <b-form-input
                                                    id="filter-input"
                                                    v-model="filter"
                                                    type="search"
                                                    placeholder="Buscar"
                                                ></b-form-input>

                                                <b-input-group-append>
                                                    <b-button
                                                        class="bg-lightblue"
                                                        :disabled="!filter"
                                                        @click="filter = ''"
                                                        >Borrar</b-button
                                                    >
                                                </b-input-group-append>
                                            </b-input-group>
                                        </b-form-group>
                                    </b-col>
                                    <div class="col-md-12">
                                        <b-overlay
                                            :show="showOverlay"
                                            rounded="sm"
                                        >
                                            <b-table
                                                :fields="fields"
                                                :items="listRegistros"
                                                show-empty
                                                stacked="md"
                                                thead-class="bg-lightblue"
                                                responsive
                                                :current-page="currentPage"
                                                :per-page="perPage"
                                                @filtered="onFiltered"
                                                empty-text="Sin resultados"
                                                empty-filtered-text="Sin resultados"
                                                :filter="filter"
                                            >
                                                <template #cell(fecha)="row">
                                                    {{
                                                        formatoFecha(
                                                            row.item.fecha
                                                        )
                                                    }}
                                                </template>

                                                <template #cell(accion)="row">
                                                    <div
                                                        class="row justify-content-between"
                                                    >
                                                        <!-- <b-button
                                                            size="sm"
                                                            pill
                                                            variant="outline-warning"
                                                            class="btn-flat btn-block"
                                                            title="Editar registro"
                                                            @click="
                                                                editarRegistro(
                                                                    row.item
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-edit"
                                                            ></i>
                                                        </b-button> -->
                                                        <b-button
                                                            size="sm"
                                                            pill
                                                            variant="outline-danger"
                                                            class="btn-flat btn-block"
                                                            title="Eliminar registro"
                                                            @click="
                                                                eliminaAsistencia(
                                                                    row.item.id,
                                                                    row.item
                                                                        .personal
                                                                        .full_name
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-trash"
                                                            ></i>
                                                        </b-button>
                                                    </div>
                                                </template>
                                            </b-table>
                                        </b-overlay>
                                        <div class="row">
                                            <b-col
                                                sm="6"
                                                md="2"
                                                class="ml-auto my-1"
                                            >
                                                <b-form-select
                                                    align="right"
                                                    id="per-page-select"
                                                    v-model="perPage"
                                                    :options="pageOptions"
                                                    size="sm"
                                                ></b-form-select>
                                            </b-col>
                                            <b-col
                                                sm="6"
                                                md="2"
                                                class="my-1 mr-auto"
                                                v-if="perPage"
                                            >
                                                <b-pagination
                                                    v-model="currentPage"
                                                    :total-rows="totalRows"
                                                    :per-page="perPage"
                                                    align="left"
                                                ></b-pagination>
                                            </b-col>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    data() {
        return {
            permisos: localStorage.getItem("permisos"),
            search: "",
            listRegistros: [],
            errors: [],
            showOverlay: false,
            accion: "nuevo",
            enviando: false,
            fields: [
                {
                    key: "personal.full_name",
                    label: "Personal",
                    sortable: true,
                },
                { key: "fecha", label: "Fecha", sortable: true },
                {
                    key: "hora",
                    label: "Hora",
                    sortable: true,
                },
                {
                    key: "tipo",
                    label: "Tipo",
                    sortable: true,
                },
                { key: "accion", label: "Acción" },
            ],
            loading: true,
            fullscreenLoading: true,
            loadingWindow: Loading.service({
                fullscreen: this.fullscreenLoading,
            }),
            oAsistencia: {
                id: 0,
                personal_id: "",
                tipo: "",
                hora: "",
                fecha: "",
            },
            oPersonal: null,
            txt_ci: "",
            currentPage: 1,
            perPage: 5,
            pageOptions: [
                { value: 5, text: "Mostrar 5 Registros" },
                { value: 10, text: "Mostrar 10 Registros" },
                { value: 25, text: "Mostrar 25 Registros" },
                { value: 50, text: "Mostrar 50 Registros" },
                { value: 100, text: "Mostrar 100 Registros" },
                { value: this.totalRows, text: "Mostrar Todo" },
            ],
            totalRows: 10,
            filter: null,
            txtHora: "00:00:00",
            ampm: "am",
            intervalHora: null,
        };
    },
    computed: {
        textoBoton() {
            if (this.accion == "nuevo") {
                return "Registrar";
            } else {
                return "Actualizar";
            }
        },
        textoTitulo() {
            if (this.accion == "nuevo") {
                return "AGREGAR REGISTRO";
            } else {
                let aux = this.oAsistencia.nombre;
                return (
                    "MODIFICAR REGISTRO: <strong>" +
                    this.oAsistencia.id +
                    "</strong>"
                );
            }
        },
    },
    mounted() {
        this.loadingWindow.close();
        this.getAsistencias();
        this.intervalHora = setInterval(this.getHora, 1000);
    },
    methods: {
        // Seleccionar Opciones de Tabla
        editarRegistro(item) {
            this.accion = "edit";
            this.oAsistencia.id = item.id;
            this.oAsistencia.nombre = item.nombre ? item.nombre : "";
            this.oAsistencia.descripcion = item.descripcion
                ? item.descripcion
                : "";
            this.oAsistencia.personal = item.personal ? item.personal : "";
            this.oAsistencia.estado = item.estado ? item.estado : "";
        },

        // Listar Asistencias
        getAsistencias() {
            this.showOverlay = true;
            let url = "/admin/asistencias";
            if (this.pagina != 0) {
                url += "?page=" + this.pagina;
            }
            axios
                .get(url, {
                    params: { per_page: this.per_page },
                })
                .then((res) => {
                    this.showOverlay = false;
                    this.listRegistros = res.data.asistencias;
                    this.totalRows = res.data.total;
                });
        },
        // buscar Tipo Asistencia
        getTipo() {
            axios
                .get("/admin/asistencias/getTipo", {
                    params: { ci: this.txt_ci },
                })
                .then((response) => {
                    if (response.data.sw) {
                        this.oPersonal = response.data.personal;
                        this.oAsistencia.personal_id = this.oPersonal.id;
                        this.oAsistencia.tipo = response.data.tipo;
                        this.oAsistencia.hora = this.txtHora;
                        this.oAsistencia.fecha = response.data.fecha;
                    } else {
                        this.oPersonal = null;
                        Swal.fire({
                            icon: "error",
                            title: "No se encontró ningún registro con ese C.I.",
                            text: "Intente nuevamente por favor",
                            showConfirmButton: true,
                            confirmButtonColor: "#05568e",
                            confirmButtonText: "Cerrar",
                        });
                    }
                });
        },
        // Enviar Registro
        enviarRegistro() {
            this.enviando = true;
            try {
                this.textoBtn = "Enviando...";
                let url = "/admin/asistencias";
                let config = {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                };
                let formdata = new FormData();

                formdata.append(
                    "personal_id",
                    this.oAsistencia.personal_id
                        ? this.oAsistencia.personal_id
                        : ""
                );
                formdata.append(
                    "tipo",
                    this.oAsistencia.tipo ? this.oAsistencia.tipo : ""
                );
                formdata.append(
                    "hora",
                    this.oAsistencia.hora ? this.oAsistencia.hora : ""
                );
                formdata.append(
                    "fecha",
                    this.oAsistencia.fecha ? this.oAsistencia.fecha : ""
                );
                if (this.accion == "edit") {
                    url = "/admin/asistencias/" + this.oAsistencia.id;
                    formdata.append("_method", "PUT");
                }
                axios
                    .post(url, formdata, config)
                    .then((res) => {
                        this.enviando = false;
                        Swal.fire({
                            icon: "success",
                            title: res.data.msj,
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        this.limpiaAsistencia();
                        this.getAsistencias();
                        this.errors = [];
                        if (this.accion == "edit") {
                            this.textoBtn = "Actualizar";
                        } else {
                            this.textoBtn = "Registrar";
                        }
                    })
                    .catch((error) => {
                        this.enviando = false;
                        if (this.accion == "edit") {
                            this.textoBtn = "Actualizar";
                        } else {
                            this.textoBtn = "Registrar";
                        }
                        if (error.response) {
                            if (error.response.status === 422) {
                                this.errors = error.response.data.errors;
                            }
                        }
                    });
            } catch (e) {
                this.enviando = false;
                console.log(e);
            }
        },
        eliminaAsistencia(id, descripcion) {
            Swal.fire({
                title: "¿Quierés eliminar este registro?",
                html: `<strong>${descripcion}</strong>`,
                showCancelButton: true,
                confirmButtonColor: "#05568e",
                confirmButtonText: "Si, eliminar",
                cancelButtonText: "No, cancelar",
                denyButtonText: `No, cancelar`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    axios
                        .post("/admin/asistencias/" + id, {
                            _method: "DELETE",
                        })
                        .then((res) => {
                            this.getAsistencias();
                            this.filter = "";
                            Swal.fire({
                                icon: "success",
                                title: res.data.msj,
                                showConfirmButton: false,
                                timer: 1500,
                            });
                        });
                }
            });
        },
        abreModal(tipo_accion = "nuevo", asistencia = null) {
            if (asistencia) {
                this.oAsistencia = asistencia;
            }
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        limpiaAsistencia() {
            this.oAsistencia.id = 0;
            this.oAsistencia.personal_id = "";
            this.oAsistencia.tipo = "";
            this.oAsistencia.hora = "";
            this.oAsistencia.fecha = "";
            this.oPersonal = null;
            this.txt_ci = "";
        },
        formatoFecha(date) {
            return this.$moment(String(date)).format("DD [de] MMMM [del] YYYY");
        },
        getHora() {
            let momentoActual = new Date();
            let hora = momentoActual.getHours();
            let min = momentoActual.getMinutes();
            let seg = momentoActual.getSeconds();
            this.ampm = hora >= 12 ? "pm" : "am";
            this.txtHora = `${hora < 10 ? "0" + hora : hora}:${
                min < 10 ? "0" + min : min
            }:${seg < 10 ? "0" + seg : seg}`;
        },
    },
};
</script>

<style>
#reloj {
    background: var(--principal);
    color: white;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 2rem;
}

.informacion {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.informacion .tipo {
    font-weight: bold;
}
</style>
