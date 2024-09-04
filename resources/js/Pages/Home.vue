<script setup>
import DefaultLayout from "../Layouts/DefaultLayout.vue";
import DataTable from "../components/DataTable.vue";
import { ref, reactive, watch } from "vue";
import { useToast } from "vue-toastification";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    errors: Object,
    flash: Object,
});

defineOptions({ layout: DefaultLayout });
</script>

<template>
    <data-table />
</template>
