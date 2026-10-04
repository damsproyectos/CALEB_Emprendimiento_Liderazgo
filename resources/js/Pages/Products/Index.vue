<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    store: Object,
    products: Array,
    categories: Array,
});

const dialog = ref(false);
const deleteDialog = ref(false);
const editingProduct = ref(null);
const productToDelete = ref(null);

const statusOptions = [
    { title: 'Activo', value: 'active' },
    { title: 'Borrador', value: 'draft' },
    { title: 'Agotado', value: 'out_of_stock' }
];

const form = useForm({
    name: '',
    category_id: null,
    description: '',
    commercial_price: '',
    price: '',
    image: null,
    status: 'active',
});

const handleProductImageUpload = (e) => {
    if (e.target.files && e.target.files[0]) {
        form.image = e.target.files[0];
    }
};

const openCreateModal = () => {
    editingProduct.value = null;
    form.reset();
    form.status = 'active';
    dialog.value = true;
};

const openEditModal = (product) => {
    editingProduct.value = product;
    form.name = product.name;
    form.category_id = product.category_id;
    form.description = product.description || '';
    form.commercial_price = product.commercial_price || '';
    form.price = product.price;
    form.status = product.status;
    form.image = null;
    dialog.value = true;
};

const submitForm = () => {
    if (editingProduct.value) {
        form.post(route('products.update', editingProduct.value.id), {
            preserveScroll: true,
            onSuccess: () => {
                dialog.value = false;
                form.reset();
            },
        });
    } else {
        form.post(route('products.store'), {
            preserveScroll: true,
            onSuccess: () => {
                dialog.value = false;
                form.reset();
            },
        });
    }
};

const confirmDelete = (product) => {
    productToDelete.value = product;
    deleteDialog.value = true;
};

const deleteProduct = () => {
    if (!productToDelete.value) return;
    useForm({}).delete(route('products.destroy', productToDelete.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            deleteDialog.value = false;
            productToDelete.value = null;
        },
    });
};

const statusColors = {
    active: 'success',
    draft: 'warning',
    out_of_stock: 'error',
};

const statusLabels = {
    active: 'Activo',
    draft: 'Borrador',
    out_of_stock: 'Agotado',
};
</script>

