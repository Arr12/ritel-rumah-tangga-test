import { createApp } from 'vue';
import Dashboard from './Dashboard.vue';
import Antd from 'ant-design-vue';

const app = createApp(Dashboard);
app.use(Antd);
app.mount('#dashboard');
