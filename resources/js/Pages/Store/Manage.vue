<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    store: Object,
});

const form = useForm({
    name: props.store?.name || '',
    description: props.store?.description || '',
    address: props.store?.address || '',
    phone: props.store?.phone || '',
    logo: null,
    banner: null,
});

const successMessage = ref('');

const handleLogoUpload = (e) => {
    if (e.target.files && e.target.files[0]) {
        form.logo = e.target.files[0];
    }
};

const handleBannerUpload = (e) => {
    if (e.target.files && e.target.files[0]) {
        form.banner = e.target.files[0];
    }
};

const submit = () => {
    form.post(route('store.update'), {
        preserveScroll: true,
        onSuccess: () => {
            successMessage.value = 'Perfil de la tienda actualizado con éxito.';
            setTimeout(() => { successMessage.value = ''; }, 4000);
        },
    });
};
</script>

<template>
    <Head title="Mi Tienda - Perfil del Emprendedor" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Perfil de Mi Tienda
            </h2>
        </template>

        <div class="py-8 px-4 mx-auto max-w-5xl">
            <v-card class="pa-6" elevation="3" rounded="lg">
                <v-alert
                    v-if="$page.props.flash?.success || successMessage"
                    type="success"
                    variant="tonal"
                    class="mb-6"
                    closable
                >
                    {{ $page.props.flash?.success || successMessage }}
                </v-alert>

                <div class="d-flex align-center mb-6">
                    <v-icon size="36" color="primary" class="mr-3">mdi-storefront</v-icon>
                    <div>
                        <h3 class="text-h5 font-weight-bold">Información de la Tienda</h3>
                        <p class="text-subtitle-2 text-medium-emphasis">
                            Configura la identidad de tu negocio para que los usuarios puedan conocerte.
                        </p>
                    </div>
                </div>

                <v-form @submit.prevent="submit">
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="form.name"
                                label="Nombre de la Tienda / Emprendimiento *"
                                variant="outlined"
                                prepend-inner-icon="mdi-format-title"
                                :error-messages="form.errors.name"
                                required
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="form.phone"
                                label="Teléfono / WhatsApp de Contacto"
                                variant="outlined"
                                prepend-inner-icon="mdi-phone"
                                :error-messages="form.errors.phone"
                            />
                        </v-col>

                        <v-col cols="12">
                            <v-text-field
                                v-model="form.address"
                                label="Ubicación / Dirección Física o Ciudad"
                                variant="outlined"
                                prepend-inner-icon="mdi-map-marker"
                                :error-messages="form.errors.address"
                            />
                        </v-col>

                        <v-col cols="12">
                            <v-textarea
                                v-model="form.description"
                                label="Descripción de la Tienda o Servicios"
                                variant="outlined"
                                rows="3"
                                prepend-inner-icon="mdi-text"
                                :error-messages="form.errors.description"
                            />
                        </v-col>

                        <!-- Logotipo -->
                        <v-col cols="12" md="6">
                            <v-file-input
                                label="Logotipo de la Tienda"
                                variant="outlined"
                                accept="image/*"
                                prepend-icon="mdi-camera"
                                @change="handleLogoUpload"
                                :error-messages="form.errors.logo"
                            />
                            <div v-if="props.store?.logo" class="mt-2 d-flex align-center">
                                <span class="text-caption mr-2">Logo Actual:</span>
                                <v-avatar size="64" rounded="lg">
                                    <v-img :src="'/storage/' + props.store.logo" cover />
                                </v-avatar>
                            </div>
                        </v-col>

                        <!-- Banner -->
                        <v-col cols="12" md="6">
                            <v-file-input
                                label="Imagen de Portada / Banner"
                                variant="outlined"
                                accept="image/*"
                                prepend-icon="mdi-image"
                                @change="handleBannerUpload"
                                :error-messages="form.errors.banner"
                            />
                            <div v-if="props.store?.banner" class="mt-2 d-flex align-center">
                                <span class="text-caption mr-2">Portada Actual:</span>
                                <v-img :src="'/storage/' + props.store.banner" height="60" width="160" cover class="rounded-lg" />
                            </div>
                        </v-col>
                    </v-row>

                    <div class="mt-6 d-flex justify-end">
                        <v-btn
                            type="submit"
                            color="primary"
                            size="large"
                            :loading="form.processing"
                            prepend-icon="mdi-content-save"
                        >
                            Guardar Cambios
                        </v-btn>
                    </div>
                </v-form>
            </v-card>
        </div>
    </AuthenticatedLayout>
</template>
