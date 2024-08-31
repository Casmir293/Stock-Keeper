import { ref } from "vue";
import { useToast } from "vue-toastification";
import { router } from "@inertiajs/vue3";
import { useUserStore } from "../stores/userStore";
import { storeToRefs } from "pinia";
import { Inertia } from "@inertiajs/inertia";

export default function useAuth() {
    const { user, userId, myProfile, isLoggedIn } = storeToRefs(useUserStore());
    const USER_STORE = useUserStore();
    const toast = useToast();
    const isLoading = ref(false);
    const error = ref(null);

    const signIn = async (payload) => {
        isLoading.value = true;
        try {
            await Inertia.post("/sign-in", payload);
            router.push({ name: "home" });
            toast.success("Sign in successful");
        } catch (err) {
            error.value = "Error signing in.";
            toast.error(`Sign in failed: ${error.value}`);
        } finally {
            isLoading.value = false;
        }
    };

    const logOut = async () => {
        isLoading.value = true;
        try {
            await Inertia.post("/logout");
            USER_STORE.$reset(); // Reset user store
            router.push({ name: "signin" });
        } catch (err) {
            error.value = "Error logging out.";
            toast.error(`Logout failed: ${error.value}`);
        } finally {
            isLoading.value = false;
        }
    };

    return {
        signUp,
        signIn,
        logOut,
        isLoading,
        error,
    };
}
