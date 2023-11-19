import { createApp } from 'vue';
import Products from './Products.vue';
import Antd from 'ant-design-vue';

const app = createApp(Products);
app.use(Antd);
app.mount('#products');
