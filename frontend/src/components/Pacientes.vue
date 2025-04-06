<template>
  <div>
    <div class="titulo-header">
      <h2>Pacientes</h2>
      <a-button type="primary" @click="irParaCadastro">
        + Cadastrar
      </a-button>
    </div>

    <a-list bordered :data-source="pacientes" :loading="carregando">
      <template #renderItem="{ item }">
        <a-list-item>
          {{ item.first_name }} {{ item.last_name }}
          <template #actions>
            <a @click="editarPaciente(item.id)">Editar</a>
            <a @click="deletarPaciente(item.id)" style="color: red">Excluir</a>
          </template>
        </a-list-item>
      </template>
    </a-list>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { List, Button } from 'ant-design-vue';

export default {
  components: {
    'a-list': List,
    'a-list-item': List.Item,
    'a-button': Button,
  },
  setup() {
    const pacientes = ref([]);
    const carregando = ref(false);
    const router = useRouter();

    const carregarPacientes = async () => {
      try {
        carregando.value = true;
        const response = await axios.get('http://127.0.0.1:8000/api/pacientes');
        pacientes.value = response.data;
      } catch (error) {
        console.error('Erro ao buscar pacientes:', error);
      } finally {
        carregando.value = false;
      }
    };

    const irParaCadastro = () => {
      router.push('/pacientes/cadastrar');
    };

    const editarPaciente = (id) => {
      router.push(`/pacientes/editar/${id}`);
    };

    const deletarPaciente = async (id) => {
      try {
        await axios.delete(`http://127.0.0.1:8000/api/pacientes/${id}`);
        await carregarPacientes(); // recarrega a lista
      } catch (err) {
        console.error("Erro ao deletar paciente:", err);
      }
    };

    onMounted(carregarPacientes);

    return { pacientes, carregando, irParaCadastro, deletarPaciente, editarPaciente };
  },
};
</script>

<style scoped>
.titulo-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
}
</style>
