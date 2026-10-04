<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    store: Object,
    orders: Array,
});

const selectedOrder = ref(null);
const detailDialog = ref(false);

const openDetail = (order) => {
    selectedOrder.value = order;
    detailDialog.value = true;
};

const updateStatus = (order, newStatus) => {
    useForm({
        status: newStatus,
    }).post(route('seller.orders.status', order.id), {
        preserveScroll: true,
        onSuccess: () => {
            if (selectedOrder.value && selectedOrder.value.id === order.id) {
                selectedOrder.value.status = newStatus;
            }
        }
    });
};

const statusColors = {
    pending: 'warning',
    confirmed: 'info',
    completed: 'success',
    cancelled: 'error',
};

const statusLabels = {
    pending: 'Pendiente',
    confirmed: 'Confirmado',
    completed: 'Completado',
    cancelled: 'Cancelado',
};

const getCustomerWaLink = (phone, orderNumber) => {
    if (!phone) return '#';
    let clean = phone.replace(/[^0-9]/g, '');
    if (!clean.startsWith('57') && clean.length === 10) {
        clean = '57' + clean;
    }
    const msg = encodeURIComponent(`Hola! Te contacto desde la tienda ${props.store?.name || ''} con respecto a tu pedido N° ${orderNumber}.`);
    return `https://api.whatsapp.com/send/?phone=${clean}&text=${msg}`;
};
</script>

