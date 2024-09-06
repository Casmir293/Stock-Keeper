<script setup>
import { ref, computed, nextTick, reactive, watch } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";

// const props = defineProps({
//     errors: Object,
// });

// const { stocks } = usePage().props;
const toast = useToast();
const stocks = computed(() => usePage().props.stocks);
const isValid = ref(false);
const isLoading = ref(false);
const dialog = ref(false);
const dialogDelete = ref(false);
const editedIndex = ref(-1);

const rules = reactive({
    product: (v) => !!v || "Product name is required",
    quantity: (v) =>
        (!!v && /^\d+$/.test(v)) || "Quantity must be a whole number",
    cost_price: (v) =>
        (!!v && /^\d+(\.\d{1,2})?$/.test(v)) ||
        "Cost price must be a valid number",
    selling_price: (v) =>
        (!!v && /^\d+(\.\d{1,2})?$/.test(v)) ||
        "Selling price must be a valid number",
});

const headers = [
    {
        title: "Products",
        align: "start",
        key: "product",
    },
    { title: "Quantity", key: "quantity" },
    { title: "Cost Price (₦)", key: "cost_price" },
    { title: "Selling Price (₦)", key: "selling_price" },
    { title: "Remarks", key: "remarks" },
    { title: "Actions", key: "actions", sortable: false },
];

const defaultItem = {
    product: "",
    quantity: 0,
    cost_price: 0,
    selling_price: 0,
    remarks: "",
};

const editedItem = ref({ ...defaultItem });

watch(
    () => editedItem.value,
    () => {
        isValid.value = Object.keys(rules).every((key) => {
            return rules[key](editedItem.value[key]) === true;
        });
    },
    { deep: true, immediate: true },
);

const formTitle = computed(() =>
    editedIndex.value === -1 ? "New Item" : "Edit Item",
);

const editItem = (item) => {
    editedIndex.value = stocks.value.findIndex((stock) => stock.id === item.id);
    editedItem.value = { ...item };
    dialog.value = true;
};

const deleteItem = (item) => {
    editedIndex.value = stocks.value.findIndex((stock) => stock.id === item.id);
    editedItem.value = { ...item };
    dialogDelete.value = true;
};

const deleteItemConfirm = () => {
    products.value.splice(editedIndex.value, 1);
    closeDelete();
};

const close = () => {
    dialog.value = false;
    nextTick(() => {
        editedItem.value = { ...defaultItem };
        editedIndex.value = -1;
    });
};

const closeDelete = () => {
    dialogDelete.value = false;
    nextTick(() => {
        editedItem.value = { ...defaultItem };
        editedIndex.value = -1;
    });
};

const save = () => {
    if (!isValid.value) return;
    isLoading.value = true;

    if (editedIndex.value > -1) {
        // Object.assign(products.value[editedIndex.value], editedItem.value);
    } else {
        router.post(route("home.store"), editedItem.value, {
            onSuccess: () => {
                setTimeout(() => {
                    close();
                }, 500);
            },
            onError: (errors) => {
                const firstError = Object.values(errors)[0];
                toast.error(firstError);
            },
            onFinish: () => {
                setTimeout(() => {
                    isLoading.value = false;
                }, 500);
            },
        });
    }
};
</script>

<template>
    <v-data-table
        :headers="headers"
        :items="stocks"
        :sort-by="[{ key: 'product', order: 'asc' }]"
    >
        <template v-slot:top>
            <v-toolbar flat>
                <v-toolbar-title>My Stock-Keeper</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <v-dialog v-model="dialog" max-width="500px">
                    <template v-slot:activator="{ props }">
                        <v-btn class="mb-2" color="primary" dark v-bind="props">
                            + Add Product
                        </v-btn>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="text-h5">{{ formTitle }}</span>
                        </v-card-title>

                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12" md="4" sm="6">
                                        <v-text-field
                                            v-model="editedItem.product"
                                            label="Product name"
                                            :rules="[rules.product]"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" sm="6">
                                        <v-text-field
                                            v-model="editedItem.quantity"
                                            label="Quantity (pcs)"
                                            :rules="[rules.quantity]"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" sm="6">
                                        <v-text-field
                                            v-model="editedItem.cost_price"
                                            label="Cost price (₦)"
                                            :rules="[rules.cost_price]"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" sm="6">
                                        <v-text-field
                                            v-model="editedItem.selling_price"
                                            :rules="[rules.selling_price]"
                                            label="Selling price (₦)"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" sm="6">
                                        <v-text-field
                                            v-model="editedItem.remarks"
                                            label="Remark"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="blue-darken-1"
                                variant="text"
                                @click="close"
                            >
                                Cancel
                            </v-btn>
                            <v-btn
                                color="blue-darken-1"
                                variant="text"
                                :disabled="!isValid"
                                :loading="isLoading"
                                @click="save"
                            >
                                Save
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <v-dialog v-model="dialogDelete" max-width="500px">
                    <v-card>
                        <v-card-title class="text-h5"
                            >Are you sure you want to delete this
                            item?</v-card-title
                        >
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="blue-darken-1"
                                variant="text"
                                @click="closeDelete"
                                >Cancel</v-btn
                            >
                            <v-btn
                                color="blue-darken-1"
                                variant="text"
                                @click="deleteItemConfirm"
                                >OK</v-btn
                            >
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-toolbar>
        </template>
        <template v-slot:item.actions="{ item }">
            <v-icon class="me-2" size="small" @click="editItem(item)">
                mdi-pencil
            </v-icon>
            <v-icon size="small" @click="deleteItem(item)"> mdi-delete </v-icon>
        </template>
        <template v-slot:no-data>
            <p>No available product</p>
        </template>
    </v-data-table>
</template>