<template>
    <Head title="Mis Productos y Servicios" />

    <AuthenticatedLayout>
        <template #header>
            <div class="d-flex justify-space-between align-center flex-wrap ga-2">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Gestión de Productos y Servicios
                </h2>
                <v-btn
                    v-if="props.store && !dialog"
                    color="primary"
                    prepend-icon="mdi-plus"
                    @click="openCreateModal"
                >
                    Nuevo Producto
                </v-btn>
            </div>
        </template>

        <div class="py-8 px-4 mx-auto max-w-7xl">
            <!-- Banner de Alerta si no tiene tienda creada -->
            <v-alert
                v-if="!props.store"
                type="warning"
                variant="tonal"
                class="mb-6"
                prominent
                icon="mdi-store-alert"
            >
                <div class="d-flex align-center justify-space-between flex-wrap ga-3">
                    <div>
                        <div class="text-h6 font-weight-bold">¡Aún no has creado tu perfil de Tienda!</div>
                        <div>Para poder publicar productos en el marketplace Caleb, primero debes configurar los datos de tu emprendimiento.</div>
                    </div>
                    <Link :href="route('store.show')">
                        <v-btn color="warning" variant="elevated">Crear mi Tienda</v-btn>
                    </Link>
                </div>
            </v-alert>

            <!-- Alerta de éxito -->
            <v-alert
                v-if="$page.props.flash && $page.props.flash.success"
                type="success"
                variant="tonal"
                class="mb-6"
                closable
            >
                {{ $page.props.flash.success }}
            </v-alert>

            <!-- Formulario Inline / Modal Card cuando dialog es verdadero -->
            <v-card v-if="dialog" elevation="4" rounded="lg" class="pa-6 mb-8 border border-primary">
                <div class="d-flex align-center justify-space-between mb-4">
                    <div class="d-flex align-center ga-2">
                        <v-icon color="primary" size="28">
                            {{ editingProduct ? 'mdi-pencil' : 'mdi-plus-circle' }}
                        </v-icon>
                        <h3 class="text-h6 font-weight-bold">
                            {{ editingProduct ? 'Editar Producto / Servicio' : 'Publicar Nuevo Producto / Servicio' }}
                        </h3>
                    </div>
                    <v-btn icon="mdi-close" variant="text" size="small" @click="dialog = false"></v-btn>
                </div>

                <v-divider class="mb-6"></v-divider>

                <form @submit.prevent="submitForm">
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="form.name"
                                label="Nombre del Producto o Servicio *"
                                variant="outlined"
                                required
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="3">
                            <v-select
                                v-model="form.category_id"
                                :items="categories"
                                item-title="name"
                                item-value="id"
                                label="Categoría"
                                variant="outlined"
                                clearable
                            ></v-select>
                        </v-col>

                        <v-col cols="12" md="3">
                            <v-select
                                v-model="form.status"
                                :items="statusOptions"
                                label="Estado del Producto"
                                variant="outlined"
                            ></v-select>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="form.commercial_price"
                                label="Precio Comercial Habitual ($)"
                                variant="outlined"
                                type="number"
                                prefix="$"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="form.price"
                                label="Precio Oferta Caleb ($) *"
                                variant="outlined"
                                type="number"
                                prefix="$"
                                required
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12">
                            <v-textarea
                                v-model="form.description"
                                label="Descripción detallada"
                                variant="outlined"
                                rows="3"
                            ></v-textarea>
                        </v-col>

                        <v-col cols="12">
                            <v-file-input
                                label="Imagen principal del Producto"
                                variant="outlined"
                                accept="image/*"
                                prepend-icon="mdi-camera"
                                @change="handleProductImageUpload"
                            ></v-file-input>
                            <div v-if="editingProduct && editingProduct.image && !form.image" class="mt-2">
                                <span class="text-caption mr-2">Imagen Actual:</span>
                                <v-img :src="'/storage/' + editingProduct.image" height="80" width="100" cover class="rounded"></v-img>
                            </div>
                        </v-col>
                    </v-row>

                    <div class="d-flex justify-end ga-3 mt-6">
                        <v-btn variant="outlined" color="secondary" @click="dialog = false">Cancelar</v-btn>
                        <v-btn color="primary" type="submit" size="large" :loading="form.processing" prepend-icon="mdi-content-save">
                            {{ editingProduct ? 'Actualizar Producto' : 'Guardar y Publicar' }}
                        </v-btn>
                    </div>
                </form>
            </v-card>

            <!-- Lista de Productos -->
            <div v-if="props.store">
                <v-row v-if="props.products && props.products.length > 0">
                    <v-col
                        v-for="product in props.products"
                        :key="product.id"
                        cols="12"
                        sm="6"
                        md="4"
                        lg="3"
                    >
                        <v-card elevation="2" rounded="lg" class="d-flex flex-column h-100">
                            <div class="position-relative">
                                <v-img
                                    :src="product.image ? '/storage/' + product.image : 'https://images.unsplash.com/photo-1560343090-f0409e92791a?auto=format&fit=crop&w=500&q=80'"
                                    height="180"
                                    cover
                                ></v-img>
                                <v-chip
                                    :color="statusColors[product.status]"
                                    size="small"
                                    class="position-absolute ma-2 font-weight-bold"
                                    style="top: 0; right: 0;"
                                >
                                    {{ statusLabels[product.status] }}
                                </v-chip>
                            </div>

                            <v-card-item>
                                <v-card-title class="text-subtitle-1 font-weight-bold">
                                    {{ product.name }}
                                </v-card-title>
                                <v-card-subtitle v-if="product.category">
                                    <v-icon size="small">mdi-tag</v-icon> {{ product.category.name }}
                                </v-card-subtitle>
                            </v-card-item>

                            <v-card-text class="flex-grow-1">
                                <p class="text-caption text-medium-emphasis">
                                    {{ product.description || 'Sin descripción' }}
                                </p>
                                <div class="mt-3">
                                    <span v-if="product.commercial_price" class="text-caption text-decoration-line-through text-medium-emphasis mr-2">
                                        ${{ Number(product.commercial_price).toLocaleString() }}
                                    </span>
                                    <span class="text-h6 font-weight-bold text-primary">
                                        ${{ Number(product.price).toLocaleString() }}
                                    </span>
                                </div>
                            </v-card-text>

                            <v-divider></v-divider>

                            <v-card-actions class="justify-space-between px-4 py-2">
                                <v-btn
                                    size="small"
                                    color="info"
                                    variant="text"
                                    prepend-icon="mdi-pencil"
                                    @click="openEditModal(product)"
                                >
                                    Editar
                                </v-btn>
                                <v-btn
                                    size="small"
                                    color="error"
                                    variant="text"
                                    prepend-icon="mdi-delete"
                                    @click="confirmDelete(product)"
                                >
                                    Eliminar
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>

                <!-- Estado vacío sin productos -->
                <v-card v-if="(!props.products || props.products.length === 0) && !dialog" class="pa-12 text-center" rounded="lg" elevation="1">
                    <v-icon size="64" color="medium-emphasis" class="mb-4">mdi-package-variant</v-icon>
                    <h3 class="text-h5 font-weight-bold mb-2">Aún no tienes productos publicados</h3>
                    <p class="text-body-1 text-medium-emphasis mb-6">
                        Comienza a publicar tus productos o servicios para que la comunidad Caleb los encuentre.
                    </p>
                    <v-btn color="primary" size="large" prepend-icon="mdi-plus" @click="openCreateModal">
                        Crear Primer Producto
                    </v-btn>
                </v-card>
            </div>

            <!-- Card de Confirmación de Eliminación -->
            <v-card v-if="deleteDialog" rounded="lg" class="pa-6 my-6 border border-error max-w-lg mx-auto">
                <h4 class="text-h6 font-weight-bold text-error mb-2">¿Eliminar este producto?</h4>
                <p class="text-body-2 mb-4">Esta acción eliminará de forma permanente el producto de tu catálogo.</p>
                <div class="d-flex justify-end ga-2">
                    <v-btn variant="text" @click="deleteDialog = false">Cancelar</v-btn>
                    <v-btn color="error" variant="elevated" @click="deleteProduct">Sí, Eliminar</v-btn>
                </div>
            </v-card>
        </div>
    </AuthenticatedLayout>
</template>
