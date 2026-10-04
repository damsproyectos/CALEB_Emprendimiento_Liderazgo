<script lang="ts">
import { useCartStore } from '@/src/stores/cart';
import { mapState, mapActions } from 'pinia';

export default {
    data() {
        return {
            checkoutDialog: false,
            successDialog: false,
            loading: false,
            errorMessage: '',
            customer: {
                name: '',
                phone: '',
                address: '',
                email: '',
                notes: '',
            },
            createdOrders: [] as any[],
        };
    },
    computed: {
        ...mapState(useCartStore, ["details", "totalAmount"])
    },
    mounted() {
        // Pre-fill user data if available from Inertia page props
        const pageUser = (this as any).$page?.props?.auth?.user;
        if (pageUser) {
            this.customer.name = pageUser.name || '';
            this.customer.email = pageUser.email || '';
        }
    },
    methods: {
        ...mapActions(useCartStore, ["clearCart"]),

        openCheckoutModal() {
            if (this.details.length === 0) {
                alert('El carrito está vacío.');
                return;
            }
            this.errorMessage = '';
            this.checkoutDialog = true;
        },

        async processCheckout() {
            if (!this.customer.name || !this.customer.phone) {
                this.errorMessage = 'Por favor completa tu Nombre y Teléfono de contacto.';
                return;
            }

            this.loading = true;
            this.errorMessage = '';

            const metaToken = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content || '';
            const matchCookie = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
            const cookieToken = matchCookie ? decodeURIComponent(matchCookie[1]) : '';
            const token = metaToken || cookieToken;

            try {
                const response = await fetch('/api/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'X-XSRF-TOKEN': token,
                    },
                    body: JSON.stringify({
                        customer_name: this.customer.name,
                        customer_phone: this.customer.phone,
                        customer_address: this.customer.address,
                        customer_email: this.customer.email,
                        notes: this.customer.notes,
                        items: this.details.map(d => ({
                            id: d.product.id,
                            quantity: d.quantity,
                        })),
                    }),
                });

                const data = await response.json();

                if (!response.ok) {
                    this.errorMessage = data.message || data.error || 'Ocurrió un error al procesar la compra.';
                    this.loading = false;
                    return;
                }

                this.createdOrders = data.orders || [];
                this.checkoutDialog = false;
                this.successDialog = true;

                // Clear cart after successful checkout
                if (typeof this.clearCart === 'function') {
                    this.clearCart();
                } else {
                    this.details.splice(0, this.details.length);
                }
            } catch (err: any) {
                this.errorMessage = 'Error de conexión. Inténtalo de nuevo.';
            } finally {
                this.loading = false;
            }
        },

        closeSuccessModal() {
            this.successDialog = false;
            this.createdOrders = [];
        }
    }
}
</script>

<template>
    <div>
        <v-card elevation="3" rounded="lg" class="pa-4">
            <v-card-title class="d-flex align-center font-weight-bold">
                <v-icon color="primary" class="mr-2">mdi-cart-check</v-icon>
                Resumen de la Compra
            </v-card-title>
            <v-card-subtitle class="text-h6 text-primary font-weight-bold my-2">
                Total a pagar: ${{ totalAmount.toLocaleString() }}
            </v-card-subtitle>
            <v-card-text>
                <v-btn
                    color="primary"
                    size="large"
                    block
                    prepend-icon="mdi-shopping-outline"
                    :disabled="details.length === 0"
                    @click="openCheckoutModal"
                >
                    Realizar Pedido
                </v-btn>
            </v-card-text>
        </v-card>

        <!-- Modal de Formulario de Datos del Cliente -->
        <v-dialog v-model="checkoutDialog" max-width="550px">
            <v-card rounded="lg" class="pa-4">
                <v-card-title class="d-flex align-center">
                    <v-icon color="primary" class="mr-2">mdi-account-box</v-icon>
                    <span class="font-weight-bold">Datos para Entrega y Pedido</span>
                </v-card-title>

                <v-divider class="my-3"></v-divider>

                <v-card-text>
                    <v-alert v-if="errorMessage" type="error" variant="tonal" class="mb-4" closable>
                        {{ errorMessage }}
                    </v-alert>

                    <form @submit.prevent="processCheckout">
                        <v-text-field
                            v-model="customer.name"
                            label="Nombre y Apellidos *"
                            variant="outlined"
                            prepend-inner-icon="mdi-account"
                            required
                        ></v-text-field>

                        <v-text-field
                            v-model="customer.phone"
                            label="Teléfono / WhatsApp de Contacto *"
                            variant="outlined"
                            prepend-inner-icon="mdi-phone"
                            required
                        ></v-text-field>

                        <v-text-field
                            v-model="customer.address"
                            label="Dirección de Entrega / Barrio"
                            variant="outlined"
                            prepend-inner-icon="mdi-map-marker"
                        ></v-text-field>

                        <v-text-field
                            v-model="customer.email"
                            label="Correo Electrónico (opcional)"
                            variant="outlined"
                            type="email"
                            prepend-inner-icon="mdi-email"
                        ></v-text-field>

                        <v-textarea
                            v-model="customer.notes"
                            label="Notas adicionales para el vendedor"
                            variant="outlined"
                            rows="2"
                        ></v-textarea>

                        <div class="d-flex justify-end ga-2 mt-4">
                            <v-btn variant="text" @click="checkoutDialog = false">Cancelar</v-btn>
                            <v-btn
                                color="primary"
                                type="submit"
                                size="large"
                                :loading="loading"
                                prepend-icon="mdi-check-circle"
                            >
                                Confirmar Pedido
                            </v-btn>
                        </div>
                    </form>
                </v-card-text>
            </v-card>
        </v-dialog>

        <!-- Modal Éxito y Enlace a WhatsApp -->
        <v-dialog v-model="successDialog" max-width="550px" persistent>
            <v-card rounded="lg" class="pa-6 text-center">
                <v-icon size="64" color="success" class="mb-3">mdi-check-circle-outline</v-icon>
                <h3 class="text-h5 font-weight-bold mb-2">¡Pedido Registrado con Éxito!</h3>
                <p class="text-body-2 text-medium-emphasis mb-4">
                    Tu pedido ha sido guardado en el sistema y notificado a la tienda. Haz clic a continuación para enviar la notificación directa por WhatsApp.
                </p>

                <div v-for="order in createdOrders" :key="order.id" class="bg-grey-darken-4 pa-4 rounded mb-4 text-left">
                    <div class="d-flex justify-space-between align-center mb-1">
                        <span class="font-weight-bold text-primary">N° {{ order.order_number }}</span>
                        <span class="text-caption font-weight-bold">${{ Number(order.total).toLocaleString() }}</span>
                    </div>
                    <div class="text-caption text-medium-emphasis mb-3">Tienda: {{ order.store_name }}</div>
                    <v-btn
                        color="success"
                        variant="elevated"
                        block
                        prepend-icon="mdi-whatsapp"
                        :href="order.whatsapp_link"
                        target="_blank"
                    >
                        Notificar a {{ order.store_name }} por WhatsApp
                    </v-btn>
                </div>

                <v-btn color="secondary" variant="text" class="mt-2" @click="closeSuccessModal">
                    Cerrar y Volver a la Tienda
                </v-btn>
            </v-card>
        </v-dialog>
    </div>
</template>
