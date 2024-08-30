import { ref, computed } from "vue";
import { defineStore } from "pinia";

export const useUserStore = defineStore(
  "user",
  () => {
    const user = ref(null);
    const userId = ref(null);
    const myProfile = ref(null);

    const isLoggedIn = computed(() => {
      return user.value !== null;
    });

    return { user, myProfile, isLoggedIn, userId };
  },
  {
    persist: true,
  },
);