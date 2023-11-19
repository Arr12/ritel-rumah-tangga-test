import { createApp } from 'vue';
import Products from './Users.vue';
import Antd from 'ant-design-vue';

const app = createApp(Products);
app.use(Antd);
app.mount('#users');
