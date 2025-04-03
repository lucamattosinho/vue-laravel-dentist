<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";

const consultas = ref([]);

const carregarConsultas = async () => {
  try {
    const response = await api.get("/consultas");
    consultas.value = response.data;
  } catch (error) {
    console.error("Erro ao carregar consultas:", error);
  }
};

onMounted(() => {
  carregarConsultas();
});
</script>

<template>
  <div class="container">
    <h1>Consultas</h1>
    <ul>
      <li v-for="consulta in consultas" :key="consulta.id">
        {{ consulta.tratamento }} - {{ consulta.data_hora }}
      </li>
    </ul>
  </div>
</template>

<style scoped>
.container {
  padding: 20px;
}
</style>
