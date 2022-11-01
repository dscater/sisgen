<template>
    <div
        class="modal fade"
        :class="{ show: bModal }"
        id="modal-default"
        aria-modal="true"
        role="dialog"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-lightblue">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                        @click="cierraModal"
                    >
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form style="overflow: auto">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.nombre,
                                    }"
                                    >Nombre*</label
                                >
                                <el-input
                                    placeholder="Nombre"
                                    :class="{ 'is-invalid': errors.nombre }"
                                    v-model="personal.nombre"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.nombre"
                                    v-text="errors.nombre[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.paterno,
                                    }"
                                    >Ap. Paterno*</label
                                >

                                <el-input
                                    placeholder="Ap. Paterno"
                                    :class="{ 'is-invalid': errors.paterno }"
                                    v-model="personal.paterno"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.paterno"
                                    v-text="errors.paterno[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.materno,
                                    }"
                                    >Ap. Materno</label
                                >
                                <el-input
                                    placeholder="Ap. Materno"
                                    :class="{ 'is-invalid': errors.materno }"
                                    v-model="personal.materno"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.materno"
                                    v-text="errors.materno[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label
                                    :class="{
                                        'text-danger': errors.ci,
                                    }"
                                    >C.I.*</label
                                >
                                <el-input
                                    placeholder="Número de C.I."
                                    :class="{ 'is-invalid': errors.ci }"
                                    v-model="personal.ci"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.ci"
                                    v-text="errors.ci[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-2">
                                <label
                                    :class="{
                                        'text-danger': errors.ci_exp,
                                    }"
                                    >Expedido*</label
                                >
                                <el-select
                                    class="w-100 d-block"
                                    :class="{
                                        'is-invalid': errors.ci_exp,
                                    }"
                                    v-model="personal.ci_exp"
                                    clearable
                                >
                                    <el-option
                                        v-for="(item, index) in listExpedido"
                                        :key="index"
                                        :value="item.value"
                                        :label="item.label"
                                    >
                                    </el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.ci_exp"
                                    v-text="errors.ci_exp[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.fecha_nacimiento,
                                    }"
                                    >Fecha de nacimiento*</label
                                >
                                <input
                                    type="date"
                                    v-model="personal.fecha_nacimiento"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': errors.fecha_nacimiento,
                                    }"
                                />
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.fecha_nacimiento"
                                    v-text="errors.dir[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-3">
                                <label
                                    :class="{
                                        'text-danger': errors.estatura,
                                    }"
                                    >Estatura (m)*</label
                                >
                                <el-input-number
                                    placeholder="Estatura"
                                    v-model="personal.estatura"
                                    controls-position="right"
                                    :min="1"
                                    :max="3"
                                    :step="0.01"
                                    :class="{
                                        'is-invalid': errors.estatura,
                                    }"
                                ></el-input-number>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.estatura"
                                    v-text="errors.dir[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-3">
                                <label
                                    :class="{
                                        'text-danger': errors.peso,
                                    }"
                                    >Peso (kg)*</label
                                >
                                <el-input-number
                                    placeholder="Peso"
                                    v-model="personal.peso"
                                    controls-position="right"
                                    :min="40"
                                    :max="200"
                                    :step="0.01"
                                    :class="{
                                        'is-invalid': errors.peso,
                                    }"
                                ></el-input-number>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.peso"
                                    v-text="errors.dir[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.nacionalidad,
                                    }"
                                    >Nacionalidad*</label
                                >
                                <el-input
                                    placeholder="Nacionalidad"
                                    :class="{
                                        'is-invalid': errors.nacionalidad,
                                    }"
                                    v-model="personal.nacionalidad"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.nacionalidad"
                                    v-text="errors.nacionalidad[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.dir,
                                    }"
                                    >Dirección*</label
                                >
                                <el-input
                                    placeholder="Dirección"
                                    :class="{ 'is-invalid': errors.dir }"
                                    v-model="personal.dir"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.dir"
                                    v-text="errors.dir[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.correo,
                                    }"
                                    >Correo*</label
                                >
                                <el-input
                                    placeholder="Correo"
                                    :class="{ 'is-invalid': errors.correo }"
                                    v-model="personal.correo"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.correo"
                                    v-text="errors.correo[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.fono,
                                    }"
                                    >Teléfono*</label
                                >
                                <el-input
                                    placeholder="Teléfono"
                                    :class="{ 'is-invalid': errors.fono }"
                                    v-model="personal.fono"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.fono"
                                    v-text="errors.fono[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.cel,
                                    }"
                                    >Celular*</label
                                >
                                <el-input
                                    placeholder="Celular"
                                    :class="{ 'is-invalid': errors.cel }"
                                    v-model="personal.cel"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.cel"
                                    v-text="errors.cel[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.tipo,
                                    }"
                                    >Tipo*</label
                                >
                                <el-input
                                    class="w-100 d-block"
                                    :class="{
                                        'is-invalid': errors.tipo,
                                    }"
                                    v-model="personal.tipo"
                                    clearable
                                    readonly
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.tipo"
                                    v-text="errors.tipo[0]"
                                ></span>
                            </div>
                            <!-- <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.tipo,
                                    }"
                                    >Tipo*</label
                                >
                                <el-select
                                    class="w-100 d-block"
                                    :class="{
                                        'is-invalid': errors.tipo,
                                    }"
                                    v-model="personal.tipo"
                                    clearable
                                >
                                    <el-option
                                        v-for="(item, index) in listTipos"
                                        :key="index"
                                        :value="item"
                                        :label="item"
                                    >
                                    </el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.tipo"
                                    v-text="errors.tipo[0]"
                                ></span>
                            </div> -->
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger':
                                            errors.puntuacion_habilidad,
                                    }"
                                    >Puntuación de habilidad*</label
                                >
                                <el-input-number
                                    placeholder="Puntuación de habilidad"
                                    class="w-100 d-block"
                                    :class="{
                                        'is-invalid':
                                            errors.puntuacion_habilidad,
                                    }"
                                    v-model="personal.puntuacion_habilidad"
                                    controls-position="right"
                                    :min="1"
                                    :max="100"
                                    :step="1"
                                    @keyup.native="obtieneHabilidad($event)"
                                    @change.native="obtieneHabilidad($event)"
                                ></el-input-number>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.puntuacion_habilidad"
                                    v-text="errors.dir[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.habilidad,
                                    }"
                                    >Habilidad*</label
                                >
                                <el-input
                                    class="w-100 d-block"
                                    :class="{
                                        'is-invalid': errors.habilidad,
                                    }"
                                    v-model="personal.habilidad"
                                    readonly
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.habilidad"
                                    v-text="errors.habilidad[0]"
                                ></span>
                            </div>

                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.estado,
                                    }"
                                    >Estado*</label
                                >
                                <el-switch
                                    :class="{ 'is-invalid': errors.estado }"
                                    style="display: block"
                                    v-model="personal.estado"
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
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.foto,
                                    }"
                                    >Foto</label
                                >
                                <input
                                    type="file"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': errors.foto,
                                    }"
                                    ref="input_file"
                                    @change="cargaImagen"
                                />
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.foto"
                                    v-text="errors.foto[0]"
                                ></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button
                        type="button"
                        class="btn btn-default"
                        data-dismiss="modal"
                        @click="cierraModal"
                    >
                        Cerrar
                    </button>
                    <el-button
                        type="primary"
                        class="bg-lightblue"
                        :loading="enviando"
                        @click="setRegistroModal()"
                        >{{ textoBoton }}</el-button
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        muestra_modal: {
            type: Boolean,
            default: false,
        },
        accion: {
            type: String,
            default: "nuevo",
        },
        personal: {
            type: Object,
            default: {
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
                puntuacion_habilidad: "1",
                habilidad: "",
                nivel: "",
                estado: "INACTIVO",
                foto: null,
            },
        },
    },
    watch: {
        muestra_modal: function (newVal, oldVal) {
            this.errors = [];
            if (newVal) {
                this.bModal = true;
            } else {
                this.bModal = false;
            }
        },
    },
    computed: {
        tituloModal() {
            if (this.accion == "nuevo") {
                return "AGREGAR REGISTRO";
            } else {
                return "MODIFICAR REGISTRO";
            }
        },
        textoBoton() {
            if (this.accion == "nuevo") {
                return "Registrar";
            } else {
                return "Actualizar";
            }
        },
    },
    data() {
        return {
            user: JSON.parse(localStorage.getItem("user")),
            bModal: this.muestra_modal,
            enviando: false,
            listExpedido: [
                { value: "LP", label: "La Paz" },
                { value: "CB", label: "Cochabamba" },
                { value: "SC", label: "Santa Cruz" },
                { value: "CH", label: "Chuquisaca" },
                { value: "OR", label: "Oruro" },
                { value: "PT", label: "Potosi" },
                { value: "TJ", label: "Tarija" },
                { value: "PD", label: "Pando" },
                { value: "BN", label: "Beni" },
                { value: "OTRO", label: "Otro" },
            ],
            listTipos: ["SUPERVISOR", "GUARDIA"],
            listHabilidades: [
                "EXPERTO",
                "MODERADO",
                "INTERMEDIO",
                "PRINCIPIANTE",
            ],
            errors: [],
            oValoracion: {
                cant_min_experto: 12,
                cant_max_moderado: 11,
                cant_max_intermedio: 7,
                cant_max_principiante: 3,
            },
        };
    },
    mounted() {
        this.getValoraciones();
        this.bModal = this.muestra_modal;
    },
    methods: {
        getValoraciones() {
            axios.get("/admin/valoracions/getValoraciones").then((response) => {
                this.oValoracion.cant_min_experto =
                    response.data.cant_min_experto;
                this.oValoracion.cant_max_moderado =
                    response.data.cant_max_moderado;
                this.oValoracion.cant_max_intermedio =
                    response.data.cant_max_intermedio;
                this.oValoracion.cant_max_principiante =
                    response.data.cant_max_principiante;
            });
        },
        setRegistroModal() {
            this.enviando = true;
            try {
                this.textoBtn = "Enviando...";
                let url = "/admin/personals";
                let config = {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                };
                let formdata = new FormData();
                formdata.append(
                    "nombre",
                    this.personal.nombre ? this.personal.nombre : ""
                );
                formdata.append(
                    "paterno",
                    this.personal.paterno ? this.personal.paterno : ""
                );
                formdata.append(
                    "materno",
                    this.personal.materno ? this.personal.materno : ""
                );
                formdata.append("ci", this.personal.ci ? this.personal.ci : "");
                formdata.append(
                    "ci_exp",
                    this.personal.ci_exp ? this.personal.ci_exp : ""
                );
                formdata.append(
                    "fecha_nacimiento",
                    this.personal.fecha_nacimiento
                        ? this.personal.fecha_nacimiento
                        : ""
                );
                formdata.append(
                    "estatura",
                    this.personal.estatura ? this.personal.estatura : ""
                );
                formdata.append(
                    "peso",
                    this.personal.peso ? this.personal.peso : ""
                );
                formdata.append(
                    "nacionalidad",
                    this.personal.nacionalidad ? this.personal.nacionalidad : ""
                );
                formdata.append(
                    "dir",
                    this.personal.dir ? this.personal.dir : ""
                );
                formdata.append(
                    "correo",
                    this.personal.correo ? this.personal.correo : ""
                );
                formdata.append(
                    "fono",
                    this.personal.fono ? this.personal.fono : ""
                );
                formdata.append(
                    "cel",
                    this.personal.cel ? this.personal.cel : ""
                );
                formdata.append(
                    "tipo",
                    this.personal.tipo ? this.personal.tipo : ""
                );
                formdata.append(
                    "puntuacion_habilidad",
                    this.personal.puntuacion_habilidad
                        ? this.personal.puntuacion_habilidad
                        : ""
                );
                formdata.append(
                    "habilidad",
                    this.personal.habilidad ? this.personal.habilidad : ""
                );
                formdata.append(
                    "estado",
                    this.personal.estado ? this.personal.estado : ""
                );
                formdata.append(
                    "foto",
                    this.personal.foto ? this.personal.foto : ""
                );
                if (this.accion == "edit") {
                    url = "/admin/personals/" + this.personal.id;
                    formdata.append("_method", "PUT");
                }

                // ENVIO REGISTRO PERSONAL
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
                        this.$emit("envioModal");
                        this.limpiaPersonal();
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
        cargaImagen(e) {
            this.personal.foto = e.target.files[0];
        },
        // Dialog/modal
        cierraModal() {
            this.bModal = false;
            this.$emit("close");
        },
        limpiaPersonal() {
            this.errors = [];
            this.personal.nombre = "";
            this.personal.paterno = "";
            this.personal.materno = "";
            this.personal.ci = "";
            this.personal.ci_exp = "";
            this.personal.fecha_nacimiento = "";
            this.personal.estatura = "";
            this.personal.peso = "";
            this.personal.nacionalidad = "";
            this.personal.dir = "";
            this.personal.correo = "";
            this.personal.fono = "";
            this.personal.cel = "";
            this.personal.tipo = "GUARDIA";
            this.personal.habilidad = "1";
            this.personal.estado = "INACTIVO";
            this.$refs.input_file.value = null;
        },
        obtieneHabilidad(e) {
            let puntuacion = parseInt(e.target.value);
            let tipo_personal = "SUPERVISOR";
            if (puntuacion) {
                if (puntuacion <= this.oValoracion.cant_max_principiante) {
                    this.personal.tipo = "GUARDIA";
                    this.personal.habilidad = "PRINCIPIANTE";
                } else if (puntuacion <= this.oValoracion.cant_max_intermedio) {
                    this.personal.tipo = "GUARDIA";
                    this.personal.habilidad = "INTERMEDIO";
                } else if (puntuacion <= this.oValoracion.cant_max_moderado) {
                    this.personal.tipo = "SUPERVISOR";
                    this.personal.habilidad = "MODERADO";
                } else {
                    this.personal.tipo = "SUPERVISOR";
                    this.personal.habilidad = "EXPERTO";
                }
            } else {
                this.personal.tipo = "";
                this.personal.habilidad = "";
            }
            this.personal.puntuacion_habilidad = puntuacion;
        },
    },
};
</script>

<style></style>
