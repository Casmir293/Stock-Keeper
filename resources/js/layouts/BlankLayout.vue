<script setup>
import { useToast } from "vue-toastification";
import { watch } from "vue";

const props = defineProps({
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
</script>

<template>
    <section class="flex h-dvh flex-col items-center justify-center">
        <h1 class="font-sans text-3xl font-bold">Stock Keeper 📈</h1>
        <p class="mb-10 font-thin">Your go to stock manager</p>
        <main class="w-[90%]">
            <slot />
        </main>
    </section>
</template>
