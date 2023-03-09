require('./bootstrap');

import { createApp } from 'vue';
import Connections from './components/Connections';

// const app = createApp({});
// app.component('connections', Connections);
// app.mount('#app');

createApp({
    components: {
      Connections
    }
}).mount("#app");


