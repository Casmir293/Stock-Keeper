<script setup>
import { ref, watch } from "vue";
import { useToast } from "vue-toastification";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    flash: Object,
    authUser: Object,
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

const drawer = ref(true);
const rail = ref(true);

const logout = () => {
    router.post(route("logout"), {
        onError: (errors) => {
            const firstError = Object.values(errors)[0];
            toast.error(firstError);
        },
    });
};
</script>

<template>
    <v-card>
        <v-layout>
            <v-navigation-drawer
                expand-on-hover
                v-model="drawer"
                :rail="rail"
                permanent
                @click="rail = false"
            >
                <v-list-item
                    prepend-avatar="https://as1.ftcdn.net/v2/jpg/05/16/27/58/1000_F_516275801_f3Fsp17x6HQK0xQgDQEELoTuERO4SsWV.jpg"
                    :title="authUser.name"
                    nav
                >
                    <template v-slot:append>
                        <v-btn
                            icon="mdi-chevron-left"
                            variant="text"
                            @click.stop="rail = !rail"
                        ></v-btn>
                    </template>
                </v-list-item>

                <v-divider></v-divider>

                <v-list density="compact" nav @click="logout">
                    <v-list-item
                        prepend-icon="mdi-logout"
                        title="Logout"
                        value="logout"
                    ></v-list-item>
                </v-list>
            </v-navigation-drawer>
            <v-main class="m-4 min-h-[96.5dvh]">
                <slot />
            </v-main>
        </v-layout>
    </v-card>
</template>
