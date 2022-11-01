<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Personal</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-3">
                                        <button
                                            v-if="
                                                permisos.includes(
                                                    'personals.create'
                                                )
                                            "
                                            class="btn btn-outline-primary bg-lightblue btn-flat btn-block"
                                            @click="
                                                abreModal('nuevo');
                                                limpiaPersonal();
                                            "
                                        >
                                            <i class="fa fa-plus"></i>
                                            Nuevo
                                        </button>
                                    </div>
                                </div>
                            </div>
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
                                                        variant="primary"
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
                                                responsive
                                                :current-page="currentPage"
                                                :per-page="perPage"
                                                @filtered="onFiltered"
                                                empty-text="Sin resultados"
                                                empty-filtered-text="Sin resultados"
                                                :filter="filter"
                                            >
                                                <template #cell(foto)="row">
                                                    <b-avatar
                                                        :src="
                                                            row.item.path_image
                                                        "
                                                        size="3rem"
                                                    ></b-avatar>
                                                </template>
                                                <template #cell(estado)="row">
                                                    <b-badge
                                                        variant="success"
                                                        v-if="
                                                            row.item.estado ==
                                                            'ACTIVO'
                                                        "
                                                        >{{
                                                            row.item.estado
                                                        }}</b-badge
                                                    >
                                                    <b-badge
                                                        variant="danger"
                                                        v-else
                                                        >{{
                                                            row.item.estado
                                                        }}</b-badge
                                                    >
                                                </template>
                                                <template
                                                    #cell(fecha_registro)="row"
                                                >
                                                    {{
                                                        formatoFecha(
                                                            row.item
                                                                .fecha_registro
                                                        )
                                                    }}
                                                </template>
                                                <template #cell(detalles)="row">
                                                    <b-button
                                                        variant="primary"
                                                        size="sm"
                                                        @click="
                                                            row.toggleDetails
                                                        "
                                                    >
                                                        {{
                                                            row.detailsShowing
                                                                ? "Ocultar"
                                                                : "Mostrar"
                                                        }}
                                                        Detalles
                                                    </b-button>
                                                </template>

                                                <template #row-details="row">
                                                    <b-card>
                                                        <b-row class="mb-2">
                                                            <b-col
                                                                sm="3"
                                                                class="text-sm-right"
                                                                ><b
                                                                    >Fecha de
                                                                    nacimiento:</b
                                                                ></b-col
                                                            >
                                                            <b-col>{{
                                                                row.item
                                                                    .fecha_nacimiento
                                                                    ? formatoFecha(
                                                                          row
                                                                              .item
                                                                              .fecha_nacimiento
                                                                      )
                                                                    : "S/D"
                                                            }}</b-col>
                                                        </b-row>
                                                        <b-row class="mb-2">
                                                            <b-col
                                                                sm="3"
                                                                class="text-sm-right"
                                                                ><b
                                                                    >Estatura:</b
                                                                ></b-col
                                                            >
                                                            <b-col>{{
                                                                row.item
                                                                    .estatura
                                                                    ? row.item
                                                                          .estatura +
                                                                      " m"
                                                                    : "S/D"
                                                            }}</b-col>
                                                        </b-row>
                                                        <b-row class="mb-2">
                                                            <b-col
                                                                sm="3"
                                                                class="text-sm-right"
                                                                ><b
                                                                    >Peso:</b
                                                                ></b-col
                                                            >
                                                            <b-col>{{
                                                                row.item.peso
                                                                    ? row.item
                                                                          .peso +
                                                                      "KG"
                                                                    : "S/D"
                                                            }}</b-col>
                                                        </b-row>
                                                        <b-row class="mb-2">
                                                            <b-col
                                                                sm="3"
                                                                class="text-sm-right"
                                                                ><b
                                                                    >Nacionalidad:</b
                                                                ></b-col
                                                            >
                                                            <b-col>{{
                                                                row.item
                                                                    .nacionalidad
                                                                    ? row.item
                                                                          .nacionalidad
                                                                    : "S/D"
                                                            }}</b-col>
                                                        </b-row>
                                                        <b-row class="mb-2">
                                                            <b-col
                                                                sm="3"
                                                                class="text-sm-right"
                                                                ><b
                                                                    >Habilidad:</b
                                                                ></b-col
                                                            >
                                                            <b-col>{{
                                                                row.item
                                                                    .habilidad
                                                                    ? row.item
                                                                          .habilidad
                                                                    : "S/D"
                                                            }}</b-col>
                                                        </b-row>

                                                        <b-button
                                                            size="sm"
                                                            variant="primary"
                                                            @click="
                                                                row.toggleDetails
                                                            "
                                                            >Ocultar</b-button
                                                        >
                                                    </b-card>
                                                </template>

                                                <template #cell(accion)="row">
                                                    <div
                                                        class="row justify-content-between"
                                                    >
                                                        <b-button
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
                                                        </b-button>
                                                        <b-button
                                                            size="sm"
                                                            pill
                                                            variant="outline-danger"
                                                            class="btn-flat btn-block"
                                                            title="Eliminar registro"
                                                            @click="
                                                                eliminaPersonal(
                                                                    row.item.id,
                                                                    row.item
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
        <Nuevo
            :muestra_modal="muestra_modal"
            :accion="modal_accion"
            :personal="oPersonal"
            @close="muestra_modal = false"
            @envioModal="getPersonals"
        ></Nuevo>
    </div>
</template>

<script>
import Nuevo from "./Nuevo.vue";
export default {
    components: {
        Nuevo,
    },
    data() {
        return {
            permisos: localStorage.getItem("permisos"),
            search: "",
            listRegistros: [],
            showOverlay: false,
            fields: [
                { key: "full_name", label: "Nombre", sortable: true },
                {
                    key: "full_ci",
                    label: "C.I.",
                    sortable: true,
                },
                {
                    key: "tipo",
                    label: "Tipo",
                    sortable: true,
                },
                {
                    key: "dir",
                    label: "Dirección",
                    sortable: true,
                },
                {
                    key: "correo",
                    label: "Correo",
                    sortable: true,
                },
                {
                    key: "cel",
                    label: "Celular",
                    sortable: true,
                },
                {
                    key: "fono",
                    label: "Teléfono",
                    sortable: true,
                },
                { key: "foto", label: "Foto" },
                {
                    key: "estado",
                    label: "Estado",
                    sortable: true,
                },
                {
                    key: "fecha_registro",
                    label: "Fecha de registro",
                    sortable: true,
                },
                { key: "detalles", label: "Detalles" },
                { key: "accion", label: "Acción" },
            ],
            loading: true,
            fullscreenLoading: true,
            loadingWindow: Loading.service({
                fullscreen: this.fullscreenLoading,
            }),
            muestra_modal: false,
            modal_accion: "nuevo",
            oPersonal: {
                id: 0,
                nombre: "",
                paterno: "",
                materno: "",
                ci: "",
                ci_exp: "",
                fecha_nacimiento: "",
                estatura: "",
                peso: "",
                nacionalidad: "",
                dir: "",
                correo: "",
                fono: "",
                cel: "",
                tipo: "GUARDIA",
                puntuacion_habilidad: "",
                habilidad: "",
                estado: "INACTIVO",
                foto: null,
            },
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
        };
    },
    mounted() {
        this.loadingWindow.close();
        this.getPersonals();
    },
    methods: {
        // Seleccionar Opciones de Tabla
        editarRegistro(item) {
            this.oPersonal.id = item.id;
            this.oPersonal.nombre = item.nombre ? item.nombre : "";
            this.oPersonal.paterno = item.paterno ? item.paterno : "";
            this.oPersonal.materno = item.materno ? item.materno : "";
            this.oPersonal.ci = item.ci ? item.ci : "";
            this.oPersonal.ci_exp = item.ci_exp ? item.ci_exp : "";
            this.oPersonal.fecha_nacimiento = item.fecha_nacimiento
                ? item.fecha_nacimiento
                : "";
            this.oPersonal.estatura = item.estatura ? item.estatura : "";
            this.oPersonal.peso = item.peso ? item.peso : "";
            this.oPersonal.nacionalidad = item.nacionalidad
                ? item.nacionalidad
                : "";
            this.oPersonal.dir = item.dir ? item.dir : "";
            this.oPersonal.correo = item.correo ? item.correo : "";
            this.oPersonal.fono = item.fono ? item.fono : "";
            this.oPersonal.cel = item.cel ? item.cel : "";
            this.oPersonal.tipo = item.tipo ? item.tipo : "";
            this.oPersonal.puntuacion_habilidad = item.puntuacion_habilidad
                ? item.puntuacion_habilidad
                : "";
            this.oPersonal.habilidad = item.habilidad ? item.habilidad : "";
            this.oPersonal.estado = item.estado ? item.estado : "";
            this.modal_accion = "edit";
            this.muestra_modal = true;
        },

        // Listar Personals
        getPersonals() {
            this.showOverlay = true;
            this.muestra_modal = false;
            let url = "/admin/personals";
            if (this.pagina != 0) {
                url += "?page=" + this.pagina;
            }
            axios
                .get(url, {
                    params: { per_page: this.per_page },
                })
                .then((res) => {
                    this.showOverlay = false;
                    this.listRegistros = res.data.personals;
                    this.totalRows = res.data.total;
                });
        },
        eliminaPersonal(id, descripcion) {
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
                        .post("/admin/personals/" + id, {
                            _method: "DELETE",
                        })
                        .then((res) => {
                            if (res.data.sw) {
                                this.getPersonals();
                                this.filter = "";
                                Swal.fire({
                                    icon: "success",
                                    title: res.data.msj,
                                    showConfirmButton: false,
                                    timer: 1500,
                                });
                            } else {
                                Swal.fire({
                                    icon: "info",
                                    title: res.data.msj,
                                    showConfirmButton: false,
                                    timer: 2500,
                                });
                            }
                        });
                }
            });
        },
        abreModal(tipo_accion = "nuevo", personal = null) {
            this.muestra_modal = true;
            this.modal_accion = tipo_accion;
            if (personal) {
                this.oPersonal = personal;
            }
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        limpiaPersonal() {
            this.errors = [];
            this.oPersonal.nombre = "";
            this.oPersonal.paterno = "";
            this.oPersonal.materno = "";
            this.oPersonal.ci = "";
            this.oPersonal.ci_exp = "";
            this.oPersonal.fecha_nacimiento = "";
            this.oPersonal.estatura = "";
            this.oPersonal.peso = "";
            this.oPersonal.nacionalidad = "";
            this.oPersonal.dir = "";
            this.oPersonal.correo = "";
            this.oPersonal.fono = "";
            this.oPersonal.cel = "";
            this.oPersonal.tipo = "GUARDIA";
            this.oPersonal.puntuacion_habilidad = "1";
            this.oPersonal.habilidad = "";
            this.oPersonal.estado = "INACTIVO";
            this.oPersonal.foto = null;
        },
        formatoFecha(date) {
            return this.$moment(String(date)).format("DD [de] MMMM [del] YYYY");
        },
    },
};
</script>

<style></style>
