<template>
  <div>
    <div class="titulo-header">
      <h2>Pacientes</h2>
      <a-button type="primary" @click="irParaCadastro">
        + Cadastrar
      </a-button>
    </div>
    <a-space direction="vertical" style="width: 100%">
      <a-input
        v-model:value="nameFilter"
        placeholder="Filtrar por nome"
        style="width: 100%"
        @input="filterName"
        class="form-half"
      />
      <a-list bordered :data-source="pacientesFiltrados" :loading="carregando">
        <template #renderItem="{ item }">
          <a-list-item>
            {{ item.first_name }} {{ item.last_name }}
            <template #actions>
              <a @click="editarPaciente(item.id)">Editar</a>
              <a-popconfirm
                  title="Tem certeza que deseja excluir este paciente?"
                  ok-text="Sim"
                  cancel-text="Não"
                  @confirm="deletarPaciente(item.id)"
              >
              <a style="color: red">Excluir</a>
              </a-popconfirm>
            </template>
          </a-list-item>
        </template>
      </a-list>
    </a-space>
  </div>
</template>

<script>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { List, Button, Input, Popconfirm, Space } from 'ant-design-vue';

export default {
  components: {
    'a-list': List,
    'a-list-item': List.Item,
    'a-button': Button,
    'a-input': Input,
    'a-popconfirm': Popconfirm,
    'a-space': Space,
  },
  setup() {
    const pacientes = ref([]);
    const carregando = ref(false);
    const router = useRouter();
    const nameFilter = ref('');

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

    const pacientesFiltrados = computed(() => {
      return pacientes.value.filter(paciente => {
        const nomeCompleto = `${paciente.first_name} ${paciente.last_name}`.toLowerCase();
        const matchesName = !nameFilter.value || nomeCompleto.includes(nameFilter.value.toLowerCase());
        return matchesName;
      });
    });

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

    return { 
      pacientes, 
      carregando, 
      irParaCadastro, 
      deletarPaciente, 
      editarPaciente,
      nameFilter,
      pacientesFiltrados,
      carregarPacientes,
    };
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
