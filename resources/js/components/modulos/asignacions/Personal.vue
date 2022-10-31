<template>
    <b-list-group-item class="d-flex align-items-center">
        <b-avatar class="mr-3" :src="personal.path_image"></b-avatar>
        <span class="mr-auto"> {{ personal.full_name }}</span>
        <b-badge variant="primary">{{ personal.tipo }}</b-badge>
    </b-list-group-item>
</template>
<script>
export default {
    props: ["id"],
    data() {
        return {
            personal: {
                full_name: "",
                tipo: "",
            },
        };
    },
    mounted() {
        this.getInfoPersonal();
    },
    methods: {
        // Dialog/modal
        cierraModal() {
            this.bModal = false;
            this.$emit("close");
        },
        getInfoPersonal() {
            return axios.get("/admin/personals/" + this.id).then((response) => {
                this.personal = response.data.personal;
            });
        },
    },
};
</script>
<style></style>
