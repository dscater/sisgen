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
                    <h4 class="modal-title">Vista previa de asignación</h4>
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
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                <strong
                                    >Nivel de confianza del
                                    <span>{{
                                        (
                                            parseFloat(resultado[0]) * 100
                                        ).toFixed(0)
                                    }}</span
                                    >%</strong
                                >
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div
                            class="col-md-12"
                            v-for="(item, index) in resultado[1]"
                            :key="index"
                        >
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        {{ item[0].nombre }}
                                    </h3>
                                    <div class="card-tools">
                                        <button
                                            type="button"
                                            class="btn btn-tool"
                                            data-card-widget="collapse"
                                        >
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <b-list-group>
                                        <Personal
                                            v-for="(
                                                personal, index_supervisor
                                            ) in item[1]['supervisores']"
                                            :key="
                                                index_supervisor +
                                                '_' +
                                                personal
                                            "
                                            :id="personal"
                                        ></Personal>
                                        <Personal
                                            v-for="(
                                                personal, index_guardias
                                            ) in item[1]['guardias']"
                                            :key="
                                                index_guardias + '_' + personal
                                            "
                                            :id="personal"
                                        ></Personal>
                                    </b-list-group>
                                </div>
                            </div>
                        </div>
                    </div>
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
                        >Registrar asignación</el-button
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Personal from "./Personal.vue";
export default {
    components: {
        Personal,
    },
    props: {
        muestra_modal: {
            type: Boolean,
            default: false,
        },
        resultado: {
            type: Array,
            default: [0, []],
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
    data() {
        return {
            user: JSON.parse(localStorage.getItem("user")),
            bModal: this.muestra_modal,
            enviando: false,
        };
    },
    mounted() {
        this.bModal = this.muestra_modal;
    },
    methods: {
        // Dialog/modal
        cierraModal() {
            this.bModal = false;
            this.$emit("close");
        },
        setRegistroModal() {
            this.enviando = true;
            Swal.fire({
                title: "¿Esta seguro(a) de realizar el registro?",
                html: ``,
                showCancelButton: true,
                confirmButtonColor: "#05568e",
                confirmButtonText: "Si, estoy seguro(a)",
                cancelButtonText: "No, cancelar",
                denyButtonText: `No, cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .post("/admin/asignacions", this.resultado)
                        .then((response) => {
                            Swal.fire({
                                icon: "success",
                                title: response.data.msj,
                                showConfirmButton: true,
                                confirmButtonColor: "#05568e",
                                confirmButtonText: "Aceptar",
                                timer: 1500,
                            });

                            this.$emit("loadingRegistros");
                            this.$emit("envioModal");
                        });
                }
            });
        },
    },
};
</script>

<style></style>
