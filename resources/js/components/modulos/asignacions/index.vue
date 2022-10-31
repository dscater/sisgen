<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Asignación de Personal</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card border-primary">
                            <!-- <div class="card-header">
                                <div class="row">
                                    <div class="col-md-3">
                                        <router-link
                                            :to="{ name: 'asignacions.index' }"
                                            class="btn btn-out-line btn-flat btn-block btn-sm"
                                            ><i class="fa fa-arrow-left"></i>
                                            VOLVER</router-link
                                        >
                                    </div>
                                </div>
                            </div> -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- VALORES MINIMOS MAXIMOS PERSONAL -->
                                        <h4>
                                            VALORACIÓN DEL PUESTO DE VIGILANCIA
                                        </h4>
                                        <table
                                            class="table table-bordered tabla_asignaciones auto_ajustable"
                                        >
                                            <tbody>
                                                <tr class="bg-primary">
                                                    <td
                                                        colspan="4"
                                                        class="text-center font-weight-bold"
                                                    >
                                                        Nivel: Alto
                                                    </td>
                                                </tr>
                                                <tr class="bg-gray">
                                                    <td></td>
                                                    <td
                                                        class="text-center font-weight-bold"
                                                    >
                                                        Pesonal de Seguridad
                                                    </td>
                                                    <td
                                                        class="text-center font-weight-bold"
                                                    >
                                                        Supervisores
                                                    </td>
                                                    <td
                                                        class="text-center font-weight-bold"
                                                    >
                                                        Guardias
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pl-1 bg-gray">
                                                        Cantidad Mínima
                                                    </td>
                                                    <td>
                                                        <el-input-number
                                                            placeholder="Min."
                                                            v-model="
                                                                oAsignacion.cant_min_per_alto
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_min_per_alto,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_min_per_alto
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_min_per_alto[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                    <td rowspan="2">
                                                        <el-input-number
                                                            placeholder="Min."
                                                            v-model="
                                                                oAsignacion.cant_min_sup_alto
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_min_sup_alto,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_min_sup_alto
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_min_sup_alto[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                    <td>
                                                        <el-input-number
                                                            placeholder="Min."
                                                            v-model="
                                                                oAsignacion.cant_min_guar_alto
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_min_guar_alto,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_min_guar_alto
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_min_guar_alto[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pl-1 bg-gray">
                                                        Cantidad Máxima
                                                    </td>
                                                    <td>
                                                        <el-input-number
                                                            placeholder="Max."
                                                            v-model="
                                                                oAsignacion.cant_max_per_alto
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_max_per_alto,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_max_per_alto
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_max_per_alto[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                    <td>
                                                        <el-input-number
                                                            placeholder="Max."
                                                            v-model="
                                                                oAsignacion.cant_max_guar_alto
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_max_guar_alto,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_max_guar_alto
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_max_guar_alto[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        colspan="4"
                                                        class="text-center font-weight-bold bg-primary"
                                                    >
                                                        Nivel: Medio
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pl-1 bg-gray">
                                                        Cantidad Mínima
                                                    </td>
                                                    <td>
                                                        <el-input-number
                                                            placeholder="Min."
                                                            v-model="
                                                                oAsignacion.cant_min_per_medio
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_min_per_medio,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_min_per_medio
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_min_per_medio[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                    <td rowspan="2">
                                                        <el-input-number
                                                            placeholder="Min."
                                                            v-model="
                                                                oAsignacion.cant_min_sup_medio
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_min_sup_medio,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_min_sup_medio
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_min_sup_medio[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                    <td>
                                                        <el-input-number
                                                            placeholder="Min."
                                                            v-model="
                                                                oAsignacion.cant_min_guar_medio
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_min_guar_medio,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_min_guar_medio
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_min_guar_medio[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pl-1 bg-gray">
                                                        Cantidad Máxima
                                                    </td>
                                                    <td>
                                                        <el-input-number
                                                            placeholder="Max."
                                                            v-model="
                                                                oAsignacion.cant_max_per_medio
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_max_per_medio,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_max_per_medio
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_max_per_medio[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                    <td>
                                                        <el-input-number
                                                            placeholder="Max."
                                                            v-model="
                                                                oAsignacion.cant_max_guar_medio
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_max_guar_medio,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_max_guar_medio
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_max_guar_medio[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        colspan="4"
                                                        class="text-center font-weight-bold bg-primary"
                                                    >
                                                        Nivel: Básico
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pl-1 bg-gray">
                                                        Cantidad Mínima
                                                    </td>
                                                    <td>
                                                        <el-input-number
                                                            placeholder="Min."
                                                            v-model="
                                                                oAsignacion.cant_min_per_basico
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_min_per_basico,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_min_per_basico
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_min_per_basico[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                    <td rowspan="2">
                                                        <el-input-number
                                                            placeholder="Min."
                                                            v-model="
                                                                oAsignacion.cant_min_sup_basico
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_min_sup_basico,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_min_sup_basico
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_min_sup_basico[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                    <td>
                                                        <el-input-number
                                                            placeholder="Min."
                                                            v-model="
                                                                oAsignacion.cant_min_guar_basico
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_min_guar_basico,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_min_guar_basico
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_min_guar_basico[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pl-1 bg-gray">
                                                        Cantidad Máxima
                                                    </td>
                                                    <td>
                                                        <el-input-number
                                                            placeholder="Max."
                                                            v-model="
                                                                oAsignacion.cant_max_per_basico
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_max_per_basico,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_max_per_basico
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_max_per_basico[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                    <td>
                                                        <el-input-number
                                                            placeholder="Max."
                                                            v-model="
                                                                oAsignacion.cant_max_guar_basico
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_max_guar_basico,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_max_guar_basico
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_max_guar_basico[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- VALORES PERSONAL -->
                                        <h4>
                                            VALORACIÓN DE HABILIDADES DEL
                                            PERSONAL DE SEGURIDAD
                                        </h4>
                                        <table
                                            class="table table-bordered tabla_asignaciones ajustable_valores"
                                        >
                                            <tbody>
                                                <tr class="bg-primary">
                                                    <td
                                                        colspan="2"
                                                        class="font-weight-bold pl-1"
                                                    >
                                                        PERSONAL DE SEGURIDAD
                                                    </td>
                                                    <td
                                                        class="text-center font-weight-bold"
                                                    >
                                                        Valor Mínimo
                                                    </td>
                                                    <td
                                                        class="text-center font-weight-bold"
                                                    >
                                                        Valor Máximo
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        rowspan="2"
                                                        class="bg-gray pl-1"
                                                    >
                                                        Supervisor
                                                    </td>
                                                    <td class="bg-gray pl-1">
                                                        Experto
                                                    </td>
                                                    <td>
                                                        <el-input-number
                                                            placeholder="Min."
                                                            v-model="
                                                                oAsignacion.cant_min_experto
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_min_experto,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_min_experto
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_min_experto[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                    <td>
                                                        <el-input-number
                                                            placeholder="Max."
                                                            v-model="
                                                                oAsignacion.cant_max_experto
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_max_experto,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_max_experto
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_max_experto[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-gray pl-1">
                                                        Moderado
                                                    </td>
                                                    <td>
                                                        <el-input-number
                                                            placeholder="Min."
                                                            v-model="
                                                                oAsignacion.cant_min_moderado
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_min_moderado,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_min_moderado
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_min_moderado[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                    <td>
                                                        <el-input-number
                                                            placeholder="Max."
                                                            v-model="
                                                                oAsignacion.cant_max_moderado
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_max_moderado,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_max_moderado
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_max_moderado[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        rowspan="2"
                                                        class="bg-gray pl-1"
                                                    >
                                                        Guardias
                                                    </td>
                                                    <td class="bg-gray pl-1">
                                                        Intermedio
                                                    </td>
                                                    <td>
                                                        <el-input-number
                                                            placeholder="Min."
                                                            v-model="
                                                                oAsignacion.cant_min_intermedio
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_min_intermedio,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_min_intermedio
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_min_intermedio[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                    <td>
                                                        <el-input-number
                                                            placeholder="Max."
                                                            v-model="
                                                                oAsignacion.cant_max_intermedio
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_max_intermedio,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_max_intermedio
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_max_intermedio[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bg-gray pl-1">
                                                        Principiante
                                                    </td>
                                                    <td>
                                                        <el-input-number
                                                            placeholder="Min."
                                                            v-model="
                                                                oAsignacion.cant_min_principiante
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_min_principiante,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_min_principiante
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_min_principiante[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                    <td>
                                                        <el-input-number
                                                            placeholder="Max."
                                                            v-model="
                                                                oAsignacion.cant_max_principiante
                                                            "
                                                            controls-position="right"
                                                            :min="1"
                                                            :step="1"
                                                            :class="{
                                                                'is-invalid':
                                                                    errors.cant_max_principiante,
                                                            }"
                                                            class="w-full"
                                                        ></el-input-number>
                                                        <span
                                                            class="error invalid-feedback"
                                                            v-if="
                                                                errors.cant_max_principiante
                                                            "
                                                            v-text="
                                                                errors
                                                                    .cant_max_principiante[0]
                                                            "
                                                        ></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <el-button
                                            type="primary"
                                            class="bg-primary btn-block btn-flat"
                                            :loading="enviando"
                                            @click="generaAsignacion()"
                                            >GENERAR ASIGNACIONES</el-button
                                        >
                                    </div>

                                    <div
                                        class="col-md-12 form-group mt-2"
                                        v-if="generacionPorcentaje > 0"
                                    >
                                        <div class="progress">
                                            <div
                                                class="progress-bar"
                                                role="progressbar"
                                                v-bind:style="{
                                                    width:
                                                        generacionPorcentaje +
                                                        '%',
                                                }"
                                                :aria-valuenow="
                                                    generacionPorcentaje
                                                "
                                                aria-valuemin="0"
                                                aria-valuemax="100"
                                            >
                                                Generando asignaciones -
                                                {{ generacionPorcentaje }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <h4>RESULTADOS DE ASIGNACIÓN</h4>
                                    <div class="col-md-12">
                                        <template
                                            v-if="
                                                listAsignaciones.length > 0 &&
                                                !loadingRegistros
                                            "
                                        >
                                            <el-button
                                                type="primary"
                                                class="bg-primary btn-block btn-flat"
                                                :loading="enviando_reporte"
                                                @click="exportarRegistros()"
                                                >Exportar registros</el-button
                                            >
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" v-loading="loadingRegistros">
                                <div class="row">
                                    <div
                                        class="col-md-12"
                                        v-for="item in listAsignaciones"
                                        :key="item.id"
                                    >
                                        <div
                                            class="card card-primary collapsed-card"
                                        >
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    {{
                                                        item.puesto_vigilancia
                                                            .nombre
                                                    }}
                                                </h3>
                                                <div class="card-tools">
                                                    <button
                                                        type="button"
                                                        class="btn btn-tool"
                                                        data-card-widget="collapse"
                                                    >
                                                        <i
                                                            class="fas fa-plus"
                                                        ></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div
                                                class="card-body"
                                                style="display: none"
                                            >
                                                <b-list-group>
                                                    <b-list-group-item
                                                        class="d-flex align-items-center"
                                                        v-for="ap in item.asignacion_personals"
                                                        :key="ap.id"
                                                    >
                                                        <b-avatar
                                                            class="mr-3"
                                                            :src="
                                                                ap.personal
                                                                    .path_image
                                                            "
                                                        ></b-avatar>
                                                        <span class="mr-auto">
                                                            {{
                                                                ap.personal
                                                                    .full_name
                                                            }}</span
                                                        >
                                                        <b-badge
                                                            variant="primary"
                                                            >{{
                                                                ap.tipo_personal
                                                            }}</b-badge
                                                        >
                                                    </b-list-group-item>
                                                </b-list-group>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <Preview
            :muestra_modal="muestra_modal"
            :resultado="resultado"
            @close="muestra_modal = false"
            @loadingRegistros="loadingRegistros = true"
            @envioModal="getAsignaciones"
        ></Preview>
    </div>
</template>

<script>
import Preview from "./Preview.vue";
export default {
    components: {
        Preview,
    },
    data() {
        return {
            permisos: localStorage.getItem("permisos"),
            errors: [],
            loading: true,
            loadingRegistros: false,
            enviando: false,
            loadingWindow: Loading.service({
                fullscreen: this.fullscreenLoading,
            }),
            muestra_modal: false,
            oAsignacion: {
                cant_min_per_alto: 11,
                cant_max_per_alto: 15,
                cant_min_sup_alto: 4,
                cant_min_guar_alto: 7,
                cant_max_guar_alto: 11,
                cant_min_per_medio: 7,
                cant_max_per_medio: 10,
                cant_min_sup_medio: 3,
                cant_min_guar_medio: 4,
                cant_max_guar_medio: 7,
                cant_min_per_basico: 4,
                cant_max_per_basico: 6,
                cant_min_sup_basico: 2,
                cant_min_guar_basico: 2,
                cant_max_guar_basico: 4,
                cant_min_experto: 12,
                cant_max_experto: 15,
                cant_min_moderado: 8,
                cant_max_moderado: 11,
                cant_min_intermedio: 4,
                cant_max_intermedio: 7,
                cant_min_principiante: 1,
                cant_max_principiante: 3,
            },
            listAsignaciones: [],
            generacionPorcentaje: 0,
            intervalCargaAsignacion: null,
            enviando_reporte: false,
            resultado: [],
        };
    },
    mounted() {
        this.loadingWindow.close();
        this.getAsignaciones();
    },
    methods: {
        generaAsignacion() {
            this.generacionPorcentaje = 1;
            this.enviando = true;
            let self = this;
            this.intervalCargaAsignacion = setInterval(
                self.incrementaCarga,
                400
            );
            axios
                .post("/admin/asignacions/getResultado", this.oAsignacion)
                .then((response) => {
                    this.enviando = false;
                    clearInterval(this.intervalCargaAsignacion);
                    if (response.data.sw) {
                        this.generacionPorcentaje = 100;
                        this.muestra_modal = true;
                        this.resultado = response.data.resultado;
                    } else {
                        this.muestra_modal = false;
                        Swal.fire({
                            icon: "error",
                            title: "¡Error!",
                            text: response.data.msj,
                            showConfirmButton: true,
                            confirmButtonColor: "#05568e",
                            confirmButtonText: "Aceptar",
                            timer: 3500,
                        });
                    }
                })
                .catch((error) => {
                    this.enviando = false;
                    clearInterval(this.intervalCargaAsignacion);
                    this.ocultaBarraProgreso();
                    if (error.response) {
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors;
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Ocurrió un error y no se pudo llevar a cabo la ejecución del algoritmo",
                                showConfirmButton: true,
                                confirmButtonColor: "#05568e",
                                confirmButtonText: "Cerrar",
                            });
                        }
                    }
                });
        },
        getAsignaciones() {
            this.loadingRegistros = true;
            this.muestra_modal = false;
            axios.get("/admin/asignacions").then((response) => {
                this.loadingRegistros = false;
                this.listAsignaciones = response.data.asignacions;
            });
        },
        incrementaCarga() {
            if (this.generacionPorcentaje < 99) {
                this.generacionPorcentaje++;
            }
        },
        ocultaBarraProgreso() {
            this.generacionPorcentaje = 0;
        },
        exportarRegistros() {
            this.enviando_reporte = true;
            let config = {
                responseType: "blob",
            };
            axios
                .post("/admin/reportes/asignacions", {}, config)
                .then((res) => {
                    this.errors = [];
                    this.enviando_reporte = false;
                    let pdfBlob = new Blob([res.data], {
                        type: "application/pdf",
                    });
                    let urlReporte = URL.createObjectURL(pdfBlob);
                    window.open(urlReporte);
                })
                .catch(async (error) => {
                    let responseObj = await error.response.data.text();
                    responseObj = JSON.parse(responseObj);
                    this.enviando_reporte = false;
                    if (error.response) {
                        if (error.response.status == 422)
                            this.errors = responseObj.errors;
                    }
                });
        },
    },
};
</script>

<style>
.tabla_asignaciones {
    max-width: 100% !important;
    width: 100%;
    table-layout: fixed;
    overflow-wrap: break-word;
}

.tabla_asignaciones tbody tr td {
    padding: 0px;
    vertical-align: middle;
}

.tabla_asignaciones tbody tr td input {
    max-width: 100%;
    margin: 0px;
    border-radius: 0px;
}

.el-loading-mask {
    z-index: 1 !important;
}

@media (max-width: 800px) {
    .tabla_asignaciones.auto_ajustable tbody tr td:nth-child(1) {
        display: none;
    }

    .tabla_asignaciones.ajustable_valores tbody tr td {
        display: block;
    }

    .tabla_asignaciones.ajustable_valores tbody tr:nth-child(1) td:nth-child(2),
    .tabla_asignaciones.ajustable_valores
        tbody
        tr:nth-child(1)
        td:nth-child(3) {
        display: none;
    }
}
</style>