<template>
    <Head title="Pedidos Recibidos - Emprendedor" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Pedidos Recibidos de Mi Tienda
            </h2>
        </template>

        <div class="py-8 px-4 mx-auto max-w-7xl">
            <!-- Alert si no hay tienda -->
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
                        <div>Crea tu tienda para comenzar a recibir pedidos de tus clientes.</div>
                    </div>
                    <Link :href="route('store.show')">
                        <v-btn color="warning" variant="elevated">Crear mi Tienda</v-btn>
                    </Link>
                </div>
            </v-alert>

            <!-- Alerta Flash Success -->
            <v-alert
                v-if="$page.props.flash && $page.props.flash.success"
                type="success"
                variant="tonal"
                class="mb-6"
                closable
            >
                {{ $page.props.flash.success }}
            </v-alert>

            <div v-if="props.store">
                <!-- Tarjeta de Detalle Expandible del Pedido Seleccionado -->
                <v-card v-if="detailDialog && selectedOrder" rounded="lg" class="pa-6 mb-8 border border-primary" elevation="4">
                    <div class="d-flex align-center justify-space-between mb-4">
                        <div class="d-flex align-center ga-2">
                            <v-icon color="primary" size="28">mdi-text-box-search</v-icon>
                            <h3 class="text-h6 font-weight-bold">Detalle del Pedido #{{ selectedOrder.order_number }}</h3>
                            <v-chip :color="statusColors[selectedOrder.status]" size="small" class="font-weight-bold ml-2">
                                {{ statusLabels[selectedOrder.status] }}
                            </v-chip>
                        </div>
                        <v-btn icon="mdi-close" variant="text" size="small" @click="detailDialog = false"></v-btn>
                    </div>

                    <v-divider class="mb-4"></v-divider>

                    <v-row class="mb-4">
                        <v-col cols="12" md="3">
                            <div class="text-caption text-medium-emphasis">Cliente:</div>
                            <div class="font-weight-bold text-subtitle-1">{{ selectedOrder.customer_name }}</div>
                        </v-col>
                        <v-col cols="12" md="3">
                            <div class="text-caption text-medium-emphasis">Teléfono / WhatsApp:</div>
                            <div class="font-weight-bold">{{ selectedOrder.customer_phone }}</div>
                        </v-col>
                        <v-col cols="12" md="3" v-if="selectedOrder.customer_address">
                            <div class="text-caption text-medium-emphasis">Dirección de Entrega:</div>
                            <div>{{ selectedOrder.customer_address }}</div>
                        </v-col>
                        <v-col cols="12" md="3" v-if="selectedOrder.customer_email">
                            <div class="text-caption text-medium-emphasis">Email:</div>
                            <div>{{ selectedOrder.customer_email }}</div>
                        </v-col>
                        <v-col cols="12" v-if="selectedOrder.notes">
                            <div class="text-caption text-medium-emphasis">Notas del Cliente:</div>
                            <div class="text-body-2 bg-grey-darken-3 pa-3 rounded mt-1">{{ selectedOrder.notes }}</div>
                        </v-col>
                    </v-row>

                    <h4 class="text-subtitle-1 font-weight-bold mb-2">Productos Comprados:</h4>
                    <v-table class="bg-grey-darken-4 rounded mb-4">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio Unitario</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in selectedOrder.order_items" :key="item.id">
                                <td>{{ item.product_name }}</td>
                                <td>${{ Number(item.price).toLocaleString() }}</td>
                                <td>x{{ item.quantity }}</td>
                                <td class="font-weight-bold text-primary">${{ Number(item.subtotal).toLocaleString() }}</td>
                            </tr>
                        </tbody>
                    </v-table>

                    <div class="d-flex justify-space-between align-center px-4 py-2 bg-primary rounded mb-6">
                        <span class="text-subtitle-1 font-weight-bold">TOTAL A COBRAR:</span>
                        <span class="text-h5 font-weight-bold">${{ Number(selectedOrder.total).toLocaleString() }}</span>
                    </div>

                    <div class="d-flex align-center justify-space-between flex-wrap ga-3">
                        <div class="d-flex align-center ga-2">
                            <span class="text-caption font-weight-bold">Cambiar Estado:</span>
                            <v-btn
                                size="small"
                                color="info"
                                variant="tonal"
                                :disabled="selectedOrder.status === 'confirmed'"
                                @click="updateStatus(selectedOrder, 'confirmed')"
                            >
                                Confirmar
                            </v-btn>
                            <v-btn
                                size="small"
                                color="success"
                                variant="elevated"
                                :disabled="selectedOrder.status === 'completed'"
                                @click="updateStatus(selectedOrder, 'completed')"
                            >
                                Completado
                            </v-btn>
                            <v-btn
                                size="small"
                                color="error"
                                variant="text"
                                :disabled="selectedOrder.status === 'cancelled'"
                                @click="updateStatus(selectedOrder, 'cancelled')"
                            >
                                Cancelar
                            </v-btn>
                        </div>

                        <div class="d-flex ga-2">
                            <v-btn
                                color="success"
                                variant="elevated"
                                prepend-icon="mdi-whatsapp"
                                :href="getCustomerWaLink(selectedOrder.customer_phone, selectedOrder.order_number)"
                                target="_blank"
                            >
                                Contactar por WhatsApp
                            </v-btn>
                            <v-btn variant="outlined" @click="detailDialog = false">Cerrar Detalle</v-btn>
                        </div>
                    </div>
                </v-card>

                <!-- Tabla Principal de Pedidos Recibidos -->
                <v-card v-if="props.orders && props.orders.length > 0" elevation="2" rounded="lg" class="pa-4">
                    <div class="d-flex align-center mb-4">
                        <v-icon color="primary" class="mr-2">mdi-clipboard-list</v-icon>
                        <h3 class="text-h6 font-weight-bold">Historial de Pedidos Recibidos</h3>
                    </div>

                    <v-table hover>
                        <thead>
                            <tr>
                                <th>N° Pedido</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Teléfono</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in props.orders" :key="order.id">
                                <td class="font-weight-bold text-primary">
                                    {{ order.order_number }}
                                </td>
                                <td class="text-caption">
                                    {{ new Date(order.created_at).toLocaleDateString() }}
                                </td>
                                <td>{{ order.customer_name }}</td>
                                <td>{{ order.customer_phone }}</td>
                                <td class="font-weight-bold">
                                    ${{ Number(order.total).toLocaleString() }}
                                </td>
                                <td>
                                    <v-chip :color="statusColors[order.status]" size="small" class="font-weight-bold">
                                        {{ statusLabels[order.status] }}
                                    </v-chip>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-center ga-1">
                                        <v-btn
                                            size="small"
                                            color="primary"
                                            variant="tonal"
                                            icon="mdi-eye"
                                            title="Ver Detalle"
                                            @click="openDetail(order)"
                                        ></v-btn>
                                        <v-btn
                                            size="small"
                                            color="success"
                                            variant="tonal"
                                            icon="mdi-whatsapp"
                                            title="Contactar por WhatsApp"
                                            :href="getCustomerWaLink(order.customer_phone, order.order_number)"
                                            target="_blank"
                                        ></v-btn>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </v-table>
                </v-card>

                <!-- Estado vacío sin pedidos -->
                <v-card v-else class="pa-12 text-center" rounded="lg" elevation="1">
                    <v-icon size="64" color="medium-emphasis" class="mb-4">mdi-cart-outline</v-icon>
                    <h3 class="text-h5 font-weight-bold mb-2">Aún no has recibido pedidos</h3>
                    <p class="text-body-1 text-medium-emphasis mb-6">
                        Cuando los clientes realicen compras de tus productos en el Marketplace, aparecerán aquí automáticamente.
                    </p>
                    <Link :href="route('products.index')">
                        <v-btn color="primary" prepend-icon="mdi-plus">Publicar más Productos</v-btn>
                    </Link>
                </v-card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
