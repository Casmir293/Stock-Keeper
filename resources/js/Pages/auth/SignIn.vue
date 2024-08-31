<script setup lang="ts">
import { ref, reactive, watch } from "vue";
import { Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";

const props = defineProps({
    errors: Object,
    flash: Object,
});

const toast = useToast();
const isValid = ref(false);
const isLoading = ref(false);

const payload = reactive({
    email: "",
    password: "",
});

const rules = reactive({
    email: (v: string) =>
        !!(v || "").match(/@/) || "Please enter a valid email",
    password: (v: string) => !!v || "Password is required",
});

watch(
    () => props.flash?.success,
    (successMessage) => {
        if (successMessage) {
            toast.success(successMessage);
        }
    },
    { immediate: true },
);

watch(
    () => props.flash?.error,
    (errorMessage) => {
        if (errorMessage) {
            toast.error(errorMessage);
        }
    },
    { immediate: true },
);

watch(
    () => props.errors,
    (errorMessage) => {
        if (errorMessage?.email || errorMessage?.password) {
            toast.error(`${errorMessage.email || errorMessage.password}`);
        }
    },
    { immediate: true },
);

const submit = () => {
    if (!isValid.value) return;
    isLoading.value = true;
    router.post(route("signin.store"), payload);
    isLoading.value = false;
};
</script>

<template>
    <v-card class="m-auto" style="max-width: 500px">
        <v-toolbar color="grey-darken-3" cards dark flat>
            <v-card-title class="text-h6 font-weight-regular">
                Sign in
            </v-card-title>
        </v-toolbar>
        <v-form ref="" v-model="isValid" class="pa-4 pt-6">
            <v-text-field
                v-model="payload.email"
                :rules="[rules.email]"
                color="grey-darken-1"
                label="Email address"
                type="email"
                variant="filled"
            ></v-text-field>
            <br />
            <v-text-field
                v-model="payload.password"
                :rules="[rules.password]"
                color="grey-darken-1"
                label="Password"
                style="min-height: 96px"
                type="password"
                variant="filled"
            ></v-text-field>

            <p>
                Don't have an account?
                <Link href="/sign-up" class="text-blue-500">sign up</Link>
            </p>
        </v-form>
        <v-divider></v-divider>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
                @click="submit"
                :disabled="!isValid"
                :loading="isLoading"
                color="grey-darken-3"
            >
                Submit
            </v-btn>
        </v-card-actions>
    </v-card>
</template>
