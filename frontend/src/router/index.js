import { createRouter, createWebHistory } from "vue-router";
import ConsultasView from "../views/ConsultasView.vue";
import PacientesView from "@/views/PacientesView.vue";
import PacientesFormView from "@/views/PacientesFormView.vue";
import ConsultasFormView from "@/views/ConsultasFormView.vue";
import LoginView from "@/views/LoginView.vue";

const routes = [
  { path: "/", redirect: "/login" },
  { path: "/login", name: "login", component: LoginView },
  { path: "/consultas", name: "consultas", component: ConsultasView, meta: { requiresAuth: true } },
  { path: "/pacientes", name: "pacientes", component: PacientesView, meta: { requiresAuth: true } },
  { path: "/pacientes/cadastrar", name: "cadastroPacientes", component: PacientesFormView, props: {modo: "cadastrar"}, meta: { requiresAuth: true } },
  { path: "/consultas/cadastrar", name: "cadastroConsultas", component: ConsultasFormView, props: {modo: "cadastrar"}, meta: { requiresAuth: true } },
  { path: "/pacientes/editar/:id", name: "editarPacientes", component: PacientesFormView, props: route => ({ modo: 'editar', id: route.params.id }), meta: { requiresAuth: true } },
  { path: "/consultas/editar/:id", name: "editarConsultas", component: ConsultasFormView, props: route => ({ modo: 'editar', id: route.params.id }), meta: { requiresAuth: true } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

const publicPages = ['login'];
router.beforeEach((to, from, next) => {
  const authRequired = !publicPages.includes(to.name);
  const isAuthenticated = !!localStorage.getItem('token');

  if (authRequired && !isAuthenticated) {
    return next({ name: 'login' });
  }

  if (to.name === 'login' && isAuthenticated) {
    return next({ name: 'consultas' });
  }

  next();
});

export default router;
