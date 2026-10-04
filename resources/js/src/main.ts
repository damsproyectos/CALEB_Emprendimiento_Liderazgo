import { createApp } from 'vue'
// import Contador from './examples/ContadorOptions.vue'
// import Contador from './examples/ContadorComposition.vue'
// import ProductList from './examples/ProductList.vue'
import App from './App.vue'   // ****App es nuestro Componente PRINCIPAL***

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

//Pinia
import { createPinia } from 'pinia'

//Vue Router
import router from './router'

// Icons
import '@mdi/font/css/materialdesignicons.css'

const vuetify = createVuetify({
  components,
  directives,
  theme: {
    defaultTheme: 'dark'
  }
});

// const app = createApp(ProductList)
const app = createApp(App) // ****App es nuestro componente PRINCIPAL***

app.use(vuetify)
app.use(router)
app.use(createPinia())

app.mount('#app')
