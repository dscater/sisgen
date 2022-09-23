import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

export default new Router({
    routes: [
        // INICIO
        {
            path: '/',
            name: 'inicio',
            component: require('./components/Inicio.vue').default
        },

        // LOGIN
        {
            path: '/login',
            name: 'login',
            component: require('./Auth.vue').default
        },

        // USUARIOS
        {
            path: '/usuarios/perfil/:id',
            name: 'usuarios.perfil',
            component: require('./components/modulos/usuarios/perfil.vue').default,
            props: true
        },
        {
            path: '/usuarios',
            name: 'usuarios.index',
            component: require('./components/modulos/usuarios/index.vue').default
        },

        // USUARIOS
        {
            path: '/personals',
            name: 'personals.index',
            component: require('./components/modulos/personals/index.vue').default
        },

        // PUESTOS DE VIGILANCIA
        {
            path: '/puesto_vigilancias',
            name: 'puesto_vigilancias.index',
            component: require('./components/modulos/puesto_vigilancias/index.vue').default,
        },

        // MATERIALES
        {
            path: '/materials',
            name: 'materials.index',
            component: require('./components/modulos/materials/index.vue').default,
        },

        // ASIGNACIONS
        {
            path: '/asignacions',
            name: 'asignacions.index',
            component: require('./components/modulos/asignacions/index.vue').default,
        },

        // {
        //     path: '/asignacions/create',
        //     name: 'asignacions.create',
        //     component: require('./components/modulos/asignacions/create.vue').default,
        // },

        // ASISTENCIAS
        {
            path: '/asistencias',
            name: 'asistencias.index',
            component: require('./components/modulos/asistencias/index.vue').default,
        },

        // CONFIGURACIÓN
        {
            path: '/configuracion',
            name: 'configuracion',
            component: require('./components/modulos/configuracion/index.vue').default,
            props: true
        },

        // REPORTES
        {
            path: '/reportes/usuarios',
            name: 'reportes.usuarios',
            component: require('./components/modulos/reportes/usuarios.vue').default,
            props: true
        },

        {
            path: '/reportes/asignacions',
            name: 'reportes.asignacions',
            component: require('./components/modulos/reportes/asignacions.vue').default,
            props: true
        },

        {
            path: '/reportes/personal',
            name: 'reportes.personal',
            component: require('./components/modulos/reportes/personal.vue').default,
            props: true
        },

        {
            path: '/reportes/puesto_vigilancias',
            name: 'reportes.puesto_vigilancias',
            component: require('./components/modulos/reportes/puesto_vigilancias.vue').default,
            props: true
        },

        {
            path: '/reportes/asistencias',
            name: 'reportes.asistencias',
            component: require('./components/modulos/reportes/asistencias.vue').default,
            props: true
        },

        // PÁGINA NO ENCONTRADA
        {
            path: '*',
            component: require('./components/modulos/errors/404.vue').default
        },
    ],
    mode: 'history',
    linkActiveClass: 'active'
});