<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Puestos de vigilancia</h1>
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
                                        <label
                                            :class="{
                                                'text-danger': errors.nombre,
                                            }"
                                            >Nombre*</label
                                        >
                                        <el-input
                                            placeholder="Nombre"
                                            :class="{
                                                'is-invalid': errors.nombre,
                                            }"
                                            v-model="oPuestoVigilancia.nombre"
                                            @keypress.enter.native="
                                                enviarRegistro
                                            "
                                            clearable
                                            maxlength="150"
                                            show-word-limit
                                        >
                                        </el-input>
                                        <span
                                            class="error invalid-feedback"
                                            v-if="errors.nombre"
                                            v-text="errors.nombre[0]"
                                        ></span>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label
                                            :class="{
                                                'text-danger':
                                                    errors.descripcion,
                                            }"
                                            >Descripción</label
                                        >
                                        <el-input
                                            type="textarea"
                                            maxlength="250"
                                            show-word-limit
                                            placeholder="Descripción"
                                            :class="{
                                                'is-invalid':
                                                    errors.descripcion,
                                            }"
                                            v-model="
                                                oPuestoVigilancia.descripcion
                                            "
                                            @keypress.enter.native="
                                                enviarRegistro
                                            "
                                            :autosize="{
                                                minRows: 2,
                                                maxRows: 4,
                                            }"
                                            clearable
                                        >
                                        </el-input>
                                        <span
                                            class="error invalid-feedback"
                                            v-if="errors.descripcion"
                                            v-text="errors.descripcion[0]"
                                        ></span>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label
                                            :class="{
                                                'text-danger': errors.personal,
                                            }"
                                            >Requerimiento de Personal*</label
                                        >
                                        <el-input-number
                                            placeholder="Requerimiento de Personal"
                                            v-model="oPuestoVigilancia.personal"
                                            controls-position="right"
                                            class="w-full"
                                            :min="1"
                                            :step="1"
                                            :class="{
                                                'is-invalid': errors.personal,
                                            }"
                                            @change.native="getNivel($event)"
                                            @keyup.native="getNivel($event)"
                                        ></el-input-number>
                                        <span
                                            class="error invalid-feedback"
                                            v-if="errors.personal"
                                            v-text="errors.personal[0]"
                                        ></span>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label
                                            :class="{
                                                'text-danger': errors.nivel,
                                            }"
                                            >Nivel*</label
                                        >
                                        <el-input
                                            class="w-100 d-block"
                                            :class="{
                                                'is-invalid': errors.nivel,
                                            }"
                                            v-model="oPuestoVigilancia.nivel"
                                            readonly
                                        >
                                            <el-option
                                                v-for="(
                                                    item, index
                                                ) in listNiveles"
                                                :key="index"
                                                :value="item"
                                                :label="item"
                                            >
                                            </el-option>
                                        </el-input>
                                        <span
                                            class="error invalid-feedback"
                                            v-if="errors.nivel"
                                            v-text="errors.nivel[0]"
                                        ></span>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label
                                            :class="{
                                                'text-danger': errors.nivel,
                                            }"
                                            >Propietario*</label
                                        >
                                        <el-input
                                            class="w-100 d-block"
                                            :class="{
                                                'is-invalid': errors.propietario,
                                            }"
                                            v-model="oPuestoVigilancia.propietario"
                                        >
                                            <el-option
                                                v-for="(
                                                    item, index
                                                ) in listNiveles"
                                                :key="index"
                                                :value="item"
                                                :label="item"
                                            >
                                            </el-option>
                                        </el-input>
                                        <span
                                            class="error invalid-feedback"
                                            v-if="errors.propietario"
                                            v-text="errors.propietario[0]"
                                        ></span>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label
                                            :class="{
                                                'text-danger': errors.estado,
                                            }"
                                            >Estado*</label
                                        >
                                        <el-switch
                                            :class="{
                                                'is-invalid': errors.estado,
                                            }"
                                            style="display: block"
                                            v-model="oPuestoVigilancia.estado"
                                            active-color="#13ce66"
                                            inactive-color="#ff4949"
                                            active-text="ACTIVO"
                                            inactive-text="INACTIVO"
                                            active-value="ACTIVO"
                                            inactive-value="INACTIVO"
                                        >
                                            >
                                        </el-switch>
                                        <span
                                            class="error invalid-feedback"
                                            v-if="errors.estado"
                                            v-text="errors.estado[0]"
                                        ></span>
                                    </div>
                                    <div class="col-md-6">
                                        <button
                                            type="button"
                                            class="btn btn-outline-light btn-block"
                                            data-dismiss="modal"
                                            @click="limpiaPuestoVigilancia"
                                        >
                                            Reiniciar
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <el-button
                                            type="primary"
                                            class="bg-lightblue w-100"
                                            :loading="enviando"
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
                                                                eliminaPuestoVigilancia(
                                                                    row.item.id,
                                                                    row.item
                                                                        .nombre
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
                    key: "nombre",
                    label: "Nombre",
                    sortable: true,
                },
                { key: "descripcion", label: "Descripción", sortable: true },
                {
                    key: "personal",
                    label: "Requerimiento de Personal",
                    sortable: true,
                },
                {
                    key: "nivel",
                    label: "Nivel",
                    sortable: true,
                },
                {
                    key: "propietario",
                    label: "Propietario",
                    sortable: true,
                },
                {
                    key: "estado",
                    label: "Estado",
                    sortable: true,
                },
                {
                    key: "fecha_registro",
                    label: "Fecha de Registro",
                    sortable: true,
                },
                { key: "accion", label: "Acción" },
            ],
            loading: true,
            fullscreenLoading: true,
            loadingWindow: Loading.service({
                fullscreen: this.fullscreenLoading,
            }),
            oPuestoVigilancia: {
                id: 0,
                nombre: "",
                descripcion: "",
                personal: "",
                nivel: "BASICO",
                propietario: "",
                estado: "INACTIVO",
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
            listNiveles: ["ALTO", "MEDIO", "BASICO"],
            totalRows: 10,
            filter: null,
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
                let aux = this.oPuestoVigilancia.nombre;
                return (
                    "MODIFICAR REGISTRO: <strong>" +
                    this.oPuestoVigilancia.id +
                    "</strong>"
                );
            }
        },
    },
    mounted() {
        this.loadingWindow.close();
        this.getPuestoVigilancias();
    },
    methods: {
        // Seleccionar Opciones de Tabla
        editarRegistro(item) {
            this.accion = "edit";
            this.oPuestoVigilancia.id = item.id;
            this.oPuestoVigilancia.nombre = item.nombre ? item.nombre : "";
            this.oPuestoVigilancia.descripcion = item.descripcion
                ? item.descripcion
                : "";
            this.oPuestoVigilancia.personal = item.personal
                ? item.personal
                : "";
            this.oPuestoVigilancia.nivel = item.nivel ? item.nivel : "";
            this.oPuestoVigilancia.propietario = item.propietario
                ? item.propietario
                : "";
            this.oPuestoVigilancia.estado = item.estado ? item.estado : "";
        },

        // Listar PuestoVigilancias
        getPuestoVigilancias() {
            this.showOverlay = true;
            let url = "/admin/puesto_vigilancias";
            if (this.pagina != 0) {
                url += "?page=" + this.pagina;
            }
            axios
                .get(url, {
                    params: { per_page: this.per_page },
                })
                .then((res) => {
                    this.showOverlay = false;
                    this.listRegistros = res.data.puesto_vigilancias;
                    this.totalRows = res.data.total;
                });
        },
        enviarRegistro() {
            this.enviando = true;
            try {
                this.textoBtn = "Enviando...";
                let url = "/admin/puesto_vigilancias";
                let config = {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                };
                let formdata = new FormData();

                formdata.append(
                    "nombre",
                    this.oPuestoVigilancia.nombre
                        ? this.oPuestoVigilancia.nombre
                        : ""
                );
                formdata.append(
                    "descripcion",
                    this.oPuestoVigilancia.descripcion
                        ? this.oPuestoVigilancia.descripcion
                        : ""
                );
                formdata.append(
                    "personal",
                    this.oPuestoVigilancia.personal
                        ? this.oPuestoVigilancia.personal
                        : ""
                );
                formdata.append(
                    "nivel",
                    this.oPuestoVigilancia.nivel
                        ? this.oPuestoVigilancia.nivel
                        : ""
                );
                formdata.append(
                    "propietario",
                    this.oPuestoVigilancia.propietario
                        ? this.oPuestoVigilancia.propietario
                        : ""
                );
                formdata.append(
                    "estado",
                    this.oPuestoVigilancia.estado
                        ? this.oPuestoVigilancia.estado
                        : ""
                );
                if (this.accion == "edit") {
                    url =
                        "/admin/puesto_vigilancias/" +
                        this.oPuestoVigilancia.id;
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
                        this.limpiaPuestoVigilancia();
                        this.getPuestoVigilancias();
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
        eliminaPuestoVigilancia(id, descripcion) {
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
                        .post("/admin/puesto_vigilancias/" + id, {
                            _method: "DELETE",
                        })
                        .then((res) => {
                            this.getPuestoVigilancias();
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
        abreModal(tipo_accion = "nuevo", puesto_vigilancia = null) {
            if (puesto_vigilancia) {
                this.oPuestoVigilancia = puesto_vigilancia;
            }
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        limpiaPuestoVigilancia() {
            this.oPuestoVigilancia.nombre = "";
            this.oPuestoVigilancia.descripcion = "";
            this.oPuestoVigilancia.personal = "";
            this.oPuestoVigilancia.estado = "INACTIVO";
            this.oPuestoVigilancia.nivel = "";
            this.oPuestoVigilancia.propietario = "";
            this.accion = "nuevo";
        },
        formatoFecha(date) {
            return this.$moment(String(date)).format("DD [de] MMMM [del] YYYY");
        },
        getNivel(e) {
            let personal = parseInt(e.target.value);
            let nivel = "ALTO";
            console.log(personal);
            if (personal) {
                if (personal <= 6) {
                    nivel = "BASICO";
                } else if (personal <= 12) {
                    nivel = "MEDIO";
                }
            } else {
                nivel = "BASICO";
            }
            this.oPuestoVigilancia.nivel = nivel;
        },
    },
};
</script>

<style></style>
