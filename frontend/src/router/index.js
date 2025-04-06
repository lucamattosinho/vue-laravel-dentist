import { createRouter, createWebHistory } from "vue-router";
import ConsultasView from "../views/ConsultasView.vue";
import PacientesView from "@/views/PacientesView.vue";
import CadastroPacientesView from "@/views/CadastroPacientesView.vue";

const routes = [
  { path: "/", redirect: "/consultas" },
  { path: "/consultas", name: "consultas", component: ConsultasView },
  { path: "/pacientes", name: "pacientes", component: PacientesView },
  { path: "/pacientes/cadastrar", name: "cadastroPacientes", component: CadastroPacientesView },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
