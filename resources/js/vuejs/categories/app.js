import { createApp } from 'vue';
import Categories from './Categories.vue';
import Antd from 'ant-design-vue';

const app = createApp(Categories);
app.use(Antd);
app.mount('#categories');
