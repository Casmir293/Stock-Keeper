<script setup>
import { ref, computed, nextTick, reactive, watch } from "vue";

const isValid = ref(false);
const dialog = ref(false);
const dialogDelete = ref(false);
const editedIndex = ref(-1);

const rules = reactive({
    name: (v) => !!v || "Product name is required",
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
        key: "name",
    },
    { title: "Quantity", key: "quantity" },
    { title: "Cost Price (₦)", key: "cost_price" },
    { title: "Selling Price (₦)", key: "selling_price" },
    { title: "Remarks", key: "remarks" },
    { title: "Actions", key: "actions", sortable: false },
];

const products = ref([
    {
        name: "Frozen Yogurt",
        quantity: 159,
        cost_price: 6.0,
        selling_price: 24,
        remarks: 4.0,
    },
    {
        name: "Ice cream sandwich",
        quantity: 237,
        cost_price: 9.0,
        selling_price: 37,
        remarks: 4.3,
    },
    {
        name: "Eclair",
        quantity: 262,
        cost_price: 16.0,
        selling_price: 23,
        remarks: 6.0,
    },
    {
        name: "Cupcake",
        quantity: 305,
        cost_price: 3.7,
        selling_price: 67,
        remarks: 4.3,
    },
    {
        name: "Gingerbread",
        quantity: 356,
        cost_price: 16.0,
        selling_price: 49,
        remarks: 3.9,
    },
    {
        name: "Jelly bean",
        quantity: 375,
        cost_price: 0.0,
        selling_price: 94,
        remarks: 0.0,
    },
    {
        name: "Lollipop",
        quantity: 392,
        cost_price: 0.2,
        selling_price: 98,
        remarks: 0,
    },
    {
        name: "Honeycomb",
        quantity: 408,
        cost_price: 3.2,
        selling_price: 87,
        remarks: 6.5,
    },
    {
        name: "Donut",
        quantity: 452,
        cost_price: 25.0,
        selling_price: 51,
        remarks: 4.9,
    },
    {
        name: "KitKat",
        quantity: 518,
        cost_price: 26.0,
        selling_price: 65,
        remarks: 7,
    },
]);

const defaultItem = {
    name: "",
    quantity: 0,
    cost_price: 0,
    selling_price: 0,
    remarks: 0,
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
    editedIndex.value = products.value.indexOf(item);
    editedItem.value = { ...item };
    dialog.value = true;
};

const deleteItem = (item) => {
    editedIndex.value = products.value.indexOf(item);
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
    if (editedIndex.value > -1) {
        Object.assign(products.value[editedIndex.value], editedItem.value);
    } else {
        products.value.push(editedItem.value);
    }
    close();
};
</script>

<template>
    <v-data-table
        :headers="headers"
        :items="products"
        :sort-by="[{ key: 'name', order: 'asc' }]"
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
                                            v-model="editedItem.name"
                                            label="Product name"
                                            :rules="[rules.name]"
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
