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
    name: "",
    email: "",
    password: "",
});

const rules = reactive({
    email: (v: string) =>
        !!(v || "").match(/@/) || "Please enter a valid email",
    length: (len: number) => (v: string) =>
        (v || "").length >= len || `Invalid character length, required ${len}`,
    password: (v: string) =>
        !!(v || "").match(
            /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/,
        ) ||
        "Password must contain an upper case letter, a numeric character, and a special character",
    name: (v: string) => !!v || "Nickname is required",
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
    () => props.errors,
    (errorMessage) => {
        if (errorMessage) {
            toast.error(
                `Sign up failed: ${errorMessage.name || errorMessage.email || errorMessage.password || "Sign up failed"}`,
            );
        }
    },
    { immediate: true },
);

const submit = () => {
    if (!isValid.value) return;
    isLoading.value = true;
    router.post("/sign-up", payload);
    isLoading.value = false;
};
</script>

<template>
    <v-card class="m-auto" style="max-width: 500px">
        <v-toolbar color="grey-darken-3" cards dark flat>
            <v-card-title class="text-h6 font-weight-regular">
                Sign up
            </v-card-title>
        </v-toolbar>
        <v-form ref="" v-model="isValid" class="pa-4 pt-6">
            <v-text-field
                v-model="payload.name"
                :rules="[rules.name]"
                color="grey-darken-1"
                label="Nick name"
                type="email"
                variant="filled"
            ></v-text-field>
            <br />
            <v-text-field
                v-model="payload.email"
                :rules="[rules.email] || errors.email"
                color="grey-darken-1"
                label="Email address"
                type="email"
                variant="filled"
            ></v-text-field>
            <br />
            <v-text-field
                v-model="payload.password"
                :rules="[rules.password, rules.length(6)]"
                color="grey-darken-1"
                counter="6"
                label="Password"
                style="min-height: 96px"
                type="password"
                variant="filled"
            ></v-text-field>

            <p>
                Already have an account?
                <Link href="/sign-in" class="text-blue-500">sign in</Link>
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
