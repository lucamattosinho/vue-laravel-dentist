<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";

const pacientes = ref([]);

const carregarPacientes = async () => {
  try {
    const response = await api.get("/pacientes");
    pacientes.value = response.data;
  } catch (error) {
    console.error("Erro ao carregar pacientes:", error);
  }
};

onMounted(() => {
  carregarPacientes();
});
</script>

<template>
  <div class="container">
    <h1>Pacientes</h1>
    <ul>
      <li v-for="paciente in pacientes" :key="paciente.id">
        {{ paciente.nome }} - {{ paciente.idade }} anos
      </li>
    </ul>
  </div>
</template>

<style scoped>
.container {
  padding: 0px;
}
</style>
