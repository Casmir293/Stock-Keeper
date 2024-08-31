<script setup>
import DefaultLayout from "../Layouts/DefaultLayout.vue";
import { ref, reactive, watch } from "vue";
import { useToast } from "vue-toastification";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    errors: Object,
    flash: Object,
});

const toast = useToast();

watch(
    () => props.flash?.success,
    (successMessage) => {
        if (successMessage) {
            toast.success(successMessage);
        }
    },
    { immediate: true },
);

// watch(
//     () => props.flash?.error,
//     (errorMessage) => {
//         if (errorMessage) {
//             toast.error(errorMessage);
//         }
//     },
//     { immediate: true },
// );

// watch(
//     () => props.errors,
//     (errorMessage) => {
//         if (errorMessage?.email || errorMessage?.password) {
//             toast.error(`${errorMessage.email || errorMessage.password}`);
//         }
//     },
//     { immediate: true },
// );

defineOptions({ layout: DefaultLayout });
</script>

<template>
    <section>Hello, Inertia!</section>
</template>
