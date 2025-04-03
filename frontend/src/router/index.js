import { createRouter, createWebHistory } from "vue-router";
import ConsultasView from "../views/ConsultasView.vue";

const routes = [
  { path: "/", component: ConsultasView },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
