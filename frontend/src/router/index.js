import { createRouter, createWebHistory } from "vue-router";
import ConsultasView from "../views/ConsultasView.vue";
import PacientesView from "@/views/PacientesView.vue";
import PacientesFormView from "@/views/PacientesFormView.vue";
import ConsultasFormView from "@/views/ConsultasFormView.vue";

const routes = [
  { path: "/", redirect: "/consultas" },
  { path: "/consultas", name: "consultas", component: ConsultasView },
  { path: "/pacientes", name: "pacientes", component: PacientesView },
  { path: "/pacientes/cadastrar", name: "cadastroPacientes", component: PacientesFormView, props: {modo: "cadastrar"} },
  { path: "/consultas/cadastrar", name: "cadastroConsultas", component: ConsultasFormView, props: {modo: "cadastrar"} },
  { path: "/pacientes/editar/:id", name: "editarPacientes", component: PacientesFormView, props: route => ({ modo: 'editar', id: route.params.id }) },
  { path: "/consultas/editar/:id", name: "editarConsultas", component: ConsultasFormView, props: route => ({ modo: 'editar', id: route.params.id }) },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
